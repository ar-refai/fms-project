<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg">

                        {{-- Buttons --}}
                        <div class="flex mb-6 space-x-4">
                            <button class="px-4 py-2 text-white transition rounded-md bg-sky-500 hover:bg-sky-600"
                                onclick="openModal('addExpenseModal')">
                                Add New Expense
                            </button>
                        </div>

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Main Table --}}
                        <div id="recipients-expense" class="p-8 mt-6 rounded shadow lg:mt-0">
                            <table id="expensesTable"
                                class="w-full text-sm text-left text-gray-900 data-table display stripe rtl:text-right dark:text-gray-100">
                                <thead
                                    class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                                    <tr>
                                        <th>Accounting ID</th>
                                        <th>Date</th>
                                        {{-- <th>Project</th> --}}
                                        <th>Expense Type</th>
                                        <th>Designation</th>
                                        <th>Basis</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th>Unit Rate</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Recipient</th>
                                        <th>Actions</th>
                                    </tr>
                                    {{--

                                    Date	Accounting ID	Expense Type
                                    Designation	Basis	Description	Unit
                                    Unit Rate	Quantity	Total Amount	Recipient

                                    --}}
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->accounting_id }}</td>
                                            <td>{{ $expense->date }}</td>
                                            {{-- <td>{{ $expense->project->project_name ?? 'N/A' }}</td> --}}
                                            <td>{{ $expense->expense_type }}</td>
                                            <td>{{ $expense->designation }}</td>
                                            <td>{{ $expense->basis  ?? 'N/A' }}</td>
                                            <td>{{ $expense->description ?? 'N/A' }}</td>
                                            <td>{{ $expense->unit ?? 'N/A' }}</td>
                                            <td>{{ $expense->unit_rate  ?? "N/A" }}</td>
                                            <td>{{ $expense->quantity ?? "N/A" }}</td>
                                            <td>{{ number_format($expense->total_amount, 2) }}</td>
                                            <td>{{ $expense->recipient }}</td>
                                            <td class="flex-col justify-start space-y-2">
                                                {{-- Edit Button --}}
                                                <button
                                                    onclick="openModal('editExpenseModal', {{ json_encode($expense) }})"
                                                    class="w-full px-2 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                    Edit
                                                </button>

                                                {{-- Delete Button --}}
                                                <button
                                                    onclick="openModal('deleteExpenseModal', { id: {{ $expense->id }} })"
                                                    class="w-full px-2 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

 <!-- Add Expense Modal -->
