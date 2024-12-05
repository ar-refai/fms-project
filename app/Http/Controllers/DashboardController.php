<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Project;
use App\Models\Treasury;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Revenue
        $totalRevenue = Income::sum('total_amount');

        // Total Collection
        $totalCollection = Income::whereNotNull('collection_type')->sum('total_amount');

        // Total Accounts Receivables
        $totalAccountsReceivables = $totalRevenue - $totalCollection;

        // Total Expenses
        $totalExpenses = Expense::sum('total_amount');
        $totalCOGS = Expense::whereIn('expense_type', ['Material Purchases', 'Fabrication & Installation'])->sum('total_amount');
        $totalSupplyCosts = Expense::where('expense_type', 'Material Purchases')->sum('total_amount');
        $totalApplyCosts = Expense::where('expense_type', 'Fabrication & Installation')->sum('total_amount');
        $totalLogisticsCosts = Expense::where('expense_type', 'Logistics')->sum('total_amount');
        $totalGAndAExpenses = Expense::where('expense_type', 'G&A')->sum('total_amount');
        $totalOperatingExpenses = Expense::whereNotIn('expense_type', ['Material Purchases', 'Fabrication & Installation', 'G&A', 'Logistics'])->sum('total_amount');

        // Liquidity
        $cashInTreasury = Treasury::where('type', 'Cash')->sum('amount');
        $creditLines = Treasury::where('type', 'Credit Line')->sum('amount');
        $bankBalance = Treasury::where('type', 'Bank')->sum('amount'); // Assuming bank balance comes from a Treasury type entry
        $liquidity = $cashInTreasury + $creditLines + $bankBalance;

        // Projects Information
        $totalProjectsSold = Project::where('status', 'Completed')->count();
        $pendingProjects = Project::where('status', 'Pending')->count();
        $pendingProjectsValue = Project::where('status', 'Pending')->sum('contracted_revenue');

        // Profit Calculations
        $netProfit = $totalRevenue - $totalExpenses;
        $grossProfitMargin = $totalRevenue > 0 ? (($totalRevenue - $totalCOGS) / $totalRevenue) * 100 : 0;
        $netProfitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;

        // Stakeholder Balances (Assuming stakeholders are tracked in another table or model)
        $stakeholderBalances = [
            'Staron Egypt for Manufacturing' => Treasury::where('type', 'Stakeholder')->where('description', 'Staron Egypt for Manufacturing')->sum('amount'),
            'Staron Egypt for Contracting' => Treasury::where('type', 'Stakeholder')->where('description', 'Staron Egypt for Contracting')->sum('amount'),
            'Eng. Tarek El Behairy' => Treasury::where('type', 'Stakeholder')->where('description', 'Eng. Tarek El Behairy')->sum('amount'),
        ];

        // Compile all data into an array
        $dashboardData = [
            'total_revenue' => $totalRevenue,
            'total_collection' => $totalCollection,
            'total_accounts_receivables' => $totalAccountsReceivables,
            'total_expenses' => $totalExpenses,
            'total_cogs' => $totalCOGS,
            'total_supply_costs' => $totalSupplyCosts,
            'total_apply_costs' => $totalApplyCosts,
            'total_logistics_costs' => $totalLogisticsCosts,
            'total_gna_expenses' => $totalGAndAExpenses,
            'total_operating_expenses' => $totalOperatingExpenses,
            'liquidity' => $liquidity,
            'cash_in_treasury' => $cashInTreasury,
            'credit_lines' => $creditLines,
            'bank_balance' => $bankBalance,
            'total_projects_sold' => $totalProjectsSold,
            'pending_projects' => $pendingProjects,
            'pending_projects_value' => $pendingProjectsValue,
            'net_profit' => $netProfit,
            'gross_profit_margin' => round($grossProfitMargin, 2),
            'net_profit_margin' => round($netProfitMargin, 2),
            'stakeholder_balances' => $stakeholderBalances,
        ];

        return view('dashboard', compact('dashboardData'));
    }
}
