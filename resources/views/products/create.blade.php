@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="col-12">

        <form method="post" action="{{ route('products.store') }}" class="needs-validation form-horizontal row"
              novalidate
              enctype="multipart/form-data">
            @csrf
            <div class="col-6">
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
                        <select class="form-control" name="supplier_id">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="quantity" class="col-3 col-form-label">Số lượng</label>
                    <div class="col-9">
                        <input type="number" name="quantity" id="quantity" class=" form-control" min="1"
                               value="{{ old('quantity') }}"/>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="unit" class="col-3 col-form-label">Đơn vị</label>
                    <div class="col-9">
                        <input type="text" name="unit" id="unit" class=" form-control"
                               value="{{ old('unit') }}"/>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" class="form-control-file" name="image"
                           value="{{ asset('/' . old('image')) }}" required
                           id="image"
                           accept="image/*">
                    <div
                        class="draft h-screen w-100 border border-black">
                        <img src="{{ asset('/images/no-image.png') }}" alt="pic"/>
                    </div>
                    <div class="holder">
                        <img
                            id="imgPreview"
                            src="#" alt="pic"/>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary mb-3" type="submit">Thêm</button>
        </form>
    </div>
@endsection
@push('js')
    <script type="module">
        $(document).ready(function () {
            let image = $("#image");
            let imgURL;
            image.change(function (e) {
                $(".draft").hide();
                $(".draft img").hide();
                $(".holder").show();
                imgURL = URL.createObjectURL(e.target.files[0]);
                $("#imgPreview").attr("src", imgURL);
            });
        })
    </script>
@endpush
