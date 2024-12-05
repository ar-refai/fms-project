<?php

namespace App\Http\Controllers;

use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TreasuryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $treasuries = Treasury::orderBy('date', 'asc')->get();
            return view('treasury', compact('treasuries'));
        } catch (\Exception $e) {
            Log::error('Error fetching treasuries: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Failed to load treasury records. Please try again later.']);
        }
    }

    /**
     * Initialize the treasury with the first record.
     */
    public function startTreasury(Request $request)
    {
        try {
            $existingStart = Treasury::where('treasury_id', 'T0000SB')->first();

            if ($existingStart) {
                return redirect()->route('treasury.index')->withErrors(['error' => 'Treasury already started.']);
            }

            $validatedData = $request->validate([
                'date' => 'required|date',
            ]);

            Treasury::create([
                'treasury_id' => 'T0000SB',
                'date' => $validatedData['date'],
                'starting_balance' => 0,
                'type' => 'no flow',
                'amount' => 0,
                'description' => 'Treasury starting balance',
                'ending_balance' => 0,
            ]);

            return redirect()->route('treasury.index')->with('success', 'Treasury initialized successfully.');
        } catch (\Exception $e) {
            Log::error('Error starting treasury: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Failed to start treasury. Please try again later.']);
        }
    }

    /**
     * Update the start treasury record.
     */
    public function updateStartTreasury(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date' => 'required|date',
            ]);

            $treasury = Treasury::where('treasury_id', 'T0000SB')->firstOrFail();
            $treasury->update(['date' => $validatedData['date']]);

            return redirect()->route('treasury.index')->with('success', 'Treasury start date updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Starting treasury record not found: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Starting treasury record not found.']);
        } catch (\Exception $e) {
            Log::error('Error updating start treasury: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Failed to update treasury record. Please try again later.']);
        }
    }

    /**
     * Store a newly created treasury record.
     */
    public function store(Request $request)
    {
        try {
            $startingTreasury = Treasury::where('treasury_id', 'T0000SB')->first();
            if (!$startingTreasury) {
                return redirect()->route('treasury.index')->withErrors(['error' => 'Treasury has not been started. Please start the treasury first.']);
            }

            $validatedData = $request->validate([
                'date' => 'required|date',
                'type' => 'required|string|in:in flow,out flow',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            $lastTreasury = Treasury::orderBy('date', 'desc')->first();
            $startingBalance = $lastTreasury ? $lastTreasury->ending_balance : 0;

            $endingBalance = $validatedData['type'] === 'in flow'
                ? $startingBalance + $validatedData['amount']
                : $startingBalance - $validatedData['amount'];

            $lastId = Treasury::latest('id')->value('id') ?? 0;
            $treasuryId = sprintf('TR%04d', $lastId + 1);

            $newTreasury = Treasury::create([
                'treasury_id' => $treasuryId,
                'date' => $validatedData['date'],
                'starting_balance' => $startingBalance,
                'type' => $validatedData['type'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'ending_balance' => $endingBalance,
            ]);

            $this->updateSubsequentBalances($newTreasury);

            return redirect()->route('treasury.index')->with('success', 'Treasury record added successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating treasury record: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Failed to create treasury record. Please try again later.']);
        }
    }

    /**
     * Update the specified treasury record in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $treasury = Treasury::findOrFail($id);

            $validatedData = $request->validate([
                'date' => 'required|date',
                'type' => 'required|string|in:in flow,out flow',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);

            $startingBalance = $treasury->starting_balance;
            $endingBalance = $validatedData['type'] === 'in flow'
                ? $startingBalance + $validatedData['amount']
                : $startingBalance - $validatedData['amount'];

            $treasury->update([
                'date' => $validatedData['date'],
                'type' => $validatedData['type'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'ending_balance' => $endingBalance,
            ]);

            $this->updateSubsequentBalances($treasury);

            return redirect()->route('treasury.index')->with('success', 'Treasury record updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating treasury record: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Failed to update treasury record. Please try again later.']);
        }
    }

    /**
     * Update balances for all subsequent records.
     */
    private function updateSubsequentBalances($currentTreasury)
    {
        $treasuries = Treasury::where('date', '>', $currentTreasury->date)->orderBy('date', 'asc')->get();
        $startingBalance = $currentTreasury->ending_balance;

        foreach ($treasuries as $treasury) {
            $treasury->update([
                'starting_balance' => $startingBalance,
                'ending_balance' => $treasury->type === 'in flow'
                    ? $startingBalance + $treasury->amount
                    : $startingBalance - $treasury->amount,
            ]);

            $startingBalance = $treasury->ending_balance;
        }
    }

    /**
     * Remove the specified treasury record from storage.
     */
    public function destroy($id)
    {
        try {
            $treasury = Treasury::findOrFail($id);
            $treasury->delete();

            $this->updateSubsequentBalances($treasury);

            return redirect()->route('treasury.index')->with('success', 'Treasury record deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting treasury record: ' . $e->getMessage());
            return redirect()->route('treasury.index')->withErrors(['error' => 'Failed to delete treasury record. Please try again later.']);
        }
    }
}
