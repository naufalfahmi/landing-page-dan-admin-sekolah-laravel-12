@include('includes.datatable')
@include('includes.summernote')
@include('includes.select2')
@include('includes.datepicker')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('#articles').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            scrollY: true,
            ajax: {
                url: '{{ route('articles.data') }}',
                data: function(d) {
                    d.status = $('[name=status]').val();
                    d.start_date = $('[name=start_date]').val();
                    d.end_date = $('[name=end_date]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'penulis',
                    name: 'penulis'
                },
                {
                    data: 'tanggal_publish',
                    name: 'tanggal_publish'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>

    <script>
        $('#categories').select2({
            placeholder: 'Pilih Kategori',
            closeOnSelect: true,
            allowClear: true,
            ajax: {
                url: '{{ route('articles.categories_search') }}',
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        })

        $('[name=status]').on('change', function() {
            table.ajax.reload();
            $('#start_date').datetimepicker('clear');
            $('#end_date').datetimepicker('clear');
        });

        $('.datepicker').on('change.datetimepicker', function() {
            table.ajax.reload();
        });
    </script>

    <script>
        function addForm(url, title = 'Tambah Kategori') {
            $(modal).modal('show')
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            $(`${modal} #name`).prop('disabled', false);
            $('#spinner-border').hide();

            $(button).show();
            $(button).prop('disabled', false);

            resetForm(`${modal} form`);
        }

        function editData(url, title = 'Edit Role') {
            $.ajax({
                url: url,
                type: 'GET', // Ubah metode menjadi GET untuk mendapatkan data peran
                dataType: 'JSON',
                success: function(response) {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    $(`${modal} #name`).prop('disabled', false);
                    $(`${modal} #submitBtn`).show();

                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    $('#categories').empty(); // Clear previous options
                    for (let category of response.data.category_post) { // Assuming roles is an array
                        var option = new Option(category.name, category.id, true, true);
                        $('#categories').append(option);
                    }
                    $('#categories').trigger('change');

                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errorMessage,
                        showConfirmButton: true,
                    });
                }
            })
        }

        function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Delete Data!',
                text: 'Apakah anda yakin ingin menghapus ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    table.ajax.reload();
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            }).then(() => {
                                // Refresh tabel atau lakukan operasi lain yang diperlukan
                                table.ajax.reload();
                            });
                        }
                    });
                }
            });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();

                            table.ajax.reload();
                        })
                    }
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }
    </script>
@endpush
