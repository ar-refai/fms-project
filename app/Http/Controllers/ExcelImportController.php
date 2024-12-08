<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Imports\TreasuryImport;
use App\Imports\IncomeImport;
use App\Imports\ExpenseImport;
use App\Imports\FundImport;
use App\Imports\ClientImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);

        $file = $request->file('file');

        // Import each sheet
        Excel::import(new TreasuryImport, $file);
        Excel::import(new IncomeImport, $file);
        Excel::import(new ExpenseImport, $file);
        Excel::import(new FundImport, $file);
        Excel::import(new ClientImport, $file);

        return back()->with('success', 'Data imported successfully.');
    }
}
