<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Income;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('Fetching incomes for index view.');

            // Fetching all incomes along with related projects and clients
            $incomes = Income::with('project.client')->get();

            // Fetching all projects with related clients
            $projects = Project::with('client')->get();

            // Fetching all clients
            $clients = Client::all();
            // dd($clients);
            Log::info('Incomes, projects, and clients fetched successfully.', [
                'incomes_count' => $incomes->count(),
                'projects_count' => $projects->count(),
                'clients_count' => $clients->count(),
            ]);

            // Pass all the fetched data to the view
            return view('income', compact('projects', 'incomes', 'clients'));
        } catch (\Exception $e) {
            Log::error('Error fetching incomes: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to load incomes. Please try again later.');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Log::info('Loading income creation form.');
            $instalmentTypes = ['Instalment', 'Down-Payment', 'Finalization Invoice', 'Upfront', 'Single-Payment'];
            $projects = Project::with('client')->get();
            Log::info('Income creation form loaded successfully.', ['projects_count' => $projects->count()]);
            return view('incomes.create', compact('projects', 'instalmentTypes'));
        } catch (\Exception $e) {
            Log::error('Error loading income creation form: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to load the income creation form.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Validating income creation request.', ['request_data' => $request->all()]);
            $data = $request->validate([
                'accounting_id' => 'required|string|unique:incomes,accounting_id',
                'date' => 'required|date',
                'basis' => 'required|string|exists:projects,project_name', // Project name for basis
                'designation' => 'required|string|exists:clients,client_name', // Client name for designation
                'instalment_type' => 'required|in:Instalment,Down-Payment,Finalization Invoice,Upfront,Single-Payment',
                'total_amount' => 'required|numeric|min:0',
                'collection_type' => 'required|string',
                'project_id' => 'required|exists:projects,id', // Added project_id validation
                'client_id' => 'required|exists:clients,id', // Added client_id validation
            ]);

            Log::info('Income data validated successfully.', ['validated_data' => $data]);

            $income = Income::create($data);
            Log::info('Income record created successfully.', ['income_id' => $income->id]);

            return redirect()->route('incomes.index')->with('success', 'Income record created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating income: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to create income record. Please try again later.');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        try {
            Log::info('Displaying income details.', ['income_id' => $income->id]);
            return view('incomes.show', compact('income'));
        } catch (\Exception $e) {
            Log::error('Error displaying income: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to load income details.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        try {
            Log::info('Loading income edit form.', ['income_id' => $income->id]);
            $projects = Project::with('client')->get();
            Log::info('Income edit form loaded successfully.', ['projects_count' => $projects->count()]);
            return view('incomes.edit', compact('income', 'projects'));
        } catch (\Exception $e) {
            Log::error('Error loading income edit form: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to load the income edit form.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Validating income update request.', ['income_id' => $id, 'request_data' => $request->all()]);
            $income = Income::findOrFail($id);

            $data = $request->validate([
                'accounting_id' => 'required|string|unique:incomes,accounting_id,' . $income->id,
                'date' => 'required|date',
                'basis' => 'required|string|exists:projects,project_name', // Project name for basis
                'designation' => 'required|string|exists:clients,client_name', // Client name for designation
                'instalment_type' => 'required|in:Instalment,Down-Payment,Finalization Invoice,Upfront,Single-Payment',
                'total_amount' => 'required|numeric|min:0',
                'collection_type' => 'required|string',
                'project_id' => 'required|exists:projects,id', // Added project_id validation
                'client_id' => 'required|exists:clients,id', // Added client_id validation
            ]);

            // dd($data);
            Log::info('Income data validated successfully for update.', ['validated_data' => $data]);

            $income->update($data);
            Log::info('Income record updated successfully.', ['income_id' => $income->id]);

            return redirect()->route('incomes.index')->with('success', 'Income record updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Income not found: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Income record not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating income: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to update income record. Please try again later.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Log::info('Attempting to delete income record.', ['income_id' => $id]);
            $income = Income::findOrFail($id);
            $income->delete();
            Log::info('Income record deleted successfully.', ['income_id' => $id]);

            return redirect()->route('incomes.index')->with('success', 'Income record deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Income not found: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Income record not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting income: ' . $e->getMessage());
            return redirect()->route('incomes.index')->with('error', 'Failed to delete income record. Please try again later.');
        }
    }
}
