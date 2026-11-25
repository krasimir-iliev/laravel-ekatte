<script type="module">
    $.extend(true, $.fn.dataTable, {
        ext: {
            classes: {
                length: {
                    container: 'dt-length d-flex align-items-center mb-3',
                    select: 'form-control w-100 mr-0'
                },
                search: {
                    container: 'dt-search d-flex align-items-center mb-3',
                    input: 'form-control w-100 ml-0'
                }
            }
        },
        defaults: {
            language: {
                lengthMenu: @json(__('datatables.lengthMenu')),
                search: @json(__('datatables.search')),
                searchPlaceholder: @json(__('datatables.searchPlaceholder')),
                loadingRecords: @json(__('datatables.loadingRecords')),
                emptyTable: @json(__('datatables.emptyTable')),
                zeroRecords: @json(__('datatables.zeroRecords')),
                info: @json(__('datatables.info')),
                infoEmpty: @json(__('datatables.infoEmpty')),
                infoFiltered: @json(__('datatables.infoFiltered')),
                processing: '<div class="spinner-border" role="status"><span class="sr-only"></span></div>',
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>'
                }
            }
        }
    });

    $(document).on('click', '.dt-bt-delete', function(e) {
        var element = $(this);

        Swal.fire({
            icon: 'question',
            title: '',
            text: @json(__('Do you want to delete the selected entry?')),
            confirmButtonText: @json(__('Delete')),
            cancelButtonText: @json(__('Cancel')),
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-styled btn btn-danger m-1',
                cancelButton: 'swal2-styled btn btn-primary m-1'
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: element.attr('href'),
                    type: 'DELETE',
                    success: function(data) {
                        element.closest('table').DataTable().row(element.parents('tr')).remove().draw();
                    }
                });
            }
        });

        e.preventDefault();
    });

    $(document).on('click', '.dt-bt-restore', function(e) {
        var element = $(this);

        Swal.fire({
            icon: 'question',
            title: '',
            text: @json(__('Do you want to restore the selected entry?')),
            confirmButtonText: @json(__('Restore')),
            cancelButtonText: @json(__('Cancel')),
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-styled btn btn-success m-1',
                cancelButton: 'swal2-styled btn btn-primary m-1'
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: element.attr('href'),
                    type: 'PATCH',
                    success: function(data) {
                        element.closest('table').DataTable().row(element.parents('tr')).remove().draw();
                    }
                });
            }
        });

        e.preventDefault();
    });
</script>
