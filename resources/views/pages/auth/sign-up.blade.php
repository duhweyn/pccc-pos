<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PETRON CCC - BIÑAN</title>
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

        <form class="signup" id="signup" method="POST" action="{{ ns()->route( 'ns.register.post' ) }}">
            @csrf
            <h1>Create account</h1>

            <input type="text" name="username" placeholder="Username" value="{{ old( 'username' ) }}" required>
            @error( 'username' )
                <p style="color:#E4002B; font-size:12.5px; margin:-8px 0 0;">{{ $message }}</p>
            @enderror

            <input type="email" name="email" placeholder="Email" value="{{ old( 'email' ) }}" required>
            @error( 'email' )
                <p style="color:#E4002B; font-size:12.5px; margin:-8px 0 0;">{{ $message }}</p>
            @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error( 'password' )
                <p style="color:#E4002B; font-size:12.5px; margin:-8px 0 0;">{{ $message }}</p>
            @enderror

            <input type="password" name="password_confirm" placeholder="Confirm Password" required>
            @error( 'password_confirm' )
                <p style="color:#E4002B; font-size:12.5px; margin:-8px 0 0;">{{ $message }}</p>
            @enderror

            <button type="submit">Sign Up</button>

            <a href="{{ ns()->route( 'ns.login' ) }}">Already have an account?</a>
        </form>
    </div>

</body>
</html>
