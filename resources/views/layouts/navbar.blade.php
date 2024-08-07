@php use App\Enums\AdminType;use App\Enums\NotiType;use App\Enums\UserRoleEnum; @endphp
<div class="navbar-custom d-flex justify-between">
    <div class="ms-10 d-flex justify-between flex-1">
        <div class="text-3xl text-red-500 d-flex items-center">INNOVATION</div>
        <div class="text-3xl text-green-500 d-flex items-center">INTELLIGENT</div>
        <div class="text-3xl text-yellow-500 d-flex items-center">INFORMATION</div>
    </div>
    <ul class="list-unstyled topbar-right-menu float-right mb-0 ms-10">
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#"
               role="button" aria-haspopup="false" aria-expanded="false">
                <span>
                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                    <span
                        class="account-position">{{ UserRoleEnum::getKeyByValue(Auth::user()->role) }}</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Xin chào !</h6>
                </div>

                <!-- item-->
                <a href="{{ route('profiles.edit', Auth::id()) }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle mr-1"></i>
                    <span>Tài khoản</span>
                </a>

                <!-- item-->
                <a href="{{ route("logout") }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout mr-1"></i>
                    <span>Đăng xuất</span>
                </a>

            </div>
        </li>
    </ul>
    <button class="button-menu-mobile open-left disable-btn">
        <i class="mdi mdi-menu"></i>
    </button>

</div>
