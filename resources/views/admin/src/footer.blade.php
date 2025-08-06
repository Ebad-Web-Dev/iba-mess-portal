<footer class="main-footer">
    <div class="footer-left">
        <div class="bullet"></div> <a href="templateshub.net" style="color: #801f0f;">Institute of Business
            Administration</a>
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>
<!-- jQuery (MUST come first) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap Bundle (optional, if needed by your template) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- JSZip (required for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- FontAwesome (fixing your current CORS issues) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#student-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.dashboard') }}",
            columns: [
                { data: 'DT_RowIndex', name: null, orderable: false, searchable: false },
                { data: 'room_no', name: 'room_no' },
                { data: 'name', name: 'name' },
                { data: 'class', name: 'class' },
                { data: 'batch', name: 'batch' },
                { data: 'erp_id', name: 'erp_id' },
                { data: 'status', name: 'enabled', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });



    </script>
    <script>

    $(document).ready(function() {
    $('#meals-table').DataTable({
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success',
                title: 'Student_Meals_Report',
                exportOptions: {
                    // columns: ':not(:last-child)', // Skip action column
                    format: {
                        body: function(data, row, column, node) {
                            // Clean up HTML tags in exported data
                            return data.replace(/<br\s*\/?>/gi, "\n")
                                      .replace(/<[^>]*>/g, "");
                        }
                    }
                }
            }
        ],
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin.students.meals') }}",
            dataSrc: 'data'
        },
        columns: [
            { 
                data: 'student_erp', 
                name: 'student_erp',
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'student.name', 
                name: 'student.name',
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'student.class', 
                name: 'student.class',
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'menu_types', 
                name: 'menu_types',
                orderable: false,
                searchable: true,
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'menu_rates', 
                name: 'menu_rates',
                orderable: false,
                searchable: true,
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'total_price', 
                name: 'total_price',
                render: function(data) {
                    return data ? 'PKR. ' + data : '-';
                }
            },
            { 
                data: 'start_date', 
                name: 'start_date',
                render: function(data) {
                    return data ? new Date(data).toLocaleDateString() : '-';
                }
            },
            { 
                data: 'end_date', 
                name: 'end_date',
                render: function(data) {
                    return data ? new Date(data).toLocaleDateString() : '-';
                }
            },
            { 
                data: 'student.room_no', 
                name: 'student.room_no',
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: 'payment_status', 
                name: 'payment_status',
                orderable: true,
                searchable: true,
                render: function(data) {
                    return data || '-';
                }
            },
            // { 
            //     data: 'action', 
            //     name: 'action', 
            //     orderable: false, 
            //     searchable: false 
            // }
        ]
    });
});
</script>
</body>

<!-- index.html  Tue, 07 Jan 2020 03:35:33 GMT -->

</html>