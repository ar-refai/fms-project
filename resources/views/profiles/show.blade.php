<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-200 dark:text-gray-200">
            {{ __('Profile: ') . $client->client_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-gray-900 rounded-lg shadow-lg">
                <div class="p-6 text-gray-200">
                    <!-- Client Information -->
                    <div class="mb-6">
                        <h3 class="mb-2 text-3xl font-extrabold text-gray-100">{{ $client->client_name }}</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <p class="text-md"><strong>Client Code:</strong> {{ $client->client_code }}</p>
                            <p class="text-md"><strong>Type:</strong> {{ $client->client_type }}</p>
                            <p class="text-md"><strong>Source:</strong> {{ $client->client_source }}</p>
                        </div>
                    </div>
                    <hr class="my-6 border-gray-600">

                    <!-- Projects Section -->
                    <div x-data="{ expanded: false }" class="mb-6">
                        <button @click="expanded = !expanded"
                            class="flex items-center justify-between w-full px-4 py-2 text-lg font-bold text-left text-gray-200 bg-gray-800 rounded-lg hover:bg-gray-700">
                            Projects
                            <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="expanded" x-collapse class="mt-4">
                            <table id="projectsTable" class="w-full text-sm text-gray-300 bg-gray-800 rounded-md display">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">Client ID</th>
                                        <th class="px-4 py-2">Client Name</th>
                                        <th class="px-4 py-2">Client Type</th>
                                        <th class="px-4 py-2">Project ID</th>
                                        <th class="px-4 py-2">Project Validation Date</th>
                                        <th class="px-4 py-2">Contracted Revenue</th>
                                        {{-- <th class="px-4 py-2">Accounts Recivable</th>
                                        <th class="px-4 py-2">Collection Rate</th>
                                        <th class="px-4 py-2">Supply Cost</th>
                                        <th class="px-4 py-2">Apply Cost</th>
                                        <th class="px-4 py-2">Logistics Cost</th>
                                        <th class="px-4 py-2">Gross Profit</th>
                                        <th class="px-4 py-2">GPM</th> --}}
                                        <th class="px-4 py-2">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->projects as $project)
                                        <tr class="hover:bg-gray-700">
                                            <td class="px-4 py-2">{{ $project->client->client_code }}</td>
                                            <td class="px-4 py-2">{{ $project->client->client_name }}</td>
                                            <td class="px-4 py-2">{{ $project->client->client_type }}</td>
                                            <td class="px-4 py-2">{{ $project->project_id }}</td>
                                            <td class="px-4 py-2">{{ $project->project_validation_date }}</td>
                                            <td class="px-4 py-2">{{ $project->contracted_revenue ?? "N/A" }}</td>
                                            <td class="px-4 py-2">{{ $project->status }}</td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Expenses Section -->
                    <div x-data="{ expanded: false }">
                        <button @click="expanded = !expanded"
                            class="flex items-center justify-between w-full px-4 py-2 text-lg font-bold text-left text-gray-200 bg-gray-800 rounded-lg hover:bg-gray-700">
                            Expenses
                            <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="expanded" x-collapse class="mt-4">
                            <table id="expensesTable" class="w-full text-sm text-gray-300 bg-gray-800 rounded-md display">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">Accounting ID</th>
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Expense Type</th>
                                        <th class="px-4 py-2">Designation</th>
                                        <th class="px-4 py-2">Basis</th>
                                        <th class="px-4 py-2">Description</th>
                                        <th class="px-4 py-2">Unit</th>
                                        <th class="px-4 py-2">Unit Rate</th>
                                        <th class="px-4 py-2">Quantity</th>
                                        <th class="px-4 py-2">Total Amount</th>
                                        <th class="px-4 py-2">Recipient</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->expenses as $expense)
                                        <tr class="hover:bg-gray-700">
                                            <td class="px-4 py-2">{{ $expense->accounting_id }}</td>
                                            <td class="px-4 py-2">{{ $expense->date }}</td>
                                            <td class="px-4 py-2">{{ $expense->expense_type }}</td>
                                            <td class="px-4 py-2">{{ $expense->designation }}</td>
                                            <td class="px-4 py-2">{{ $expense->basis }}</td>
                                            <td class="px-4 py-2">{{ $expense->description }}</td>
                                            <td class="px-4 py-2">{{ $expense->unit }}</td>
                                            <td class="px-4 py-2">{{ $expense->unit_rate }}</td>
                                            <td class="px-4 py-2">{{ $expense->quantity }}</td>
                                            <td class="px-4 py-2">{{ number_format($expense->total_amount, 2) }}</td>
                                            <td class="px-4 py-2">{{ $expense->recipient }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
