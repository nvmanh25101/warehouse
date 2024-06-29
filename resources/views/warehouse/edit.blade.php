@extends('layouts.master')
@push('css')

@endpush
@section('content')
    <div class="col-12">
        <form method="post" action="{{ route('warehouses.update', $warehouse) }}" class="needs-validation"
              id="form-edit"
              enctype="multipart/form-data"
              novalidate>
            @csrf
            @method('PUT')
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Mã sản phẩm</label>
                <div class="col-9">
                    <input type="text" class="form-control"
                           value="{{ $product->id }}" required disabled>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên sản phẩm</label>
                <div class="col-9">
                    <input type="text" class="form-control"
                           value="{{ $product->name }}" disabled>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Ghi chú</label>
                <div class="col-9">
                    <textarea class="form-control" id="example-textarea" disabled
                              rows="5">{{ $product->note }}</textarea>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="quantity" class="col-3 col-form-label">Số lượng tồn</label>
                <div class="col-9">
                    <input type="number" disabled id="quantity" class="form-control"
                           value="{{ $warehouse->quantity }}"/>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="unit" class="col-3 col-form-label">Đơn vị</label>
                <div class="col-9">
                    <input type="text" disabled id="unit" class="form-control"
                           value="{{ $product->unit }}"/>
                </div>
            </div>

            <div class="form-group">
                <label>Ảnh</label>
                <div class="holder">
                    <img id="imgPreview" src="{{ asset('/' . $product->image) }}" alt="pic"/>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Mức cảnh báo</label>
                <div class="col-9">
                    <input type="number" class="form-control" name="threshold" value="{{ $warehouse->threshold }}"
                           min="0"/>
                </div>
            </div>
            <button class="btn btn-primary mb-3" type="submit">Cập nhật</button>
        </form>
    </div>
@endsection
@push('js')
    <script type="module">
        $(document).ready(function () {
            let image = $("#image");
            let imgPreview = $("#imgPreview");

            if (imgPreview.attr("src") !== "") {
                $(".holder").show();
            }
            let imgURL;
            image.change(function (e) {
                $(".holder").show();
                imgURL = URL.createObjectURL(e.target.files[0]);
                imgPreview.attr("src", imgURL);
            });

            @if(session('success'))
            $.notify('{{ session('success') }}', "success");
            @endif
            @if(session('error'))
            $.notify('{{ session('error') }}', "error");
            @endif
        })
    </script>
@endpush
