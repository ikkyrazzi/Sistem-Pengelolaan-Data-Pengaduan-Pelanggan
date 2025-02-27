<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | IndonesiaNet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo-inet.png') }}" type="image/x-icon">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('asset/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fonts/material.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style-preset.css') }}">
</head>

<body data-pc-theme="light">
    <!-- Pre-loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#"><img src="{{ asset('asset/images/logo1INET.png') }}" alt="Logo"
                                    style="width: 300px;"></a>
                        </div><br>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Remember Me</label>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('asset/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/script.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script>
        preset_change("preset-1");
    </script>
</body>

</html>