<div id="addExpenseModal" class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
    <div class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
        <div class="flex justify-end p-2">
            <button onclick="closeModal('addExpenseModal')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <h3 class="mb-4 text-xl font-bold">Add New Expense</h3>
            <form method="POST" action="{{ route('expenses.store') }}">
                @csrf
                <div>
                    <label for="accounting_id" class="block text-sm">Accounting ID</label>
                    <input type="text" name="accounting_id" id="accounting_id" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="date" class="block text-sm">Date</label>
                    <input type="date" name="date" id="date" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <!-- Designation Type -->
                <div>
                    <label for="designation_type" class="block text-sm">Designation Type</label>
                    <select name="designation_type" id="designation_type" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" onchange="setDesignationType(this)">
                        <option value="" disabled selected>Select Designation Type</option>
                        <option value="clients">Clients</option>
                        <option value="other">Other Options</option>
                    </select>
                </div>

            <!-- Designation (Client) -->
                <div id="designation_client_wrapper" class="hidden">
                    <label for="designation" class="block text-sm">Designation (Client)</label>
                    <select name="designation" id="designation"
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" onchange="setClientProjects(this)">
                        <option value="" disabled selected>Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_name }}" data-client-id="{{ $client->id }}">
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="client_id" id="client_id">
                </div>

                <!-- Other Designation (Utilities) -->
                <div id="designation_other_wrapper" class="hidden">
                    <label for="designation_other" class="block text-sm">Other Option</label>
                    {{-- <select name="designation" id="designation_other"
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                        <option value="utilities">Utilities</option>
                    </select> --}}
                    <input type="text" name="designation" id="designation_other" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"/>
                </div>

                <!-- Basis (Project) -->
                <div id="basis_wrapper" class="hidden">
                    <label for="basis" class="block text-sm">Project (Basis)</label>
                    <select name="basis" id="basis" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" onchange="setProjectId(this)">
                        <option value="" disabled selected>Select Project</option>
                    </select>
                    <input type="hidden" name="project_id" id="project_id">
                </div>
                <div>
                    <label for="expense_type" class="block text-sm">Expense Type</label>
                    <select name="expense_type" id="expense_type" required class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                        <option value="Logistics">Logistics</option>
                        <option value="Material Purchases">Material Purchases</option>
                        <option value="Fabrication & Installation">Fabrication & Installation</option>
                        <option value="G&A">G&A</option>
                        <option value="Factory">Factory</option>
                        <option value="Other Expenses">Other Expenses</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block text-sm">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"></textarea>
                </div>
                <div>
                    <label for="unit" class="block text-sm">Unit</label>
                    <select name="unit" id="unit" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                        <option value="" disabled selected>Select Unit</option>
                        <option value="Set">Set</option>
                        <option value="No">No</option>
                        <option value="Sheet">Sheet</option>
                        <option value="SQM">SQM</option>
                        <option value="Roll">Roll</option>
                        <option value="Pack">Pack</option>
                        <option value="Ampula">Ampula</option>
                        <option value="L.S">L.S</option>
                        <option value="Strip">Strip</option>
                        <option value="Box">Box</option>
                        <option value="Cubic Meter">Cubic Meter</option>
                        <option value="K.G">K.G</option>
                    </select>
                </div>
                <div>
                    <label for="unit_rate" class="block text-sm">Unit Rate</label>
                    <input type="number" name="unit_rate" id="unit_rate" oninput="totalAmountCalc()"
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="quantity" class="block text-sm">Quantity</label>
                    <input type="number"  name="quantity" id="quantity" oninput="totalAmountCalc()"
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="total_amount" class="block text-sm">Total Amount</label>
                    <input type="number" name="total_amount"
                        id="total_amount" required readonly
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="recipient" class="block text-sm">Recipient</label>
                    <input type="text" name="recipient" id="recipient" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div class="flex justify-end mt-4 space-x-4">
                    <button type="button" onclick="closeModal('addExpenseModal')" class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                        Close
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                        Add Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Expense Modal -->
<!-- Edit Expense Modal -->
<<!-- Edit Expense Modal -->
<div id="editExpenseModal" class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
    <div class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
        <div class="flex justify-end p-2">
            <button onclick="closeModal('editExpenseModal')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <h3 class="mb-4 text-xl font-bold">Edit Expense</h3>
            <form method="POST" id="editExpenseForm">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_accounting_id" class="block text-sm">Accounting ID</label>
                    <input type="text" name="accounting_id" id="edit_accounting_id"
                        required class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="edit_date" class="block text-sm">Date</label>
                    <input type="date" name="date" id="edit_date" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                 <!-- Designation Type -->
                 <div>
                    <label for="edit_designation_type" class="block text-sm">Designation Type</label>
                    <select name="designation_type" id="edit_designation_type" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" onchange="setDesignationType(this, true)">
                        <option value="" disabled>Select Designation Type</option>
                        <option value="clients">Clients</option>
                        <option value="other">Other Options</option>
                    </select>
                </div>
                <!-- Designation (Client) -->
                <div id="edit_designation_client_wrapper" class="hidden">
                    <label for="edit_designation" class="block text-sm">Designation (Client)</label>
                    <select name="designation" id="edit_designation" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" onchange="setClientProjects(this, 'edit_basis', true)">
                        <option value="" disabled selected>Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_name }}" data-client-id="{{ $client->id }}">
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="client_id" id="edit_client_id">
                </div>
                <!-- Other Designation (Utilities) -->
                <div id="edit_designation_other_wrapper" class="hidden">
                    <label for="edit_designation_other" class="block text-sm">Other Options</label>
                    <select name="designation" id="edit_designation_other" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                        <option value="utilities">Utilities</option>
                    </select>
                </div>
                <!-- Basis (Project) -->
                <div id="edit_basis_wrapper" class="hidden">
                    <label for="edit_basis" class="block text-sm">Project (Basis)</label>
                    <select name="basis" id="edit_basis" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" onchange="setEditProjectId(this)">
                        <option value="" disabled selected>Select Project</option>
                    </select>
                    <input type="hidden" name="project_id" id="edit_project_id">
                </div>
                <div>
                    <label for="edit_expense_type" class="block text-sm">Expense Type</label>
                    <select name="expense_type" id="edit_expense_type" required class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                        <option value="Logistics">Logistics</option>
                        <option value="Material Purchases">Material Purchases</option>
                        <option value="Fabrication & Installation">Fabrication & Installation</option>
                        <option value="G&A">G&A</option>
                        <option value="Factory">Factory</option>
                        <option value="Other Expenses">Other Expenses</option>
                    </select>
                </div>
                <div>
                    <label for="edit_description" class="block text-sm">Description</label>
                    <textarea name="description" id="edit_description" required class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"></textarea>
                </div>
                <div>
                    <label for="edit_unit" class="block text-sm">Unit</label>
                    <select name="unit" id="edit_unit" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                        <option value="" disabled>Select Unit</option>
                        <option value="Set">Set</option>
                        <option value="No">No</option>
                        <option value="Sheet">Sheet</option>
                        <option value="SQM">SQM</option>
                        <option value="Roll">Roll</option>
                        <option value="Pack">Pack</option>
                        <option value="Ampula">Ampula</option>
                        <option value="L.S">L.S</option>
                        <option value="Strip">Strip</option>
                        <option value="Box">Box</option>
                        <option value="Cubic Meter">Cubic Meter</option>
                        <option value="K.G">K.G</option>
                    </select>
                </div>
                <div>
                    <label for="edit_unit_rate" class="block text-sm">Unit Rate</label>
                    <input type="number" name="unit_rate" id="edit_unit_rate" oninput="totalAmountEditCalc()"
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="edit_quantity" class="block text-sm">Quantity</label>
                    <input type="number" name="quantity" id="edit_quantity" oninput="totalAmountEditCalc()"
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="edit_total_amount" class="block text-sm">Total Amount</label>
                    <input type="number" name="total_amount" id="edit_total_amount" required readonly
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div>
                    <label for="edit_recipient" class="block text-sm">Recipient</label>
                    <input type="text" name="recipient" id="edit_recipient" required
                        class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                </div>
                <div class="flex justify-end mt-4 space-x-4">
                    <button type="button" onclick="closeModal('editExpenseModal')" class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                        Close
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                        Update Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




                        {{-- Delete Expense Modal --}}
                        <div id="deleteExpenseModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('deleteExpenseModal')" type="button"
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
                                    <h3 class="mb-4 text-xl font-bold">Confirm Delete</h3>
                                    <p>Are you sure you want to delete this expense?</p>
                                    <form method="POST" id="deleteExpenseForm">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex justify-center mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('deleteExpenseModal')"
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
  const projects = @json($projects);

