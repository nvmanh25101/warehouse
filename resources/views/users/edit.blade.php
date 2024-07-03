@extends('layouts.master')
@push('css')
@endpush
@section('content')
    <div class="col-12">
        <form method="post" action="{{ route('users.update', $user) }}" class="needs-validation"
              id="form-edit"
              enctype="multipart/form-data"
              novalidate>
            @csrf
            @method('PUT')
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="name"
                           value="{{ $user->name }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Thành phố</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="city"
                           value="{{ $user->city }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Quận/ Huyện</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="district"
                           value="{{ $user->district }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Xã/ Phường</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="ward"
                           value="{{ $user->ward }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Địa chỉ</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="address"
                           value="{{ $user->address }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Số điện thoại</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="phone"
                           value="{{ $user->phone }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Tên đăng nhập</label>
                <div class="col-9">
                    <input type="text" class="form-control"
                           value="{{ $user->username }}" disabled>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Mật khẩu</label>
                <div class="col-9">
                    <input type="text" class="form-control" name="password">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-3 col-form-label">Chức vụ</label>
                <div class="col-9">
                    <select class="form-control" name="role" required>
                        @foreach($roles as $key => $value)
                            <option
                                @if($user->role === $value)
                                    selected
                                @endif
                                value="{{ $value }}"
                            >{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="btn btn-primary mb-3" type="submit">Cập nhật</button>
        </form>
    </div>
@endsection
@push('js')

@endpush
