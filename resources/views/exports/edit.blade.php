@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-sm-6">
            <a href="{{ route('exports.index') }}"
               class="btn text-muted d-none d-sm-inline-block btn-link font-weight-semibold">
                <i class="mdi mdi-arrow-left"></i> Hủy </a>
        </div> <!-- end col -->
        <div class="col-sm-6">
            <div class="text-sm-right">
                <button class="btn" id="submit">
                    <i class="mdi mdi-cart-plus mr-1"></i> Cập nhật
                </button>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row-->
    <div class="col-12">
        <form action="{{ route('exports.update', $export) }}" method="POST" id="form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $export->name }}">
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" name="note" rows="3">{{  $export->note }}</textarea>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Người tạo</label>
                        <input type="text" id="user_name" class="form-control"
                               value="{{ $export->user->name }}"
                               disabled>
                    </div>
                    <div class="form-group">
                        <label>Ngày tạo</label>
                        <input type="text" id="created_at" class="form-control"
                               value="{{  $export->created_at }}"
                               disabled>
                    </div>
                    <div class="form-group">
                        <label>Khách hàng</label>
                        <select class="form-control" name="customer_id">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        @if($export->customer_id === $customer->id)
                                            selected
                                    @endif
                                >{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ngày xuất</label>
                        <input type="date" class="form-control" name="export_date" value="{{  $export->export_date }}">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-borderless table-centered mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng tồn</th>
                                        <th>Số lượng</th>
                                        <th>Ngày thêm</th>
                                    </tr>
                                    </thead>
                                    <tbody class="products">
                                    @foreach($export->warehouses as $warehouse)
                                        <tr class="product">
                                            <td>
                                                {{ $warehouse->product_id }}
                                            </td>
                                            <td>
                                                {{ $products->where('id', $warehouse->product_id)->first()->name }}
                                            </td>
                                            <td>{{ $warehouse->quantity }}</td>
                                            <td>
                                                {{ $warehouse->pivot->quantity }}
                                            </td>
                                            <td>{{ $warehouse->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div> <!-- end table-responsive-->

                            <!-- action buttons-->
                        </div>
                        <!-- end col -->

                    </div> <!-- end row -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </form>
    </div>
@endsection
@push('js')
    <script type="module">
        $(document).ready(function () {
            $("#submit").on("click", function () {
                $("#form").submit();
            });
        });
    </script>
@endpush
