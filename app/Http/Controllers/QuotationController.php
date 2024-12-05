<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuotationController extends Controller
{
    public function create()
    {
        // Fetch all projects without a linked quotation
        $projectsWithoutQuotation = Project::doesntHave('quotation')->get();

        return view('quotations.create', compact('projectsWithoutQuotation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'quotation_items' => 'required|json',
        ]);

        try {
            $quotationItems = json_decode($request->quotation_items, true);
            $totalPrice = 0; // Initialize total price for all items

            foreach ($quotationItems as $item) {
                // Sum up the prices for contracted revenue calculation
                $totalPrice += $item['price'];

                // Create each quotation item
                Quotation::create([
                    'project_id' => $request->project_id,
                    'item_title' => $item['item_title'],
                    'unit' => $item['unit'],
                    'unit_rate' => $item['unit_rate'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Fetch the associated project
            $project = Project::findOrFail($request->project_id);

            // Update the project with the calculated total price and set has_quotation to true
            $project->update([
                'has_quotation' => 1,
                'contracted_revenue' => $totalPrice,
            ]);

            return redirect()->route('clients.index')->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            Log::error('Error storing quotation: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to create quotation.');
        }
    }

}
