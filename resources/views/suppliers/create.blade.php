@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="col-12">
        <form method="post" action="{{ route('suppliers.store') }}" class="needs-validation form-horizontal" novalidate
              enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên nhà cung cấp</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="name"
                           value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Địa chỉ</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="address"
                           value="{{ old('address') }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Số điện thoại</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="phone"
                           value="{{ old('phone') }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Ghi chú</label>
                <div class="col-9">
                    <textarea class="form-control" id="example-textarea" name="note"
                              rows="5">{{ old('note') }}</textarea>
                </div>
            </div>
            <button class="btn btn-primary mb-3" type="submit">Thêm</button>
        </form>
    </div>
@endsection
@push('js')
@endpush
