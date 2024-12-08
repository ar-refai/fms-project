<?php


namespace App\Http\Controllers;

use App\Models\Banks;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Funds;
use App\Models\Income;
use App\Models\Project;
use App\Models\Treasury;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Fetch all projects
            $projects = Project::with(['expenses', 'incomes'])->get();

            // Total Revenue (Completed or In-Progress Projects)
            $totalRevenue = $projects
                ->whereIn('project_type', ['in_progress', 'completed'])
                ->sum('contracted_revenue');

            // Total Collection
            $totalCollection = Income::whereNotNull('collection_type')->sum('total_amount');

            // Total Accounts Receivables
            $totalAccountsReceivables = $projects->sum('contracted_revenue') - Income::sum('total_amount');

            // Total Expenses
            $totalExpenses = Expense::sum('total_amount');

            // Expense Breakdown
            $totalSupplyCosts = Expense::where('expense_type', 'Material Purchases')->sum('total_amount');
            $totalApplyCosts = Expense::where('expense_type', 'Fabrication & Installation')->sum('total_amount');
            $totalLogisticsCosts = Expense::where('expense_type', 'Logistics')->sum('total_amount'); // otherr expenses
            $totalGAndAExpenses = Expense::where('expense_type', 'G&A')->sum('total_amount');
            $factoryExpenses = Expense::where('expense_type', 'Factory')->sum('total_amount'); // check
            $otherOverheadExpenses = Expense::where('designation', 'overheads')
                ->whereIn('expense_type', ['Other Expenses', 'Logistics' , 'Material Purchases'])
                ->sum('total_amount');
            $totalOperatingExpenses = $factoryExpenses + $otherOverheadExpenses;

            // Total COGS
            $totalCOGS = $totalSupplyCosts + $totalApplyCosts + $totalLogisticsCosts;

            // Total Expenses = COGS + G&A + Operating Expenses
            $totalExpensesCalculated = $totalCOGS + $totalGAndAExpenses + $totalOperatingExpenses;

            // Liquidity
            $lastTreasuryBalance = Treasury::latest('date')->value('ending_balance') ?? 0; // last entry
            $stakeholderFunds = Funds::whereIn('stakeholder', ['Eng. Tarek El Behairy', 'Staron Egypt for Manufacturing'])->sum('amount');
            // total to's - total froms for the two stakeholders
            $lastBankBalance = Banks::latest( 'date')->value('ending_balance') ?? 0; // last entry
            $liquidity = $lastTreasuryBalance + $stakeholderFunds + $lastBankBalance;

            // Project Metrics
            $totalProjectsSold = $projects->whereIn('status',['Completed','In Progress'])->count();
            $pendingProjects = $projects->where('status', 'Pending')->count();
            $pendingProjectsValue = $projects->where('status', 'Pending')->sum('contracted_revenue');

            // Profit Calculations
            $netProfit = $totalRevenue - $totalExpensesCalculated;
            $grossProfitMargin = $totalRevenue > 0
                ? (($totalRevenue - $totalCOGS) / $totalRevenue) * 100
                : 0;
            $netProfitMargin = $totalRevenue > 0
                ? ($netProfit / $totalRevenue) * 100
                : 0;

            // Stakeholder Balances
            $staronManufacturingBalance = Funds::where('stakeholder', 'Staron Egypt for Manufacturing')
                ->where('transaction_type', 'to')
                ->sum('amount') - Funds::where('stakeholder', 'Staron Egypt for Manufacturing')
                ->where('transaction_type', 'from')
                ->sum('amount');
            $staronContractingBalance = Funds::where('stakeholder', 'Staron Egypt for Contracting')
                ->where('transaction_type', 'to')
                ->sum('amount') - Funds::where('stakeholder', 'Staron Egypt for Contracting')
                ->where('transaction_type', 'from')
                ->sum('amount'); // delete
            $engTarekBalance = Funds::where('stakeholder', 'Eng. Tarek El Behairy')
                ->where('transaction_type', 'to')
                ->sum('amount') - Funds::where('stakeholder', 'Eng. Tarek El Behairy')
                ->where('transaction_type', 'from')
                ->sum('amount');

            $stakeholderBalances = [
                'Staron Egypt for Manufacturing' => $staronManufacturingBalance,
                'Staron Egypt for Contracting' => $staronContractingBalance,
                'Eng. Tarek El Behairy' => $engTarekBalance,
            ];

            // Compile Dashboard Data
            $dashboardData = [
                'total_revenue' => $totalRevenue,
                'total_collection' => $totalCollection,
                'total_accounts_receivables' => $totalAccountsReceivables,
                'total_expenses' => $totalExpensesCalculated,
                'total_cogs' => $totalCOGS,
                'total_supply_costs' => $totalSupplyCosts,
                'total_apply_costs' => $totalApplyCosts,
                'total_logistics_costs' => $totalLogisticsCosts,
                'total_gna_expenses' => $totalGAndAExpenses,
                'total_operating_expenses' => $totalOperatingExpenses,
                'liquidity' => $liquidity,
                'cash_in_treasury' => $lastTreasuryBalance,
                'credit_lines' => $stakeholderFunds,
                'bank_balance' => $lastBankBalance,
                'total_projects_sold' => $totalProjectsSold,
                'pending_projects' => $pendingProjects,
                'pending_projects_value' => $pendingProjectsValue,
                'net_profit' => $netProfit,
                'gross_profit_margin' => round($grossProfitMargin, 2),
                'net_profit_margin' => round($netProfitMargin, 2),
                'stakeholder_balances' => $stakeholderBalances,
            ];

            return view('dashboard', compact('dashboardData'));
        } catch (\Exception $e) {
            Log::error('Error generating dashboard data: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to load dashboard data.']);
        }
    }
}
