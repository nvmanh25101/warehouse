@extends('layouts.master')
@push('css')

@endpush
@section('content')
    <div class="row">
    </div>
@endsection
@push('js')
    @if (session('error'))
        <script>
            $.toast({
                heading: 'Thông báo',
                text: '{{ session('error') }}',
                icon: 'success',
                loader: true,
                loaderBg: 'rgba(0,0,0,0.2)',
                position: 'top-right',
                showHideTransition: 'slide',
            })
        </script>
    @endif
@endpush
