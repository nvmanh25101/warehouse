@extends('layouts.master')
@section('content')

    <div class="col-12">
        <table id="data-table" class="table table-hover dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Số lượng tồn</th>
                <th>Ngày thêm</th>
                <th>Cảnh báo</th>
                <th>Sửa</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection
@push('js')
    <script type="module">
        $(document).ready(function () {
            let table = $('#data-table').DataTable({
                dom: 'ftp',
                processing: true,
                serverSide: true,
                ajax: '{{ route('warehouses.api') }}',
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
                    {data: 'product_id', name: 'product_id'},
                    {data: 'name', name: 'name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'warning',
                        render: function (data, type, row, meta) {
                            if (data) {
                                return `<span class="btn btn-danger">Tồn kho thấp</span>`;
                            }

                            return `<span class="btn btn-primary">Bình thường</span>`;
                        }
                    },
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
