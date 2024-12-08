<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Clients and Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg">

                        {{-- Flash Messages --}}
                        @if (session('success'))
                            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Buttons --}}
                        <div class="flex mb-6 space-x-4">
                            <button class="px-4 py-2 text-sm text-white transition rounded-md te bg-sky-500 hover:bg-sky-600"
                                onclick="openModal('addClientModal')">
                                Add New Client
                            </button>

                            <button class="px-4 py-2 text-sm text-white transition rounded-md te bg-sky-500 hover:bg-sky-600"
                                onclick="openModal('addProjectModal')">
                                Add New Project
                            </button>
                                    <!-- Include Quotation Modal -->
                                    <button
                                    class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-800"
                                    onclick="openModal('addQuotationModal')"
                                    type="button"
                                >
                                    Declare Quotation Items
                                </button>
                                <x-quotation-modal :projects="$projectsWithoutQuotations" />


                            <button class="px-4 py-2 text-sm text-white transition bg-gray-500 rounded-md hover:bg-gray-600"
                                onclick="openModal('viewAllClientsModal')">
                                View All Clients
                            </button>

                            <button class="px-4 py-2 text-sm text-white transition bg-gray-500 rounded-md hover:bg-gray-600"
                                onclick="openModal('viewAllProjectsModal')">
                                View All Projects
                            </button>
                        </div>
                        @if ($errors->any())
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Display Validation Errors --}}
                        @if ($errors->hasBag('deleteProject'))
                            <div class="mb-4 text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->getBag('deleteProject')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Display Validation Errors --}}
                        @if ($errors->hasBag('addClient'))
                            <div class="mb-4 text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->getBag('addClient')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Display Validation Errors --}}
                        @if ($errors->hasBag('addProject'))
                            <div class="mb-4 text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->getBag('addProject')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($errors->hasBag('editProject'))
                            <div class="mb-4 text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->getBag('editProject')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ($errors->hasBag('editClient'))
                            <div class="mb-4 text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->getBag('editClient')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Main Table --}}
                        <div id="recipients" class="p-8 mt-6 rounded shadow lg:mt-0">
                            <table id="clientsTable"
                                class="w-full text-sm text-left text-gray-900 display stripe rtl:text-right dark:text-gray-100">
                                <thead
                                    class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                                    <tr>
                                        <th>Client ID</th>
                                        <th>Project ID</th>
                                        <th>Project Validation Date</th>
                                        <th>Client</th>
                                        <th>Type</th>
                                        <th>Project</th>
                                        <th>Contracted Revenue</th>
                                        <th>Accounts Receivables</th>
                                        <th>Collection Rate (%)</th>
                                        <th>Supply Cost</th>
                                        <th>Apply Cost</th>
                                        <th>Logistics Cost</th>
                                        <th>Gross Profit</th>
                                        <th>GPM (%)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dashboardData as $row)
                                        <tr>
                                            <td>{{ $row['client_id'] }}</td>
                                            <td>{{ $row['project_id'] }}</td>
                                            <td>{{ $row['project_validation_date'] }}</td>
                                            <td>{{ $row['client'] }}</td>
                                            <td>{{ $row['type'] }}</td>
                                            <td>{{ $row['project'] }}</td>
                                            <td>{{ $row['contracted_revenue'] ?? "N/A" }}</td>
                                            <td>{{ $row['accounts_receivables'] }}</td>
                                            <td>{{ number_format($row['collection_rate'], 2) }}</td>
                                            <td>{{ $row['supply_cost'] }}</td>
                                            <td>{{ $row['apply_cost'] }}</td>
                                            <td>{{ $row['logistics_cost'] }}</td>
                                            <td>{{ $row['gross_profit'] }}</td>
                                            <td>{{ number_format($row['gpm'], 2) }}</td>
                                            <td>{{ $row['status'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Add Client Modal --}}
                        <div id="addClientModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('addClientModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Add New Client</h3>



                                    <form method="POST" action="{{ route('clients.store') }}">
                                        @csrf
                                        {{-- <div>
                                            <label for="client_code" class="block text-sm">Client Code</label>
                                            <input type="text" name="client_code" id="client_code"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md @error('client_code', 'addClient') border-red-500 @enderror">
                                        </div> --}}
                                        <div>
                                            <label for="client_name" class="block text-sm">Client Name</label>
                                            <input type="text" name="client_name" id="client_name"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md @error('client_name', 'addClient') border-red-500 @enderror">
                                        </div>
                                        {{-- <div>
                                            <input type="text" name="client_type" id="client_type"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md @error('client_type', 'addClient') border-red-500 @enderror">
                                        </div> --}}
                                        <div>
                                            <label for="client_type" class="block text-sm">Client Type</label>
                                            <select name="client_type" id="client_type"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                            <option value="" disabled selected>Select Client Type</option>
                                            {{-- @foreach ($clients as $client) --}}
                                            <option value="B2B">B2B</option>
                                            <option value="B2C">B2C</option>
                                            {{-- @endforeach --}}
                                        </select>
                                    </div>

                                    <div>
                                        <label for="client_source" class="block text-sm">Client Source</label>
                                        <select name="client_source" id="client_source"
                                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        <option value="" disabled selected>Select Client Source</option>
                                        {{-- @foreach ($clients as $client) --}}
                                        <option value="Referral">Referral</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Coverage">Coverage</option>

                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('addClientModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Close
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Add Client
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        {{-- Add Project Modal --}}
                        <div id="addProjectModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('addProjectModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Add New Project</h3>

                                    <form method="POST" action="{{ route('projects.store') }}">
                                        @csrf
                                        <div>
                                            <label for="project_name" class="block text-sm">Project Name</label>
                                            <input type="text" name="project_name" id="project_name" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="project_validation_date" class="block text-sm">Project Validation Date</label>
                                            <input type="date" name="project_validation_date" id="project_validation_date"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"
                                            />
                                        </div>
                                        <div>
                                            <label for="client_id" class="block text-sm">Client</label>
                                            <select name="client_id" id="client_id"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                <option value="" disabled selected>Select Client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div>
                                            <label for="contracted_revenue" class="block text-sm">Contracted Revenue</label>
                                            <input type="number" name="contracted_revenue"
                                                id="contracted_revenue" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div> --}}

                                        <div>
                                            <label for="status" class="block text-sm">Status</label>
                                            <select name="status" id="status"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                <option value="Pending" selected>Pending</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>

                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('addProjectModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Close
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Add Project
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>



                        {{-- all projects table --}}
                        <div id="viewAllProjectsModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-4xl mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('viewAllProjectsModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">All Projects</h3>
                                    <table id="minProjectTable"
                                        class="w-full text-sm text-left text-gray-100 bg-gray-800 data-table">
                                        <thead class="text-xs text-gray-100 bg-gray-700">
                                            <tr>
                                                <th>Project ID</th>
                                                <th>Project Name</th>
                                                <th>Project Validation Date</th>
                                                <th>Client Name</th>
                                                <th>Contracted Revenue</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $project->project_id }}</td>
                                                    <td>{{ $project->project_name }}</td>
                                                    <td>{{ $project->project_validation_date }}</td>
                                                    <td>{{ $project->client->client_name ?? 'N/A' }}</td>
                                                    <td>{{ $project->contracted_revenue }}</td>
                                                    <td>{{ $project->status }}</td>
                                                    <td class="flex-col justify-center space-y-2 align-items-center">
                                                        <button
                                                            class="w-full px-2 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700"
                                                            onclick="openModal('editProjectModal', {{ json_encode($project) }})">
                                                            Edit
                                                        </button>
                                                        <button
                                                            class="w-full px-2 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700"
                                                            onclick="openModal('deleteProjectModal', { id: {{ $project->id }} })">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Project Modal --}}
                        <div id="editProjectModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('editProjectModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Edit Project</h3>
                                    {{-- Display Validation Errors --}}

                                    <form method="POST" id="editProjectForm">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label for="edit_project_id" class="block text-sm">Project ID</label>
                                            <input type="text" name="project_id" id="edit_project_id" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" disabled>
                                        </div>
                                        <div>
                                            <label for="edit_project_name" class="block text-sm">Project Name</label>
                                            <input type="text" name="project_name" id="edit_project_name" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_project_validation_date" class="block text-sm">Project Validation Date</label>
                                            <input type="date" name="project_validation_date" id="edit_project_validation_date"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"
                                            />
                                        </div>
                                        <div>
                                            <label for="edit_client_id" class="block text-sm">Client</label>
                                            <select name="client_id" id="edit_client_id" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->client_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="edit_contracted_revenue" class="block text-sm">Contracted
                                                Revenue</label>
                                            <input type="number"  name="contracted_revenue"
                                                id="edit_contracted_revenue" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>

                                        <div>
                                            <label for="edit_status" class="block text-sm">Status</label>
                                            <select name="status" id="edit_status" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                <option value="Pending">Pending</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('editProjectModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Delete Project Modal --}}
                        <div id="deleteProjectModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('deleteProjectModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">

                                    <h3 class="mb-4 text-xl font-bold">Confirm Delete</h3>
                                    <p>Are you sure you want to delete this project?</p>
<!-- Add this hidden input inside the form to store JSON data -->
<form id="quotationForm">
    <input type="hidden" id="quotationItemsInput" name="quotation_items" />
    <div id="quotationItems">
        <!-- Initial Quotation Item -->
        <div class="mb-4 quotation-item">
            <div class="flex space-x-4">
                <div class="w-1/4">
                    <label for="item_title" class="block text-sm">Item Title</label>
                    <input type="text" name="item_title[]" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="w-1/4">
                    <label for="unit" class="block text-sm">Unit</label>
                    <input type="text" name="unit[]" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="w-1/4">
                    <label for="unit_rate" class="block text-sm">Unit Rate</label>
                    <input type="number" name="unit_rate[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="w-1/4">
                    <label for="quantity" class="block text-sm">Quantity</label>
                    <input type="number" name="quantity[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="w-1/4">
                    <label for="price" class="block text-sm">Price</label>
                    <input type="number" name="price[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="flex items-end w-1/4">
                    <button type="button" onclick="removeQuotationItem(this)" class="px-2 py-1 mt-2 text-sm text-white bg-red-600 rounded-md hover:bg-red-800">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" onclick="addQuotationItem()"
        class="px-3 py-1.5 mt-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-800">
        Add More Items
    </button>
    <div class="flex justify-end mt-4 space-x-4">
        <button type="button" onclick="closeModal('addQuotationModal')"
            class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
            Close
        </button>
        <button type="submit" onclick="submitQuotationItems()"
            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
            Submit Quotation
        </button>
    </div>
</form>

                                </div>
                            </div>
                        </div>

                        {{-- View All Clients Modal --}}
                        <div id="viewAllClientsModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-4xl mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('viewAllClientsModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">All Clients</h3>
                                    <table id="minClientTable"
                                        class="w-full text-sm text-left text-gray-100 bg-gray-800 data-table display ">
                                        <thead class="text-xs text-gray-100 bg-gray-700">
                                            <tr>
                                                <th>Client Code</th>
                                                <th>Client Name</th>
                                                <th>Client Type</th>
                                                <th>Client Source</th>

                                                <th>Created At</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clients as $client)
                                                <tr>
                                                    <td>{{ $client->client_code }}</td>
                                                    <td>
                                                        <a href="{{ route('profiles.show', $client->id) }}"
                                                            class="block p-2 font-semibold text-center text-blue-600 transition duration-200 rounded-lg hover:text-blue-700 hover:underline dark:text-blue-500 dark:hover:text-blue-600 ">

                                                            >
                                                        {{ $client->client_name }}
                                                        <a/>
                                                    </td>
                                                    <td>{{ $client->client_type }}</td>
                                                    <td>{{ $client->client_source }}</td>

                                                    <td>{{ $client->created_at }}</td>
                                                    <td class="flex-col space-y-2">
                                                        <button
                                                            class="w-full px-2 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700"
                                                            onclick="openModal('editClientModal', {{ json_encode($client) }})">
                                                            Edit
                                                        </button>
                                                        <button
                                                            class="w-full px-2 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700"
                                                            onclick="openModal('deleteClientModal', { id: {{ $client->id }} })">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>

                        {{-- Edit Client Modal --}}
                        <div id="editClientModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('editClientModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Edit Client</h3>
                                    {{-- Display Validation Errors --}}

                                    <form method="POST" id="editClientForm">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label for="edit_client_code" class="block text-sm">Client Code</label>
                                            <input type="text" name="client_code" id="edit_client_code"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" disabled>
                                        </div>
                                        <div>
                                            <label for="edit_client_name" class="block text-sm">Client Name</label>
                                            <input type="text" name="client_name" id="edit_client_name"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>

                                        <div>
                                            <label for="edit_client_type" class="block text-sm">Client Type</label>
                                            <select name="client_type" id="edit_client_type"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                            <option value="" disabled selected>Select Client Type</option>
                                            {{-- @foreach ($clients as $client) --}}
                                            <option value="B2B">B2B</option>
                                            <option value="B2C">B2C</option>
                                            {{-- @endforeach --}}
                                        </select>
                                        </div>

                                    <div>
                                        <label for="edit_client_source" class="block text-sm">Client Source</label>
                                        <select name="client_source" id="edit_client_source"
                                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" disabled>
                                        <option value="" disabled selected>Select Client Source</option>
                                        {{-- @foreach ($clients as $client) --}}
                                        <option value="Referral">Referral</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Coverage">Coverage</option>

                                        {{-- @endforeach --}}
                                    </select>
                                </div>

                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('editClientModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Delete Client Modal --}}
                        <div id="deleteClientModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('deleteClientModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Confirm Delete</h3>
                                    <p>Are you sure you want to delete this client?</p>
                                    <form method="POST" id="deleteClientForm" action="">
                                        @csrf
                                        @method('DELETE')

                                        <div class="flex justify-center mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('deleteClientModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-800">
                                                Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal JS --}}
    <script type="text/javascript">
        function openModal(modalId, data = {}) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'block';
            document.body.classList.add('overflow-y-hidden');
            if (modalId === 'editClientModal' && data) {
                    document.getElementById('edit_client_code').value = data.client_code || '';
                    document.getElementById('edit_client_name').value = data.client_name || '';
                    document.getElementById('edit_client_type').value = data.client_type || '';
                    document.getElementById('edit_client_source').value = data.client_source || '';
                    // console.log(data);
                    const form = document.getElementById('editClientForm');
                    form.action = `/clients/${data.id}`;
                }

            if (modalId === 'editProjectModal' && data) {
                document.getElementById('edit_project_id').value = data.project_id || '';
                document.getElementById('edit_project_name').value = data.project_name || '';
                document.getElementById('edit_client_id').value = data.client_id || '';
                document.getElementById('edit_contracted_revenue').value = data.contracted_revenue || '';
                document.getElementById('edit_status').value = data.status || '';
                document.getElementById('edit_project_validation_date').value = data.project_validation_date || '';


                const form = document.getElementById('editProjectForm');
                form.action = `/projects/${data.id}`;
            }
            if (modalId === 'deleteClientModal' && data.id) {
                const form = document.getElementById('deleteClientForm');
                form.action = `/clients/${data.id}`;
            }
            if (modalId === 'deleteProjectModal' && data.id) {
                const form = document.getElementById('deleteProjectForm');
                form.action = `/projects/${data.id}`;
            }
        }


        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            document.body.classList.remove('overflow-y-hidden');
        }
    </script>
</x-app-layout>
