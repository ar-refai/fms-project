<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('Fetching all expenses');
            $expenses = Expense::with(['project', 'client'])->get();
            $projects = Project::all();
            $clients = Client::all();
            Log::info('Expenses fetched successfully', ['expenses_count' => $expenses->count()]);

            return view('expenses', compact('expenses', 'projects', 'clients'));
        } catch (\Exception $e) {
            Log::error('Error fetching expenses: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to load expenses. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Log::info('Loading expense creation form');
            $projects = Project::all();
            $clients = Client::all();
            return view('expenses.create', compact('projects', 'clients'));
        } catch (\Exception $e) {
            Log::error('Error loading expense creation form: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to load the expense creation form.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Validating expense creation request.', ['request_data' => $request->all()]);

            // dd($request->all());
            $data = $request->validate([
                'date' => 'required|date',
                'accounting_id' => 'required|string', // No longer unique
                'expense_type' => 'required|in:Logistics,Material Purchases,Fabrication & Installation,G&A,Factory,Other Expenses',
                'designation' => 'nullable|string', // Nullable client name
                'basis' => 'nullable|string', // Nullable project name
                'description' => 'nullable|string',
                'unit' => 'nullable|in:Set,No,Sheet,SQM,Roll,Pack,Ampula,L.S,Strip,Box,Cubic Meter,K.G',
                'unit_rate' => 'nullable|numeric|min:0',
                'quantity' => 'nullable|integer|min:0',
                'total_amount' => 'required|numeric|min:0',
                'recipient' => 'required|string',
                'client_id' => 'nullable|exists:clients,id',
                'project_id' => 'nullable|exists:projects,id',
            ]);
            Log::info('Expense data validated successfully.', ['validated_data' => $data]);

            Expense::create($data);
            Log::info('Expense record created successfully.', ['accounting_id' => $data['accounting_id']]);

            return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating expense: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to create expense. Please try again later.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        try {
            Log::info('Loading expense edit form.', ['expense_id' => $expense->id]);
            $projects = Project::all();
            $clients = Client::all();
            return view('expenses.edit', compact('expense', 'projects', 'clients'));
        } catch (\Exception $e) {
            Log::error('Error loading expense edit form: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to load the expense edit form.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Validating expense update request.', ['expense_id' => $id, 'request_data' => $request->all()]);
            $expense = Expense::findOrFail($id);

            $data = $request->validate([
                'date' => 'required|date',
                'accounting_id' => 'required|string', // No longer unique
                'expense_type' => 'required|in:Logistics,Material Purchases,Fabrication & Installation,G&A,Factory,Other Expenses',
                'designation' => 'nullable|string',
                'basis' => 'nullable|string',
                'description' => 'nullable|string',
                'unit' => 'nullable|in:Set,No,Sheet,SQM,Roll,Pack,Ampula,L.S,Strip,Box,Cubic Meter,K.G',
                'unit_rate' => 'nullable|numeric|min:0',
                'quantity' => 'nullable|integer|min:0',
                'total_amount' => 'required|numeric|min:0',
                'recipient' => 'required|string',
                'client_id' => 'nullable|exists:clients,id',
                'project_id' => 'nullable|exists:projects,id',
            ]);

            Log::info('Expense data validated successfully for update.', ['validated_data' => $data]);

            $expense->update($data);
            Log::info('Expense record updated successfully.', ['expense_id' => $expense->id]);

            return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Expense not found: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Expense not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating expense: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to update expense. Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Log::info('Attempting to delete expense.', ['expense_id' => $id]);
            $expense = Expense::findOrFail($id);
            $expense->delete();
            Log::info('Expense deleted successfully.', ['expense_id' => $id]);

            return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Expense not found: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Expense not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting expense: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to delete expense. Please try again later.');
        }
    }
}
