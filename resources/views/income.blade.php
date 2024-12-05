<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Incomes') }}
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
                                onclick="openModal('addIncomeModal')">
                                Add New Income
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
                        <div id="recipients-income" class="p-8 mt-6 rounded shadow lg:mt-0">
                            <table id="incomesTable"
                                class="w-full text-sm text-left text-gray-900 data-table display stripe rtl:text-right dark:text-gray-100">
                                <thead
                                    class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                                    <tr>
                                        <th>Accounting ID</th>
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Instalment Type</th>
                                        <th>Designation</th>
                                        <th>Basis</th>
                                        <th>Total Amount</th>
                                        <th>Collection Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $income)
                                        <tr>
                                            <td>{{ $income->accounting_id }}</td>
                                            <td>{{ $income->date }}</td>
                                            <td>{{ $income->project->project_name ?? 'N/A' }}</td>
                                            <td>{{ $income->project->client->client_name ?? 'N/A' }}</td>
                                            <td>{{ $income->instalment_type }}</td>
                                            <td>{{ $income->designation }}</td>
                                            <td>{{ $income->basis }}</td>
                                            <td>{{ number_format($income->total_amount, 2) }}</td>
                                            <td>{{ $income->collection_type }}</td>
                                            <td class="flex-col space-y-2">
                                                {{-- Edit Button --}}
                                                <button
                                                    onclick="openModal('editIncomeModal', {{ json_encode($income) }})"
                                                    class="w-full px-2 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                    Edit
                                                </button>

                                                {{-- Delete Button --}}
                                                <button
                                                    onclick="openModal('deleteIncomeModal', { id: {{ $income->id }} })"
                                                    class="w-full px-2 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Add Income Modal --}}
                        <div id="addIncomeModal" class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('addIncomeModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Add New Income</h3>
                                    <form method="POST" action="{{ route('incomes.store') }}">
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
                                        <div>
                                            <label for="instalment_type" class="block text-sm">Instalment Type</label>
                                            <select name="instalment_type" id="instalment_type" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                <option value="Instalment">Instalment</option>
                                                <option value="Down-Payment">Down-Payment</option>
                                                <option value="Finalization Invoice">Finalization Invoice</option>
                                                <option value="Upfront">Upfront</option>
                                                <option value="Single-Payment">Single-Payment</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="designation" class="block text-sm">Client (Designation)</label>
                                            <select name="designation" id="designation" required
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
                                        <div>
                                            <label for="basis" class="block text-sm">Project (Basis)</label>
                                            <select name="basis" id="basis" required onchange="setProjectId(this)"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                <option value="" disabled selected>Select Project</option>
                                            </select>
                                            <!-- Add hidden input for project_id -->
                                            <input type="hidden" name="project_id" id="project_id">
                                        </div>
                                        <div>
                                            <label for="total_amount" class="block text-sm">Total Amount</label>
                                            <input type="number" step="0.01" name="total_amount" id="total_amount" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="collection_type" class="block text-sm">Collection Type</label>
                                            <input type="text" name="collection_type" id="collection_type" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('addIncomeModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Close
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Add Income
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        {{-- Edit Income Modal --}}
                        <div id="editIncomeModal"
                        class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                        <div class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                            <div class="flex justify-end p-2">
                                <button onclick="closeModal('editIncomeModal')" type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6">
                                <h3 class="mb-4 text-xl font-bold">Edit Income</h3>
                                <form method="POST" id="editIncomeForm" action="incomes.update">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="edit_accounting_id" class="block text-sm">Accounting ID</label>
                                        <input type="text" name="accounting_id" id="edit_accounting_id" required
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit_date" class="block text-sm">Date</label>
                                        <input type="date" name="date" id="edit_date" required
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit_instalment_type" class="block text-sm">Instalment Type</label>
                                        <select name="instalment_type" id="edit_instalment_type" required
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                            <option value="Instalment">Instalment</option>
                                            <option value="Down-Payment">Down-Payment</option>
                                            <option value="Finalization Invoice">Finalization Invoice</option>
                                            <option value="Upfront">Upfront</option>
                                            <option value="Single-Payment">Single-Payment</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="edit_designation" class="block text-sm">Client (Designation)</label>
                                        <select name="designation" id="edit_designation" required onchange="setEditClientId(this)"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"
                                            onchange="setClientProjects(this, 'edit_basis')">
                                            <option value="" disabled selected>Select Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->client_name }}" data-client-id="{{ $client->id }}">
                                                    {{ $client->client_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="client_id" id="edit_client_id">
                                    </div>
                                    <div>
                                        <label for="edit_basis" class="block text-sm">Project (Basis)</label>
                                        <select name="basis" id="edit_basis" required onchange="setEditProjectId(this)"
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                            <option value="" disabled selected>Select Project</option>
                                        </select>
                                        <input type="hidden" name="project_id" id="edit_project_id">
                                    </div>

                                    <div>
                                        <label for="edit_total_amount" class="block text-sm">Total Amount</label>
                                        <input type="number" step="0.01" name="total_amount" id="edit_total_amount" required
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit_collection_type" class="block text-sm">Collection Type</label>
                                        <input type="text" name="collection_type" id="edit_collection_type" required
                                            class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                    </div>
                                    <div class="flex justify-end mt-4 space-x-4">
                                        <button type="button" onclick="closeModal('editIncomeModal')"
                                            class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                            Close
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                            Update Income
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                        {{-- Delete Income Modal --}}
                        <div id="deleteIncomeModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('deleteIncomeModal')" type="button"
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
                                    <p>Are you sure you want to delete this income?</p>
                                    <form method="POST" id="deleteIncomeForm">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex justify-center mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('deleteIncomeModal')"
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
    {{--  --}}
    <script type="text/javascript">
        function openModal(modalId, data = {}) {
            console.log(data);

            const modal = document.getElementById(modalId);
            modal.style.display = 'block';
            document.body.classList.add('overflow-y-hidden');

            // Populate fields in the Edit Income modal
            if (modalId === 'editIncomeModal' && data) {
                document.getElementById('edit_accounting_id').value = data.accounting_id || '';
                document.getElementById('edit_date').value = data.date ? data.date.split(' ')[0] : ''; // Format date
                document.getElementById('edit_instalment_type').value = data.instalment_type || '';
                document.getElementById('edit_designation').value = data.designation || '';
                setClientProjects(document.getElementById('edit_designation'), 'edit_basis', data.basis);
                document.getElementById('edit_total_amount').value = data.total_amount || '';
                document.getElementById('edit_collection_type').value = data.collection_type || '';

                // Update hidden client_id based on the selected designation
                const clientOption = Array.from(document.getElementById('edit_designation').options)
                    .find(option => option.value === data.designation);
                if (clientOption) {
                    document.getElementById('edit_client_id').value = clientOption.getAttribute('data-client-id');
                }

                // Update the form's action to point to the correct route
                const form = document.getElementById('editIncomeForm');
                form.action = `/incomes/${data.id}`;
            }

            // Populate the Delete Income modal
            if (modalId === 'deleteIncomeModal' && data.id) {
                const form = document.getElementById('deleteIncomeForm');
                form.action = `/incomes/${data.id}`;
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            document.body.classList.remove('overflow-y-hidden');
        }
        function setClientProjects(element, basisElementId = 'basis', selectedBasis = null) {
    const clientId = element.options[element.selectedIndex]?.getAttribute('data-client-id');
    const clientField = basisElementId === 'edit_basis' ? 'edit_client_id' : 'client_id';
    const projectField = basisElementId === 'edit_basis' ? 'edit_project_id' : 'project_id';

    // Update client_id hidden input field
    document.getElementById(clientField).value = clientId;

    const projects = @json($projects);
    const basisSelect = document.getElementById(basisElementId);
    basisSelect.innerHTML = '<option value="" disabled selected>Select Project</option>'; // Clear the basis dropdown

    // Populate the basis/project dropdown based on the selected client
    projects.forEach(project => {
        if (project.client && project.client.id == clientId) {
            const option = document.createElement('option');
            option.value = project.project_name;
            option.setAttribute('data-project-id', project.id);
            option.textContent = project.project_name;
            if (selectedBasis && project.project_name === selectedBasis) {
                option.selected = true;
            }
            basisSelect.appendChild(option);
        }
    });

    // Set project_id hidden input field if a project was selected
    if (selectedBasis) {
        const selectedProject = projects.find(p => p.project_name === selectedBasis && p.client.id == clientId);
        if (selectedProject) {
            document.getElementById(projectField).value = selectedProject.id;
        }
    }
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

        function setEditClientId(element) {
            const clientId = element.options[element.selectedIndex]?.getAttribute('data-client-id');
            document.getElementById('edit_client_id').value = clientId;
        }
    </script>



</x-app-layout>
