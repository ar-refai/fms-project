<div class="relative">
    <input
        type="text"
        id="{{ $searchId }}"
        placeholder="Search..."
        class="block w-full px-4 py-2 mb-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
    />
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('{{ $searchId }}');
        const table = $('#{{ $tableId }}').DataTable();

        searchInput.addEventListener('input', (e) => {
            table.search(e.target.value).draw();
        });
    });
</script>
