@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="col-12">
        <form method="post" action="{{ route('products.store') }}" class="needs-validation form-horizontal" novalidate
              enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Mã sản phẩm</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="code"
                           value="{{ old('code') }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên sản phẩm</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="name"
                           value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Ghi chú</label>
                <div class="col-9">
                    <textarea class="form-control" id="example-textarea" name="note"
                              rows="5">{{ old('note') }}</textarea>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Nhà cung cấp</label>
                <div class="col-9">
                    <select class="form-control" name="customer_id">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{--            <div class="form-group">--}}
            {{--                <label>Ảnh</label>--}}
            {{--                <input type="file" class="form-control-file" name="image" value="{{ old('image') }}" required id="image"--}}
            {{--                       accept="image/*">--}}
            {{--                <div class="holder">--}}
            {{--                    <img--}}
            {{--                        id="imgPreview"--}}
            {{--                        src="#" alt="pic"/>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="form-group row mb-3">
                <label for="quantity" class="col-3 col-form-label">Số lượng</label>
                <div class="col-9">
                    <input type="number" name="quantity" id="quantity" class=" form-control" min="1"
                           value="{{ old('quantity') }}"/>
                </div>
            </div>

            <button class="btn btn-primary mb-3" type="submit">Thêm</button>
        </form>
    </div>
@endsection
@push('js')
    @vite('resources/js/jquery-3.7.1.min.js')
    <script>
        $(document).ready(function () {
            let image = $("#image");
            let imgURL;
            image.change(function (e) {
                $(".holder").show();
                imgURL = URL.createObjectURL(e.target.files[0]);
                $("#imgPreview").attr("src", imgURL);
            });
        })
    </script>
@endpush
