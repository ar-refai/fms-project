<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Funds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FundsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $funds = Funds::orderBy('date', 'asc')->get();
            return view('funds', compact('funds'));
        } catch (\Exception $e) {
            Log::error('Error fetching funds: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to load fund records. Please try again later.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('funds.create');
        } catch (\Exception $e) {
            Log::error('Error loading fund creation form: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to load the fund creation form.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'stakeholder' => 'required|string|max:255',
                'date' => 'required|date',
                'accounting_id' => 'required|string|unique:funds,accounting_id',
                'description' => 'nullable|string',
                'transaction_type' => 'required|in:to,from',
                'amount' => 'required|numeric|min:0',
            ]);

            Funds::create($validatedData);

            return redirect()->route('funds.index')->with('success', 'Fund record added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating fund record: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to create fund record. Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Funds $fund)
    {
        try {
            return view('funds.show', compact('fund'));
        } catch (\Exception $e) {
            Log::error('Error displaying fund record: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to load fund record details.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Funds $fund)
    {
        try {
            return view('funds.edit', compact('fund'));
        } catch (\Exception $e) {
            Log::error('Error loading fund edit form: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to load the fund edit form.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $fund = Funds::findOrFail($id);

            $validatedData = $request->validate([
                'stakeholder' => 'required|string|max:255',
                'date' => 'required|date',
                'accounting_id' => 'required|string|unique:funds,accounting_id,' . $fund->id,
                'description' => 'nullable|string',
                'transaction_type' => 'required|in:to,from',
                'amount' => 'required|numeric|min:0',
            ]);

            $fund->update($validatedData);

            return redirect()->route('funds.index')->with('success', 'Fund record updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Fund record not found: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Fund record not found.']);
        } catch (\Exception $e) {
            Log::error('Error updating fund record: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to update fund record. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fund = Funds::findOrFail($id);
            $fund->delete();

            return redirect()->route('funds.index')->with('success', 'Fund record deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Fund record not found: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Fund record not found.']);
        } catch (\Exception $e) {
            Log::error('Error deleting fund record: ' . $e->getMessage());
            return redirect()->route('funds.index')->withErrors(['error' => 'Failed to delete fund record. Please try again later.']);
        }
    }
}
