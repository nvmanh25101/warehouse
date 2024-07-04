@extends('layouts.master')
@section('content')
    <button class="btn btn-primary">
        <a href="{{ route('warehouses.export') }}">Xuất Excel</a>
    </button>
    <div class="col-12">
        <table id="data-table" class="table table-hover dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Số lượng tồn</th>
                <th>Số lượng bán</th>
                <th>Cảnh báo</th>
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
                dom: 'ftp',
                processing: true,
                serverSide: true,
                ajax: '{{ route('statistic_api') }}',
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
                    {data: 'export_quantity', name: 'export_quantity'},
                    {
                        data: 'warning',
                        name: 'warning',
                        render: function (data, type, row, meta) {
                            if (data) {
                                return `<span class="btn btn-danger">Tồn kho thấp</span>`;
                            }

                            return `<span class="btn btn-primary">Bình thường</span>`;
                        }
                    },
                ]
            });
        });
    </script>
@endpush
