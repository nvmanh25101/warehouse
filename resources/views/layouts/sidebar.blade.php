@php use Illuminate\Support\Facades\Vite; @endphp
<div class="left-side-menu bg-white dark:bg-slate-800">

    <!-- LOGO -->
    <a href="{{ route('dashboard') }}" class="logo text-center logo-light h-20">
        <span class="logo-lg">
            <img src="{{ Vite::image('logo.png') }}" alt="" class="h-20">
        </span>
    </a>

    <div class="mt-2 h-100" id="left-side-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="metismenu side-nav">

            <li class="side-nav-item">
                <a href="{{ route('dashboard') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span>Dashboards</span>
                </a>
            </li>
            @if (Auth::user()->role === \App\Enums\UserRoleEnum::ADMIN)
                <li class="side-nav-item">
                    <a href="{{ route('products.index') }}" class="side-nav-link" aria-expanded="true">
                        {{--                        <i class="uil-store"></i>--}}
                        <span> Sản phẩm </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('exports.index') }}" class="side-nav-link" aria-expanded="true">
                        {{--                        <i class="uil-store"></i>--}}
                        <span> Quản lý xuất kho </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('receipts.index') }}" class="side-nav-link" aria-expanded="true">
                        {{--                        <i class="uil-store"></i>--}}
                        <span> Quản lý nhập kho </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('warehouses.index') }}" class="side-nav-link">
                        <span> Quản lý tồn kho </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('suppliers.index') }}" class="side-nav-link">
                        <span> Nhà cung cấp </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="" class="side-nav-link">
                        <span>Thống kê</span>
                    </a>
                </li>
            @endif
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
