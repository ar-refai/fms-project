<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Banks') }}
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
                                onclick="openModal('startBankModal')">
                                Start Bank
                            </button>
                            <button class="px-4 py-2 text-white transition bg-green-500 rounded-md hover:bg-green-600"
                                onclick="openModal('addTransactionModal')">
                                Add New Transaction
                            </button>
                        </div>

                        {{-- Success Notify --}}
                        @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 border border-green-400 rounded-md bg-green-50">
                            <p>{{ session('success') }}</p>
                        </div>
                        @endif

                        {{-- Error Notify --}}
                        @if ($errors->any())
                        <div class="p-4 mb-4 text-red-700 border border-red-400 rounded-md bg-red-50">
                            <h3 class="text-lg font-semibold">Whoops! Something went wrong:</h3>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Main Table --}}
                        <div id="transactions-table" class="p-8 mt-6 rounded shadow lg:mt-0">
                            <table id="transactionsTable"
                                class="w-full text-sm text-left text-gray-900 data-table display stripe rtl:text-right dark:text-gray-100">
                                <thead
                                    class="text-xs text-gray-900 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Date</th>
                                        <th>Starting Balance</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Ending Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->transaction_id }}</td>
                                            <td>{{ $transaction->date }}</td>
                                            <td>{{ number_format($transaction->starting_balance, 2) }}</td>
                                            <td>{{ $transaction->type }}</td>
                                            <td>{{ number_format($transaction->amount, 2) }}</td>
                                            <td>{{ $transaction->description ?? 'N/A' }}</td>
                                            <td>{{ number_format($transaction->ending_balance, 2) }}</td>
                                            <td class="flex-col justify-start space-y-2">
                                                {{-- Edit Button --}}
                                                <button
                                                    onclick="openModal('editTransactionModal', {{ json_encode($transaction) }})"
                                                    class="w-full px-2 py-1 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                    Edit
                                                </button>

                                                {{-- Delete Button --}}
                                                <button
                                                    onclick="openModal('deleteTransactionModal', { id: {{ $transaction->id }} })"
                                                    class="w-full px-2 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Start Bank Modal --}}
                        <div id="startBankModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('startBankModal')" type="button"
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
                                    <h3 class="mb-4 text-xl font-bold">Start Bank</h3>
                                    <form method="POST" action="{{ route('banks.start') }}">
                                        @csrf
                                        <div>
                                            <label for="start_date" class="block text-sm">Date</label>
                                            <input type="date" name="date" id="start_date" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('startBankModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Close
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Start
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Add Transaction Modal --}}
                        <div id="addTransactionModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('addTransactionModal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-                                    center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <h3 class="mb-4 text-xl font-bold">Add New Transaction</h3>
                                    <form method="POST" action="{{ route('banks.store') }}">
                                        @csrf
                                        <div>
                                            <label for="date" class="block text-sm">Date</label>
                                            <input type="date" name="date" id="date" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="type" class="block text-sm">Type</label>
                                            <select name="type" id="type" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                                <option value="in flow">In Flow</option>
                                                <option value="out flow">Out Flow</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="amount" class="block text-sm">Amount</label>
                                            <input type="number" step="0.01" name="amount" id="amount" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="description" class="block text-sm">Description</label>
                                            <textarea name="description" id="description" rows="3"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"></textarea>
                                        </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('addTransactionModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Close
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-800">
                                                Add Transaction
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Transaction Modal --}}
                        <div id="editTransactionModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('editTransactionModal')" type="button"
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
                                    <h3 class="mb-4 text-xl font-bold">Edit Transaction</h3>
                                    <form method="POST" id="editTransactionForm">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label for="edit_transaction_id" class="block text-sm">Transaction ID</label>
                                            <input type="text" name="transaction_id" id="edit_transaction_id" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_date" class="block text-sm">Date</label>
                                            <input type="date" name="date" id="edit_date" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_starting_balance" class="block text-sm">Starting Balance</label>
                                            <input type="number" step="0.01" name="starting_balance"
                                                id="edit_starting_balance" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_type" class="block text-sm">Type</label>
                                            <input type="text" name="type" id="edit_type" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_amount" class="block text-sm">Amount</label>
                                            <input type="number" step="0.01" name="amount" id="edit_amount" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_description" class="block text-sm">Description</label>
                                            <textarea name="description" id="edit_description" rows="3"
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md"></textarea>
                                        </div>
                                        <div>
                                            <label for="edit_ending_balance" class="block text-sm">Ending Balance</label>
                                            <input type="number" step="0.01" name="ending_balance"
                                                id="edit_ending_balance" required
                                                class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md">
                                        </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('editTransactionModal')"
                                                class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-700">
                                                Close
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                                                Update Transaction
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Delete Transaction Modal --}}
                        <div id="deleteTransactionModal"
                            class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
                            <div
                                class="relative max-w-md mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
                                <div class="flex justify-end p-2">
                                    <button onclick="closeModal('deleteTransactionModal')" type="button"
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
                                    <p>Are you sure you want to delete this transaction?</p>
                                    <form method="POST" id="deleteTransactionForm">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex justify-center mt-4 space-x-4">
                                            <button type="button" onclick="closeModal('deleteTransactionModal')"
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

            if (modalId === 'editTransactionModal' && data) {
                document.getElementById('edit_transaction_id').value = data.transaction_id || '';
                document.getElementById('edit_date').value = data.date || '';
                document.getElementById('edit_starting_balance').value = data.starting_balance || '';
                document.getElementById('edit_type').value = data.type || '';
                document.getElementById('edit_amount').value = data.amount || '';
                document.getElementById('edit_description').value = data.description || '';
                document.getElementById('edit_ending_balance').value = data.ending_balance || '';

                const form = document.getElementById('editTransactionForm');
                form.action = `/banks/${data.id}`;
            }

            if (modalId === 'deleteTransactionModal' && data.id) {
                const form = document.getElementById('deleteTransactionForm');
                form.action = `/banks/${data.id}`;
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            document.body.classList.remove('overflow-y-hidden');
        }
    </script>
</x-app-layout>

