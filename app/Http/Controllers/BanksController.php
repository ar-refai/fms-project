<?php

namespace App\Http\Controllers;

use App\Models\Banks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transactions = Banks::orderBy('date', 'asc')->get();
            return view('banks', compact('transactions'));
        } catch (\Exception $e) {
            Log::error('Error fetching bank transactions: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to load bank transactions. Please try again later.']);
        }
    }

    /**
     * Initialize the bank with the first record.
     */
    public function startBank(Request $request)
    {
        try {
            $existingStart = Banks::where('transaction_id', 'B0000SB')->first();

            if ($existingStart) {
                return redirect()->route('banks.index')->withErrors(['error' => 'Bank already started.']);
            }

            $validatedData = $request->validate([
                'date' => 'required|date',
            ]);

            Banks::create([
                'transaction_id' => 'B0000SB',
                'date' => $validatedData['date'],
                'starting_balance' => 0,
                'type' => 'no flow',
                'amount' => 0,
                'description' => 'Bank starting balance',
                'ending_balance' => 0,
            ]);

            return redirect()->route('banks.index')->with('success', 'Bank initialized successfully.');
        } catch (\Exception $e) {
            Log::error('Error starting bank: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to start bank. Please try again later.']);
        }
    }

    /**
     * Update the start bank record.
     */
    public function updateStartBank(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date' => 'required|date',
            ]);

            $bank = Banks::where('transaction_id', 'B0000SB')->firstOrFail();
            $bank->update(['date' => $validatedData['date']]);

            return redirect()->route('banks.index')->with('success', 'Bank start date updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Starting bank record not found: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Starting bank record not found.']);
        } catch (\Exception $e) {
            Log::error('Error updating start bank: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to update bank record. Please try again later.']);
        }
    }

    /**
     * Create a new bank transaction.
     */
    public function store(Request $request)
    {
        try {
            // Ensure the bank has been started
            $startingBank = Banks::where('transaction_id', 'B0000SB')->first();
            if (!$startingBank) {
                return redirect()->route('banks.index')->withErrors(['error' => 'Bank has not been started. Please start the bank first.']);
            }

            $validatedData = $request->validate([
                'date' => 'required|date',
                'type' => 'required|string|in:in flow,out flow',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            // Get the last record to calculate the new starting balance
            $lastBank = Banks::orderBy('date', 'desc')->first();
            $startingBalance = $lastBank ? $lastBank->ending_balance : 0;

            // Calculate ending balance based on type
            $endingBalance = $validatedData['type'] === 'in flow'
                ? $startingBalance + $validatedData['amount']
                : $startingBalance - $validatedData['amount'];

            // Generate Transaction ID
            $lastId = Banks::latest('id')->value('id') ?? 0;
            $transactionId = sprintf('TX%04d', $lastId + 1);

            // Create the new transaction
            $newTransaction = Banks::create([
                'transaction_id' => $transactionId,
                'date' => $validatedData['date'],
                'starting_balance' => $startingBalance,
                'type' => $validatedData['type'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'ending_balance' => $endingBalance,
            ]);

            // Update the starting balance of the next row, if any
            $nextTransaction = Banks::where('date', '>', $newTransaction->date)->orderBy('date', 'asc')->first();
            if ($nextTransaction) {
                $nextTransaction->update(['starting_balance' => $newTransaction->ending_balance]);
            }

            return redirect()->route('banks.index')->with('success', 'Bank transaction added successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating bank transaction: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to create bank transaction. Please try again later.']);
        }
    }

    /**
     * Display the specified transaction.
     */
    public function show(Banks $bank)
    {
        try {
            return view('banks.show', compact('bank'));
        } catch (\Exception $e) {
            Log::error('Error displaying bank transaction: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to load bank transaction details.']);
        }
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Banks $bank)
    {
        try {
            return view('banks.edit', compact('bank'));
        } catch (\Exception $e) {
            Log::error('Error loading bank edit form: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to load the bank edit form.']);
        }
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $bank = Banks::findOrFail($id);

            $validatedData = $request->validate([
                'date' => 'required|date',
                'type' => 'required|string|in:in flow,out flow',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            // Calculate the updated ending balance
            $startingBalance = $bank->starting_balance;
            $endingBalance = $validatedData['type'] === 'in flow'
                ? $startingBalance + $validatedData['amount']
                : $startingBalance - $validatedData['amount'];

            // Update the current transaction
            $bank->update([
                'date' => $validatedData['date'],
                'type' => $validatedData['type'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'ending_balance' => $endingBalance,
            ]);

            // Update the starting balance of the next transaction, if any
            $nextTransaction = Banks::where('date', '>', $bank->date)->orderBy('date', 'asc')->first();
            if ($nextTransaction) {
                $nextTransaction->update(['starting_balance' => $bank->ending_balance]);

                // Update the ending balance of subsequent transactions
                $this->updateSubsequentBalances($nextTransaction);
            }

            return redirect()->route('banks.index')->with('success', 'Bank transaction updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Bank transaction not found: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Bank transaction not found.']);
        } catch (\Exception $e) {
            Log::error('Error updating bank transaction: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to update bank transaction. Please try again later.']);
        }
    }

    private function updateSubsequentBalances($currentTransaction)
{
    $transactions = Banks::where('date', '>', $currentTransaction->date)->orderBy('date', 'asc')->get();
    $startingBalance = $currentTransaction->ending_balance;

    foreach ($transactions as $transaction) {
        $transaction->update([
            'starting_balance' => $startingBalance,
            'ending_balance' => $transaction->type === 'in flow'
                ? $startingBalance + $transaction->amount
                : $startingBalance - $transaction->amount,
        ]);

        $startingBalance = $transaction->ending_balance;
    }
}

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy($id)
    {
        try {
            $bank = Banks::findOrFail($id);
            $bank->delete();

            return redirect()->route('banks.index')->with('success', 'Bank transaction deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Bank transaction not found: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Bank transaction not found.']);
        } catch (\Exception $e) {
            Log::error('Error deleting bank transaction: ' . $e->getMessage());
            return redirect()->route('banks.index')->withErrors(['error' => 'Failed to delete bank transaction. Please try again later.']);
        }
    }
}
