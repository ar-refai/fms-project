import './bootstrap';
import Alpine from 'alpinejs';
import DataTable from 'datatables.net-dt';
// import 'datatables.net-buttons-dt'; // Include DataTables Buttons
// import 'datatables.net-buttons/js/buttons.html5.js'; // Enable export buttons
// import 'datatables.net-buttons/js/buttons.print.js'; // Enable print button

window.Alpine = Alpine;

Alpine.start();

// Function to initialize a DataTable with common configurations
function initializeDataTable(selector, config = {}) {
    const defaultConfig = {
        dom: 'Bfrtip', // Enable Buttons, Filter, and Pagination
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'], // Default Buttons
        columnDefs: [
            { orderable: false, targets: [3] }, // Disable sorting on the 4th column (index 3)
        ],
    };

    const finalConfig = { ...defaultConfig, ...config };

    $(selector).DataTable(finalConfig);
}

// Initialize DataTables for clientsTable
initializeDataTable('#clientsTable');
initializeDataTable('#dashboard-one');


// Initialize DataTables for incomesTable
initializeDataTable('#incomesTable');
initializeDataTable('#minClientTable');

