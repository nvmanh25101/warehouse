@php use Illuminate\Support\Facades\Vite; @endphp
<div class="left-side-menu bg-white dark:bg-slate-800">

    <!-- LOGO -->
    <a href="{{ route('dashboard') }}" class="logo text-center logo-light h-20">
        <span class="logo-lg">
            <img src="{{ Vite::images('logo.png') }}" alt="" class="h-20">
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
                {{--                <li class="side-nav-item">--}}
                {{--                    <a href="{{ route('admin.employees.resign') }}" class="side-nav-link">Nhân viên nghỉ việc</a>--}}
                {{--                </li>--}}
                <li class="side-nav-item">
                    <a href="" class="side-nav-link">
                        <span>Voucher</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="" class="side-nav-link">
                        <span>Thống kê</span>
                    </a>
                </li>
            @endif
            <li class="side-nav-item">
                <a href="" class="side-nav-link">
                    <span>Đơn hàng</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="" class="side-nav-link">
                    <span>Lịch đặt</span>
                </a>
            </li>

        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
