<!doctype html>
<html lang="en">

<head>
    <title>Login | KantahKabBanjar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Iconic Bootstrap 4.5.0 Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">

    <link rel="icon" type="image/png" href="{{ asset('img') }}/Logo_BPN-KemenATR.png" />
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/font-awesome/css/font-awesome.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/main.css">

</head>

<body data-theme="light" class="font-nunito">
    <!-- WRAPPER -->
    <div id="wrapper" class="theme-cyan">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top">
                        <img src="{{ asset('img') }}/Logo_BPN-KemenATR.png" alt="Iconic">
                    </div>
                    <div class="card">
                        <div class="header">
                            <p class="lead">Login dengan akun mu</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="username" class="control-label sr-only">Username</label>
                                    <input type="text" class="form-control" id="username"
                                        placeholder="Masukan Username" value="{{ old('username') }}" name="username"
                                        required>
                                    @error('username')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="password" required>
                                    @error('password')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>Remember me</span>
                                    </label>
                                </div> --}}
                                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                {{-- <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a
                                            href="page-forgot-password.html">Forgot password?</a></span>
                                    <span>Don't have an account? <a href="page-register.html">Register</a></span>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
</body>

</html>
