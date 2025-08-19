<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-green-400 via-emerald-500 to-teal-500 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md text-center">
        <img src="{{ asset('images/ic_logo.png') }}" style="width: 120px; height: 100px;" class="mx-auto mb-4" alt="Logo">    
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Login to Your Account</h2>


        @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required
                   class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400">
            <button type="submit"
                    class="w-full bg-emerald-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-emerald-600 transition">
                Login
            </button>
        </form>
        @if ($errors->any())
            <div>{{ $errors->first() }}</div>
        @endif
    </div>
</body>
</html>
