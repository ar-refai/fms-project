<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    // Show all clients
    // Show all clients
    public function index()
    {
        try {
            Log::info('Fetching all clients and projects');
            $clients = Client::all();
            $projects = Project::all();
            $projectsWithoutQuotations = Project::where('has_quotation', false)->get();

            Log::info('Clients , projects and projectsWithoutQuotations fetched successfully');

            $dashboardData = Project::with(['client', 'expenses', 'incomes'])->get()->map(function ($project) {
                Log::info('Processing project data', ['project_id' => $project->id]);

                // Calculations
                $contractedRevenue = $project->contracted_revenue;

                // Accounts Receivables (Contracted Revenue - sum of all incomes for the project)
                $accountsReceivables = $contractedRevenue - $project->incomes->sum('total_amount');

                // Costs (grouped by type)
                $supplyCost = $project->expenses->where('expense_type', 'Material Purchases')->sum('total_amount');
                $applyCost = $project->expenses->where('expense_type', 'Fabrication & Installation')->sum('total_amount');
                $logisticsCost = $project->expenses
                    ->whereIn('expense_type', ['Logistics', 'Other Expenses'])
                    ->sum('total_amount');

                // Gross Profit (Contracted Revenue - Total Costs)
                $grossProfit = $contractedRevenue - ($supplyCost + $applyCost + $logisticsCost);

                // GPM (Gross Profit Margin as a percentage)
                $gpm = $contractedRevenue > 0 ? ($grossProfit / $contractedRevenue) * 100 : 0;

                Log::info('Project data processed', ['project_id' => $project->id, 'gross_profit' => $grossProfit, 'gpm' => $gpm]);

                return [
                    'client_id' => $project->client->client_code ?? null,
                    'project_id' => $project->project_id,
                    'project_validation_date' => $project->project_validation_date,
                    'client' => $project->client->client_name ?? 'N/A',
                    'type' => $project->client->client_type ?? 'N/A',
                    'project' => $project->project_name,
                    'contracted_revenue' => $contractedRevenue,
                    'accounts_receivables' => $accountsReceivables,
                    'collection_rate' => $contractedRevenue > 0 ? ($project->incomes->sum('total_amount') / $contractedRevenue) * 100 : 0,
                    'supply_cost' => $supplyCost,
                    'apply_cost' => $applyCost,
                    'logistics_cost' => $logisticsCost,
                    'gross_profit' => $grossProfit,
                    'gpm' => round($gpm, 2), // Rounded to 2 decimal places
                    'status' => $project->status,
                ];
            });

            return view('clients', compact('clients', 'dashboardData', 'projects','projectsWithoutQuotations'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch clients and projects:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to fetch clients and projects: ' . $e->getMessage());
        }
    }

    // Show a form for creating a new client
    public function create()
    {
        Log::info('Loading client creation form');
        return view('clients.create');
    }

    // Store a new client in the database
    public function store(Request $request)
    {
        try {
            Log::info('Storing a new client');

            // Validate incoming request data (excluding client_code, since we'll generate it)
            $validatedData = $request->validate([
                'client_name' => 'required|string|max:255',
                'client_type' => 'required|string|max:255',
                'client_source'=> 'required|string|max:255'
            ]);

            Log::info('Validated Data:', $validatedData); // Log validated data

            // Automatically generate the client_code
            $lastClient = Client::orderBy('created_at', 'desc')->first();
            if ($lastClient && preg_match('/C(\d+)/', $lastClient->client_code, $matches)) {
                $lastCodeNumber = (int) $matches[1];
            } else {
                $lastCodeNumber = 0;
            }
            $nextCodeNumber = str_pad($lastCodeNumber + 1, 3, '0', STR_PAD_LEFT);
            $clientCode = 'C' . $nextCodeNumber;

            // Add client_code to validated data
            $validatedData['client_code'] = $clientCode;

            // Create a new client
            $client = Client::create($validatedData);
            Log::info('Client created successfully:', ['client_id' => $client->id]); // Log successful creation

            return redirect()->route('clients.index')->with('success', 'Client created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]); // Log validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Failed to create client:', ['message' => $e->getMessage()]); // Log general exceptions
            return redirect()->back()->with('error', 'Failed to create client: ' . $e->getMessage())->withInput();
        }
    }


    // Show a specific client
    public function show($id)
    {
        try {
            Log::info('Fetching client details', ['client_id' => $id]);
            $client = Client::findOrFail($id);
            Log::info('Client details fetched successfully', ['client_id' => $id]);
            return view('clients.show', compact('client'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch client details:', ['client_id' => $id, 'message' => $e->getMessage()]);
            return redirect()->route('clients.index')->with('error', 'Failed to fetch client details: ' . $e->getMessage());
        }
    }

    // Show the form to edit a specific client
    public function edit($id)
    {
        try {
            Log::info('Loading client edit form', ['client_id' => $id]);
            $client = Client::findOrFail($id);
            Log::info('Client data loaded for editing', ['client_id' => $id]);
            return view('clients.edit', compact('client'));
        } catch (\Exception $e) {
            Log::error('Failed to load client for editing:', ['client_id' => $id, 'message' => $e->getMessage()]);
            return redirect()->route('clients.index')->with('error', 'Failed to fetch client for editing: ' . $e->getMessage());
        }
    }

    // Update a specific client in the database
    public function update(Request $request, $id)
    {
        try {
            Log::info('Updating client', ['client_id' => $id]);
            $client = Client::findOrFail($id);

            $validatedData = $request->validate([
                'client_name' => 'required|string|max:255',
                'client_type' => 'required|string|max:255',
            ],[],[],'editClient');

            $client->update($validatedData);
            Log::info('Client updated successfully', ['client_id' => $id]);

            return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update client:', ['client_id' => $id, 'message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update client: ' . $e->getMessage())->withInput();
        }
    }

    // Delete a specific client from the database
    public function destroy($id)
    {
        try {
            Log::info('Deleting client', ['client_id' => $id]);
            $client = Client::findOrFail($id);
            $client->delete();
            Log::info('Client deleted successfully', ['client_id' => $id]);

            return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete client:', ['client_id' => $id, 'message' => $e->getMessage()]);
            return redirect()->route('clients.index')->with('error', 'Failed to delete client: ' . $e->getMessage());
        }
    }
}
