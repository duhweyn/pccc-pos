<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PETRON CCC - BIÑAN</title>
    <link rel="stylesheet" href="{{ asset( 'petron/css/style.css' ) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montenegrin+Gothic+One&display=swap" rel="stylesheet">
</head>
<body>

    <div class="auth">
        <div class="hero-top">
            <div class="logo-wrap">
                <img src="{{ asset( 'petron/img/logo1.webp' ) }}" alt="Petron CCC logo">
            </div>
        </div>

        <form class="login" id="login" method="POST" action="{{ ns()->route( 'ns.login.post' ) }}">
            @csrf
            <h1>Welcome back</h1>

            @if ( session( 'status' ) === 'success' )
                <p style="color:#3ddc84; text-align:center; font-size:13px; margin:0;">{{ session( 'message' ) }}</p>
            @endif

            <input type="text" name="username" placeholder="Username" value="{{ old( 'username' ) }}" required>
            @error( 'username' )
                <p style="color:#E4002B; font-size:12.5px; margin:-8px 0 0;">{{ $message }}</p>
            @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error( 'password' )
                <p style="color:#E4002B; font-size:12.5px; margin:-8px 0 0;">{{ $message }}</p>
            @enderror

            <a href="{{ ns()->route( 'ns.password-lost' ) }}" class="forgot">Forgot password</a>

            <button type="submit">Login</button>

            <a href="{{ ns()->route( 'ns.register' ) }}">Don't have an account?</a>

            <label class="remember">
                <span class="switch">
                    <input type="checkbox" id="remember">
                    <span class="slider"></span>
                </span>
                remember me
            </label>
        </form>
    </div>

</body>
</html>