function openModal(modalId, data = {}) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'block';
    document.body.classList.add('overflow-y-hidden');

    if (modalId === 'editExpenseModal' && data) {
        // Set the values correctly for editing
        document.getElementById('edit_accounting_id').value = data.accounting_id || '';
        document.getElementById('edit_date').value = data.date ? data.date.split(' ')[0] : '';
        document.getElementById('edit_expense_type').value = data.expense_type || '';
        document.getElementById('edit_designation_type').value = data.designation_type || 'clients';

        // Set the designation type correctly
        setDesignationType(document.getElementById('edit_designation_type'), true);

        if (data.designation_type === 'clients') {
            // Set designation (client) value
            document.getElementById('edit_designation').value = data.designation || '';

            // Populate the basis dropdown with the correct value
            populateClientProjects(data.designation, 'edit_basis', data.basis);
        } else {
            document.getElementById('edit_designation_other').value = data.designation || '';
            document.getElementById('edit_basis_wrapper').classList.add('hidden'); // Hide basis for non-clients
        }

        // Set remaining values
        document.getElementById('edit_description').value = data.description || '';
        document.getElementById('edit_unit').value = data.unit || '';
        document.getElementById('edit_unit_rate').value = data.unit_rate || '';
        document.getElementById('edit_quantity').value = data.quantity || '';
        document.getElementById('edit_total_amount').value = data.unit_rate * data.quantity || '';
        document.getElementById('edit_recipient').value = data.recipient || '';

        // Set the form action URL dynamically
        const form = document.getElementById('editExpenseForm');
        form.action = `/expenses/${data.id}`;
    }

    if (modalId === 'deleteExpenseModal' && data.id) {
        const form = document.getElementById('deleteExpenseForm');
        form.action = `/expenses/${data.id}`;
    }
}

function populateClientProjects(clientName, basisElementId, selectedBasis) {
    const client = projects.find(project => project.client_name === clientName);
    if (!client) return;

    const basisSelect = document.getElementById(basisElementId);
    basisSelect.innerHTML = '<option value="" disabled>Select Project</option>'; // Clear existing options

    // Add only those projects related to the selected client
    projects.forEach(project => {
        if (project.client_id == client.id) {
            const option = document.createElement('option');
            option.value = project.project_name;
            option.setAttribute('data-project-id', project.id);
            option.textContent = project.project_name;

            // Set the selected basis if provided
            if (selectedBasis && project.project_name === selectedBasis) {
                option.selected = true;
            }

            basisSelect.appendChild(option);
        }
    });

    // Make sure the basis dropdown is visible if applicable
    document.getElementById('edit_basis_wrapper').classList.remove('hidden');
}

