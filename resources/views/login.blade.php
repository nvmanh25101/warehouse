<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <!-- App css -->
    @vite('resources/css/icons.css')
    @vite('resources/css/app-creative.min.css')
</head>
<body class="authentication-bg" data-layout-config="{&quot;darkMode&quot;:false}">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">
                        @include('layouts.errors')
                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Đăng nhập</h4>
                        </div>

                        <form action="{{ route('processLogin') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="emailaddress">Tên đăng nhập</label>
                                <input class="form-control" type="text" name="username" id="emailaddress" required
                                       placeholder="Tên đăng nhập">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control"
                                           placeholder="Mật khẩu">
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary" type="submit"> Đăng nhập</button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- bundle -->
@vite('resources/js/vendor.min.js')
@vite('resources/js/app.min.js')

</body>
</html>
