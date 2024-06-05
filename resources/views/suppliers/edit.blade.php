@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="col-12">
        <form method="post" action="{{ route('suppliers.update', $supplier) }}" class="needs-validation"
              id="form-edit"
              enctype="multipart/form-data"
              novalidate>
            @csrf
            @method('PUT')
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên nhà cung cấp</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="name"
                           value="{{ $supplier->name }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Địa chỉ</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="address"
                           value="{{ $supplier->address }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Số điện thoại</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="phone"
                           value="{{ $supplier->phone }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Ghi chú</label>
                <div class="col-9">
                    <textarea class="form-control" id="example-textarea" name="note"
                              rows="5">{{ $supplier->note }}</textarea>
                </div>
            </div>
            <button class="btn btn-primary mb-3" type="submit">Cập nhật</button>
        </form>
    </div>
@endsection
@push('js')

@endpush