function setDesignationType(element, isEdit = false) {
    const type = element.value;
    const prefix = isEdit ? 'edit_' : '';
    const clientWrapper = document.getElementById(`${prefix}designation_client_wrapper`);
    const otherWrapper = document.getElementById(`${prefix}designation_other_wrapper`);
    const basisWrapper = document.getElementById(`${prefix}basis_wrapper`);
    const clientField = document.getElementById(`${prefix}designation`);
    const otherField = document.getElementById(`${prefix}designation_other`);

    if (type === 'clients') {
        // Show designation (client) and basis fields
        clientWrapper.classList.remove('hidden');
        otherWrapper.classList.add('hidden');
        basisWrapper.classList.remove('hidden');

        // Set required attribute correctly
        clientField.required = true;
        otherField.required = false;

        // Clear other designation field value
        otherField.value = '';
    } else if (type === 'other') {
        // Show other designation field and hide client-related fields
        clientWrapper.classList.add('hidden');
        otherWrapper.classList.remove('hidden');
        basisWrapper.classList.add('hidden');

        // Set required attribute correctly
        clientField.required = false;
        otherField.required = true;

        // Clear client designation and basis fields
        clientField.value = '';
        document.getElementById(`${prefix}client_id`).value = '';
        document.getElementById(`${prefix}basis`).value = '';
    }
}


function setClientProjects(element, basisElementId = 'basis', isEdit = false, selectedBasis = null) {
    const clientId = element.options[element.selectedIndex]?.getAttribute('data-client-id');
    if (!clientId) return; // Exit if no client is selected

    // Set the client ID field
    const clientField = isEdit ? 'edit_client_id' : 'client_id';
    document.getElementById(clientField).value = clientId;

    const basisSelect = document.getElementById(basisElementId);
    basisSelect.innerHTML = '<option value="" disabled>Select Project</option>'; // Clear existing options

    // Iterate through projects and add only those related to the selected client
    projects.forEach(project => {
        if (project.client_id == clientId) {
            const option = document.createElement('option');
            option.value = project.project_name;
            option.setAttribute('data-project-id', project.id);
            option.textContent = project.project_name;

            // Set the selected basis if provided
            if (selectedBasis && project.project_name === selectedBasis) {
                option.selected = true;
            }

            basisSelect.appendChild(option);
        }
    });

    // Make sure the basis dropdown is visible if applicable
    const basisWrapper = isEdit ? 'edit_basis_wrapper' : 'basis_wrapper';
    document.getElementById(basisWrapper).classList.remove('hidden');
}

function setProjectId(element) {
    const projectId = element.options[element.selectedIndex]?.getAttribute('data-project-id');
    if (projectId) {
        document.getElementById('project_id').value = projectId;
    }
}

function setEditProjectId(element) {
    const projectId = element.options[element.selectedIndex]?.getAttribute('data-project-id');
    if (projectId) {
        document.getElementById('edit_project_id').value = projectId;
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
    document.body.classList.remove('overflow-y-hidden');

    // Reset fields when closing the add/edit modal
    if (modalId === 'addExpenseModal' || modalId === 'editExpenseModal') {
        const inputs = modal.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.value = '';
            if (input.type !== 'hidden') {
                input.required = false; // Remove required to prevent unwanted validation errors
            }
        });
    }
}

// Attach event listeners to designation dropdowns to update projects dynamically
document.addEventListener('DOMContentLoaded', function () {
    const addDesignationDropdown = document.getElementById('designation_type');
    const editDesignationDropdown = document.getElementById('edit_designation_type');

    if (addDesignationDropdown) {
        addDesignationDropdown.addEventListener('change', function () {
            setDesignationType(addDesignationDropdown);
        });
    }

    if (editDesignationDropdown) {
        editDesignationDropdown.addEventListener('change', function () {
            setDesignationType(editDesignationDropdown, true);
        });
    }
});
function totalAmountCalc () {
    unitRate = parseInt(document.getElementById('unit_rate').value);
    quantity = parseInt(document.getElementById('quantity').value);

    document.getElementById('total_amount').value = unitRate * quantity;
}


function totalAmountEditCalc() {
    unitRate = parseInt(document.getElementById('edit_unit_rate').value);
    quantity = parseInt(document.getElementById('edit_quantity').value);
    document.getElementById('edit_total_amount').value = unitRate * quantity;
}
</script>



</x-app-layout>
