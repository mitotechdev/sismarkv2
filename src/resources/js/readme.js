// Bagian kode untuk menu sales order, untuk menampilkan/mengaktifkan modal pada datatbles,
// kode ini awalnya dipakai agar modal dapat di jalankan didalam datatables, dan dapat menjalakan fungsi select-box tanpa kode ini kedua hal tersebut tidak jalan
async function initializeDataTable() {
    $('#datatable_sismark').DataTable({
        responsive: true,
        serverSide: true,
        ajax: "{{ route('sales-order.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
            { data: 'code', name: 'code', title: 'ID', orderable: true },
            { data: 'tanggal_order', name: 'tanggal_order', title: 'Date'},
            { data: 'no_sales_order', name: 'no_sales_order', title: 'PO'},
            { data: 'konsumen', name: 'konsumen', title: 'Customer'},
            { data: 'status', name: 'status', title: 'Status', render: function($data) {
                const data = JSON.parse($data);
                return '<span class="badge text-bg-'+ data.approval.tag_front_end +'">'+ data.approval.name +'</span>';
            }},
            { data: 'aksi', name: 'aksi', title: 'Act.'},
        ],
        drawCallback: async function() {
            await new Promise(resolve => setTimeout(resolve, 500));
            const config = {
                search: true,
                creatable: false,
                clearable: true,
                size: '',
            }
            let selectBox = document.querySelectorAll('.select-box');
            selectBox.forEach(element => {
                if (element && element.tagName === 'SELECT') {
                    dselect(element, config);
                } 
            });
        }
    });
}

$(document).ready(function() {
    initializeDataTable();
});