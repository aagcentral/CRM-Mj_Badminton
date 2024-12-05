 
 
    // Toggle div
    $(document).ready(function() {
        // $(".togglediv").hide();
        $("#toggleButton").click(function() {
            $(".togglediv").slideToggle("slow"); // Adjust the speed here ("slow", "fast", or milliseconds)
        });
    });
 


// <!-- validate number-->

    $(document).ready(function() {
        $('#validateno').on('input', function() {
            const input = $(this).val();
            const validPattern = /^\d*\.?\d*$/;

            if (!validPattern.test(input)) {
                $('#feeError').text("Please enter a valid number or decimal value.");
                $(this).val(input.slice(0, -1)); // Remove the last invalid character
            } else {
                $('#feeError').text(''); // Clear error if input is valid
            }
        });
    });


// <!-- Allow only numeric value with maxlength attribute for mobile-->

    $(document).ready(function() {
        $('.numericInput').on('input', function() {
            var maxlength = $(this).attr('maxlength');
            $(this).val($(this).val().replace(/[^\d]/g, '').slice(0, maxlength));
        });
    });
    $(document).ready(function() {
        $('.decimalInput').on('input', function() {
            var maxlength = $(this).attr('maxlength');
            var value = $(this).val().replace(/[^0-9.]/g, '');
            var parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1];
            }
            if (value.length > maxlength) {
                value = value.slice(0, maxlength);
            }
            $(this).val(value);
        });
    });

// <!-- passed date not select registraction -->

    $(document).ready(function() {
        var today = new Date().toISOString().split('T')[0];
        $('.restrict-past-date').attr('min', today);
    });


// <!--count Stock Total price  -->

// <!-- Table with Export Option with HInding 6th column -->

    $(document).ready(function() {
        $("#example1").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            ordering: false,
            paging: true,
            searching: true,
            info: true,
            dom: '<"row"<"col-12 d-flex flex-column flex-sm-row justify-content-between"lBf>>' + // Length, buttons, and filter in a column on small screens
                '<"row"<"col-12"tr>>' + // Table
                '<"row"<"col-12 col-md-5"i><"col-12 col-md-7"p>>', // Info and pagination
            buttons: [{
                    extend: 'copy',
                    text: '<i class="fa fa-copy" style="color: #007bff;"></i>'
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-csv" style="color: #ff8800;"></i>'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel" style="color: #28a745;"></i>'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf" style="color: #dc3545;"></i>',
                    exportOptions: {
                        columns: ':not(.no-print)'
                    },
                    customize: function(doc) {
                        doc.content[1].table.body.forEach(row => {
                            row.forEach((cell, i) => {
                                if (cell.styles && cell.styles.className && cell.styles.className.includes('no-print')) {
                                    cell.visible = false;
                                }
                            });
                        });
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print" style="color: #17a2b8;"></i>',
                    exportOptions: {
                        columns: ':not(.no-print)'
                    },
                    customize: function(win) {
                        $(win.document.body).find('th.no-print, td.no-print').css('display', 'none');
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-eye" style="color: #6c757d;"></i>'
                }
            ],
            columnDefs: [{
                targets: -1,
                className: 'no-print'
            }]
        });
    });


     
