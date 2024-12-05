<div id="addQuotationModal" class="fixed inset-0 z-50 hidden w-full h-full px-4 overflow-y-auto bg-gray-900 bg-opacity-60">
    <div class="relative max-w-3xl mx-auto text-gray-100 bg-gray-800 rounded-md shadow-xl top-40">
        <div class="flex justify-end p-2">
            <button onclick="closeModal('addQuotationModal')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <h3 class="mb-4 text-xl font-bold">Create Quotation</h3>
            <form id="quotationForm" method="POST" action="{{ route('quotations.store') }}" onsubmit="prepareQuotationData(event)">
                @csrf
                <div class="mb-4">
                    <label for="project_id" class="block text-sm">Select Project</label>
                    <select name="project_id" id="project_id" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                        <option value="" disabled selected>Select a project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" id="quotationItemsInput" name="quotation_items" />
                <div id="quotationItems">
                    <!-- Initial Quotation Item -->
                    <div class="mb-4 quotation-item">
                        <div class="flex space-x-4">
                            <div class="w-1/5">
                                <label class="block text-sm">Item Title</label>
                                <input type="text" name="item_title[]" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                            </div>
                            <div class="w-1/5">
                                <label class="block text-sm">Unit</label>
                                <input type="text" name="unit[]" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                            </div>
                            <div class="w-1/5">
                                <label class="block text-sm">Unit Rate</label>
                                <input type="number" name="unit_rate[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" oninput="updatePrice(this)" required>
                            </div>
                            <div class="w-1/5">
                                <label class="block text-sm">Quantity</label>
                                <input type="number" name="quantity[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" oninput="updatePrice(this)" required>
                            </div>
                            <div class="w-1/5">
                                <label class="block text-sm">Price</label>
                                <input type="number" name="price[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" readonly>
                            </div>
                            <div class="flex items-end w-1/5">
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
                    <button type="submit"
                        class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-800">
                        Submit Quotation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function addQuotationItem() {
        const quotationItemsContainer = document.getElementById('quotationItems');
        const newItem = document.createElement('div');
        newItem.classList.add('quotation-item', 'mb-4');
        newItem.innerHTML = `
            <div class="flex space-x-4">
                <div class="w-1/5">
                    <label class="block text-sm">Item Title</label>
                    <input type="text" name="item_title[]" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="w-1/5">
                    <label class="block text-sm">Unit</label>
                    <input type="text" name="unit[]" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" required>
                </div>
                <div class="w-1/5">
                    <label class="block text-sm">Unit Rate</label>
                    <input type="number" name="unit_rate[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" oninput="updatePrice(this)" required>
                </div>
                <div class="w-1/5">
                    <label class="block text-sm">Quantity</label>
                    <input type="number" name="quantity[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" oninput="updatePrice(this)" required>
                </div>
                <div class="w-1/5">
                    <label class="block text-sm">Price</label>
                    <input type="number" name="price[]" min="0" step="0.01" class="w-full p-2 mt-2 text-gray-100 bg-gray-700 rounded-md" readonly>
                </div>
                <div class="flex items-end w-1/5">
                    <button type="button" onclick="removeQuotationItem(this)" class="px-2 py-1 mt-2 text-sm text-white bg-red-600 rounded-md hover:bg-red-800">Delete</button>
                </div>
            </div>
        `;
        quotationItemsContainer.appendChild(newItem);
    }

    function removeQuotationItem(button) {
        const quotationItemsContainer = document.getElementById('quotationItems');
        if (quotationItemsContainer.children.length > 1) {
            const item = button.closest('.quotation-item');
            item.remove();
        } else {
            alert('At least one quotation item is required.');
        }
    }

    function updatePrice(input) {
        const row = input.closest('.quotation-item');
        const unitRate = parseFloat(row.querySelector('input[name="unit_rate[]"]').value) || 0;
        const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
        const priceInput = row.querySelector('input[name="price[]"]');
        priceInput.value = (unitRate * quantity).toFixed(2);
    }

    function prepareQuotationData(event) {
        const form = document.getElementById('quotationForm');
        const formData = new FormData(form);

        const items = [];
        for (let i = 0; i < formData.getAll('item_title[]').length; i++) {
            items.push({
                item_title: formData.getAll('item_title[]')[i],
                unit: formData.getAll('unit[]')[i],
                unit_rate: parseFloat(formData.getAll('unit_rate[]')[i]),
                quantity: parseFloat(formData.getAll('quantity[]')[i]),
                price: parseFloat(formData.getAll('price[]')[i]),
            });
        }

        // Convert items to JSON and set hidden input value
        const quotationItemsInput = document.getElementById('quotationItemsInput');
        quotationItemsInput.value = JSON.stringify(items);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');
    }
</script>
