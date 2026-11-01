<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet"href="views\style.css"> --}}
    <link rel="stylesheet" href="{{ asset('website/css/style1.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <h2> Sign in/up Form</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container">
        @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        {{-- <label for="photo">Photo:</label> --}}
        <input type="file" name="photo" id="photo" required><br>

        {{-- <label for="username">Username:</label> --}}
        <input type="text" name="username" id="username" placeholder="Username" required><br>

        {{-- <label for="email">Email:</label> --}}
        <input type="email" name="email" id="email" placeholder="Email" required><br>

        {{-- <label for="password">Password:</label> --}}
        <input type="password" name="password" id="password" placeholder="Password" required><br>

        {{-- <label for="password_confirmation">Confirm Password:</label> --}}
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required><br>

        <button type="submit">Sign Up</button>
    </form>
    </div>
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
                <p style="color: red;">{{ $errors->first() }}</p>
            @endif
            <h1>Sign in</h1>
            {{-- <label for="email">Email:</label> --}}
    <input type="email" name="email" id="email" placeholder="Email" required><br>

    {{-- <label for="password">Password:</label> --}}
    <input type="password" name="password" id="password" placeholder="Password" required><br>
            <button type="submit">Sign In</button>
        </form>
    </div>
    
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<footer>
	 
</footer>

<script>
   
       const signUpButton = document.getElementById('signUp');
      const signInButton = document.getElementById('signIn');
      const container = document.getElementById('container');

             signUpButton.addEventListener('click', () => {
           container.classList.add('right-panel-active');
      });

signInButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});
    </script>
    
</body>
</html>