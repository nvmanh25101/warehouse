@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="col-12">
        <form method="post" action="{{ route('customers.update', $customer) }}" class="needs-validation"
              id="form-edit"
              enctype="multipart/form-data"
              novalidate>
            @csrf
            @method('PUT')
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="name"
                           value="{{ $customer->name }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Thành phố</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="city"
                           value="{{ $customer->city }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Quận/ Huyện</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="district"
                           value="{{ $customer->district }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Xã/ Phường</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="ward"
                           value="{{ $customer->ward }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Địa chỉ</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="address"
                           value="{{ $customer->address }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Số điện thoại</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="phone"
                           value="{{ $customer->phone }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Ghi chú</label>
                <div class="col-9">
                    <textarea class="form-control" id="example-textarea" name="note"
                              rows="5">{{ $customer->note }}</textarea>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <a href="{{ route('customers.index') }}" class="btn btn-danger mb-3 me-4 btn-action">Hủy</a>
                <button class="btn btn-primary mb-3 btn-action" type="submit">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection
@push('js')

@endpush
