@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="row mt-4">
        <div class="col-sm-6">
            <a href="{{ route('receipts.index') }}"
               class="btn text-muted d-none d-sm-inline-block btn-link font-weight-semibold">
                <i class="mdi mdi-arrow-left"></i> Hủy </a>
        </div> <!-- end col -->
        <div class="col-sm-6">
            <div class="text-sm-right">
                <button class="btn" id="submit">
                    <i class="mdi mdi-cart-plus mr-1"></i> Tạo phiếu
                </button>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row-->
    <div class="col-12">
        <form action="{{ route('receipts.store') }}" method="POST" id="form">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" name="note" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Người tạo</label>
                        <input type="text" id="user_name" class="form-control"
                               value="{{ auth()->user()->name }}"
                               disabled>
                    </div>
                    <div class="form-group">
                        <label>Ngày tạo</label>
                        <input type="text" id="created_at" class="form-control"
                               value="{{ now()->format('d-m-Y') }}"
                               disabled>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <select class="custom-select">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                                data-created_at="{{ $product->created_at }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" id="add-product" type="button">Thêm
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless table-centered mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Ngày thêm</th>
                                        <th>Xóa</th>
                                    </tr>
                                    </thead>
                                    <tbody class="products">

                                    </tbody>
                                </table>
                                <div
                                    class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade d-none"
                                    role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Lỗi - </strong>
                                </div>
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
            let products = [];
            let productElement = $(".products");

            $("#add-product").on("click", function () {
                let product = $(".custom-select  option:selected");
                let product_id = Number(product.val());
                let product_name = product.text();
                let created_at = product.data("created_at");

                let exist_product = products.find(product => product.product_id === product_id);

                if (exist_product) {
                    return;
                }

                addProduct(product_id, product_name, created_at);
            });

            productElement.on("click", ".delete-product", function () {
                let product_id = $(this).data("id");
                $(this).closest(".product").remove();
                products = products.filter(product => product !== product_id);
            });

            productElement.on("click", ".quantity", function () {
                $(".quantity").on("input", function () {
                    let quantity = $(this).val();
                    let product_id = $(this).data("id");
                    products = products.map(product => {
                        if (product.product_id === product_id) {
                            product.quantity = quantity;
                        }
                        return product;
                    });
                });
            });

            function addProduct(product_id, product_name, created_at) {
                let product = `
                    <tr class="product">
                        <td>
                            <input type="hidden" name="product_ids[]" value="${product_id}">
                            ${product_id}
                        </td>
                        <td>${product_name}</td>
                        <td>
                            <input type="number" data-id="${product_id}" name="quantities[]" class="form-control quantity" min="1" value="1">
                        </td>
                        <td>${created_at}</td>
                        <td>
                          <button class="btn btn-danger delete-product" data-id="${product_id}" type="button">Xóa</button>
                    </tr>
                `;
                productElement.append(product);

                products.push({
                    product_id: Number(product_id),
                    quantity: 1,
                });
            }

            $("#submit").on("click", function () {
                $("#form").submit();
            });

            @if (session('success'))
            $.notify('{{ session('success') }}', "success");
            @endif
            @if (session('error'))
            $.notify('{{ session('error') }}', "error");
            @endif
        });
    </script>
@endpush
