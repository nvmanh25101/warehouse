@extends('layouts.master')
@section('content')

    <div class="col-12">
        <div class="d-flex flex-row-reverse">
            <a href="{{ route('receipts.create') }}" class="btn btn-outline-primary">Thêm mới</a>
        </div>
        <table id="data-table" class="table table-hover dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Người tạo</th>
                <th>Ngày tạo</th>
                <th>Sửa</th>
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
                processing: true,
                serverSide: true,
                ajax: '{{ route('receipts.api') }}',
                // "columnDefs": [{
                //     "targets": 1,
                //     "data": "name",
                //     "render": function (data, type, row, meta) {
                //         return type === 'display' && data.length > 40 ?
                //             '<span title="' + data + '">' + data.substr(0, 38) + '...</span>' :
                //             data;
                //     }
                // }],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'edit',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `<a class="btn btn-primary" href="${data}"><i class='mdi mdi-pencil'></i></a>`;
                        }
                    },
                ]
            });

            @if(session('success'))
            $.notify('{{ session('success') }}', "success");
            @endif
            @if(session('error'))
            $.notify('{{ session('error') }}', "error");
            @endif
        });
    </script>
@endpush
