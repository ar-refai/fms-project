<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="pb-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-gray-900 py-14 sm:py-14">
                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                    <div class="max-w-2xl mx-auto lg:max-w-none">

                        {{-- @include('components.import'); --}}

                        {{-- Treasury Upload --}}
                        {{-- <form action="{{ route('treasury.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="file">Upload Treasury Data (CSV):</label>
                            <input type="file" name="file" id="file" required>
                            <button type="submit">Import</button>
                        </form> --}}

                        <div class="space-y-4 text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Dashboard Overview</h2>
                            <p class="text-lg leading-8 text-gray-300">Here's an overview of your business metrics for the current period.</p>
                        </div>
                        {{-- Dashboard Metrics --}}

                        <div class="p-6">
                            <h3 class="mb-4 text-xl font-bold text-white">Some Table</h3>
                            <table class="w-full text-left border border-collapse border-gray-600 table-auto display">
                                <thead>
                                    <tr class="text-white bg-gray-800">
                                        <th class="px-4 py-2 border border-gray-600">Metric</th>
                                        <th class="px-4 py-2 border border-gray-600">Value</th>
                                        <th class="px-4 py-2 border border-gray-600">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-100 bg-gray-700">
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Revenue</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_revenue'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Collection</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_collection'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Accounts Receivables</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_accounts_receivables'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Expenses</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_expenses'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total COGS</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_cogs'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Supply Costs</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_supply_costs'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Apply Costs</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_apply_costs'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Logistics Costs</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_logistics_costs'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total G&A Expenses</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_gna_expenses'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Operating Expenses</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['total_operating_expenses'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Liquidity</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['liquidity'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Cash in Treasury</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['cash_in_treasury'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Credit Lines</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['credit_lines'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Bank Balance</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['bank_balance'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Total Projects Sold</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ $dashboardData['total_projects_sold'] }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Pending Projects</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ $dashboardData['pending_projects'] }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Pending Projects Value</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['pending_projects_value'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Net Profit</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['net_profit'], 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Gross Profit Margin</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['gross_profit_margin'], 2) }}%</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">Net Profit Margin</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($dashboardData['net_profit_margin'], 2) }}%</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    @foreach ($dashboardData['stakeholder_balances'] as $stakeholder => $balance)
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-600">{{ $stakeholder }}</td>
                                        <td class="px-4 py-2 border border-gray-600">{{ number_format($balance, 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-600"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>




                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-center text-gray-400 sm:text-3xl">Revenue</h2>
                        <dl class="grid grid-cols-1 gap-4 mt-8 overflow-hidden text-center rounded-2xl sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                            <!-- Total Revenue -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Revenue</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_revenue'], 2) }}
                                </dd>
                            </div>

                            <!-- Total Collection -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Collection</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_collection'], 2) }}
                                </dd>
                            </div>

                            <!-- Total Accounts Receivables -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Accounts Receivables</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_accounts_receivables'], 2) }}
                                </dd>
                            </div>
                        </dl>


                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-center text-gray-400 sm:text-3xl">Expenses</h2>
                        <dl class="grid grid-cols-1 gap-4 mt-8 overflow-hidden text-center rounded-2xl sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                            <!-- Total Expenses -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Expenses</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_expenses'], 2) }}
                                </dd>
                            </div>

                            <!-- Total COGS -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total COGS</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_cogs'], 2) }}
                                </dd>
                            </div>

                            <!-- Total Supply Costs -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Supply Costs</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_supply_costs'], 2) }}
                                </dd>
                            </div>

                            <!-- Total Apply Costs -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Apply Costs</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_apply_costs'], 2) }}
                                </dd>
                            </div>

                            <!-- Total Logistics Costs -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Logistics Costs</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_logistics_costs'], 2) }}
                                </dd>
                            </div>

                            <!-- Total G&A Expenses -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total G&A Expenses</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_gna_expenses'], 2) }}
                                </dd>
                            </div>

                            <!-- Total Operating Expenses -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Operating Expenses</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['total_operating_expenses'], 2) }}
                                </dd>
                            </div>
                        </dl>


                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-center text-gray-400 sm:text-3xl">Liquidity</h2>
                        <dl class="grid grid-cols-1 gap-4 mt-8 overflow-hidden text-center rounded-2xl sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">

                            <!-- Liquidity -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Liquidity</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['liquidity'], 2) }}
                                </dd>
                            </div>

                            <!-- Cash in Treasury -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Cash in Treasury</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['cash_in_treasury'], 2) }}
                                </dd>
                            </div>

                            <!-- Credit Lines -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Credit Lines</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['credit_lines'], 2) }}
                                </dd>
                            </div>
                        </dl>


                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-center text-gray-400 sm:text-3xl">Totals</h2>
                        <dl class="grid grid-cols-1 gap-4 mt-8 overflow-hidden text-center rounded-2xl sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">

                            <!-- Total Projects Sold -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Total Projects Sold</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ $dashboardData['total_projects_sold'] }}
                                </dd>
                            </div>

                            <!-- Pending Projects -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Pending Projects</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ $dashboardData['pending_projects'] }}
                                </dd>
                            </div>

                            <!-- Pending Projects Value -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Pending Projects Value</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['pending_projects_value'], 2) }}
                                </dd>
                            </div>

                            <!-- Net Profit -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Net Profit</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['net_profit'], 2) }}
                                </dd>
                            </div>

                            <!-- Gross Profit Margin -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Gross Profit Margin (%)</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['gross_profit_margin'], 2) }}%
                                </dd>
                            </div>

                            <!-- Net Profit Margin -->
                            <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                <dt class="text-sm font-semibold leading-6 text-gray-300">Net Profit Margin (%)</dt>
                                <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                    {{ number_format($dashboardData['net_profit_margin'], 2) }}%
                                </dd>
                            </div>

                        </dl>


                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-center text-gray-400 sm:text-3xl">Stakeholders</h2>
                        <dl class="grid grid-cols-1 gap-4 mt-8 overflow-hidden text-center rounded-2xl sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">

                            {{-- Stakeholder Balances --}}
                            @foreach ($dashboardData['stakeholder_balances'] as $stakeholder => $balance)
                                <div class="flex flex-col p-8 transition hover:scale-95 duaration-75 bg-white/5">
                                    <dt class="text-sm font-semibold leading-6 text-gray-300">{{ $stakeholder }}</dt>
                                    <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                                        {{ number_format($balance, 2) }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
