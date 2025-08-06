 <!-- Footer -->
 <footer class="main-footer">
        <hr>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <div class="bullet"></div> <a href="templateshub.net">Institute of Business Administration</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="text-muted">© {{ date('Y') }} IBA Mess Portal. All rights reserved.</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    
    <script>
        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });

        // Initialize DataTable with scroll
        $(document).ready(function() {
            $('#subscriptions-table').DataTable({
                dom: '<"top"<"row"<"col-md-6"B><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"l><"col-md-6"p>>><"clear">',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel me-2"></i>Excel',
                        className: 'btn btn-success',
                        title: 'My_Meal_Subscriptions_Report',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: function(data, row, column, node) {
                                    return data.replace(/<br\s*\/?>/gi, "\n")
                                              .replace(/<[^>]*>/g, "");
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print me-2"></i>Print',
                        className: 'btn btn-primary',
                        title: 'My Meal Subscriptions',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false
                        },
                        customize: function(win) {
                            $(win.document.body).css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                            
                            $(win.document.body).find('h1').css({
                                'text-align': 'center',
                                'color': '#801f0f',
                                'margin-bottom': '20px'
                            });
                        }
                    }
                ],
                scrollX: true,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('student.subscription') }}",
                    type: "GET",
                    dataSrc: 'data'
                },
                columns: [
                    { 
                        data: 'month', 
                        name: 'month',
                        render: function(data) {
                            return data ? '<span class="fw-semibold">' + data + '</span>' : '-';
                        }
                    },
                    { 
                        data: 'menu_types', 
                        name: 'menu_types',
                        orderable: false,
                        searchable: true,
                        render: function(data) {
                            return data ? data.replace(/,/g, '<br>') : '-';
                        }
                    },
                    { 
                        data: 'menu_rates', 
                        name: 'menu_rates',
                        orderable: false,
                        searchable: true,
                        render: function(data) {
                            return data ? data.replace(/,/g, '<br>') : '-';
                        }
                    },
                    { 
                        data: 'total_price', 
                        name: 'total_price',
                        render: function(data) {
                            return data ? '<span class="fw-bold text-primary">' + data + '</span>' : '-';
                        }
                    },
                    { 
                        data: 'start_date', 
                        name: 'start_date',
                        render: function(data) {
                            return data ? '<span class="text-nowrap">' + data + '</span>' : '-';
                        }
                    },
                    { 
                        data: 'end_date', 
                        name: 'end_date',
                        render: function(data) {
                            return data ? '<span class="text-nowrap">' + data + '</span>' : '-';
                        }
                    },
                   {
                        data: 'payment_status', 
                        name: 'payment_status',
                        render: function(data) {
                            if (!data) return '-';
                            
                            let badgeClass = 'badge-secondary';
                            if (data === 'Paid') {
                                badgeClass = 'badge-success';
                            } else if (data === 'Pending') {
                                badgeClass = 'badge-warning';
                            } else if (data === 'Unpaid' || data === 'Canceled') {
                                badgeClass = 'badge-danger';
                            }
                            
                            return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                        }
                    },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return data || '<div class="btn-group" role="group">' +
                                '<button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>' +
                                '<button class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i></button>' +
                                '</div>';
                        }
                    }
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search subscriptions...",
                    lengthMenu: "Show _MENU_ subscriptions per page",
                    zeroRecords: "No subscriptions found",
                    info: "Showing _START_ to _END_ of _TOTAL_ subscriptions",
                    infoEmpty: "No subscriptions available",
                    infoFiltered: "(filtered from _MAX_ total subscriptions)",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    }
                },
                initComplete: function() {
                    $('.dt-buttons .btn').removeClass('btn-secondary');
                },
                drawCallback: function() {
                    // Add data-label attribute for responsive display
                    if ($('#subscriptions-table').hasClass('collapsed')) {
                        $('#subscriptions-table tbody td').each(function() {
                            var headerText = $('#subscriptions-table thead th').eq($(this).index()).text();
                            $(this).attr('data-label', headerText);
                        });
                    }
                }
            });
            
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Initialize Select2
            $('#meal-plan-select').select2({
                placeholder: "Select a meal plan",
                allowClear: true,
                theme: 'bootstrap4'
            });

           
        });
    </script>
</body>
</html>