@extends('layouts.master')
@section('content')

    <div class="col-12">
        <div class="d-flex flex-row-reverse">
            <a href="{{ route('exports.create') }}" class="btn btn-outline-primary">Thêm mới</a>
        </div>
        <table id="data-table" class="table table-hover dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Người tạo</th>
                <th>Ngày tạo</th>
                <th>Khách hàng</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection
@push('js')
    <script src="{{ asset('storage/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('storage/notify.min.js') }}"></script>
    <script type="text/javascript">
        @if(session('success'))
        $.notify('{{ session('success') }}', "success");
        @endif
        @if(session('error'))
        $.notify('{{ session('error') }}', "error");
        @endif
    </script>
    <script type="module">
        $(document).ready(function () {
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('exports.api') }}',
                search: {
                    boundary: true
                },
                layout: {
                    topStart: {
                        search: {
                            placeholder: 'Tìm kiếm',
                            text: ''
                        }
                    },
                    topEnd: null,
                    bottomStart: null
                },
                "columnDefs": [{
                    "targets": 1,
                    "data": "name",
                    "render": function (data, type, row, meta) {
                        return type === 'display' && data.length > 40 ?
                            '<span title="' + data + '">' + data.substr(0, 38) + '...</span>' :
                            data;
                    }
                }],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'customer_name', name: 'customer_name'},
                    {
                        data: 'edit',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `<a class="btn btn-primary" href="${data}"><i class='mdi mdi-pencil'></i></a>`;
                        }
                    },
                    {
                        data: 'destroy',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `<form action="${data}" method="post">
                                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-delete btn btn-danger"><i class='mdi mdi-delete'></i></button>
                        </form>`;
                        }
                    },
                ]
            });

            $(document).on('click', '.btn-delete', function () {
                let form = $(this).parents('form');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Bạn có chắc chắn muốn xóa?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Đồng ý",
                    cancelButtonText: "Hủy",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            dataType: 'json',
                            data: form.serialize(),
                            success: function (res) {
                                swalWithBootstrapButtons.fire({
                                    title: "Thành công!",
                                    text: res['success'],
                                    icon: "success"
                                });
                                table.draw();
                            },
                            error: function (res) {
                                swalWithBootstrapButtons.fire({
                                    title: "Hủy!",
                                    text: 'Bạn không có quyền xóa!',
                                    icon: "error"
                                });
                            },
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire({
                            title: "Hủy!",
                            text: "An toàn :)",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
@endpush
