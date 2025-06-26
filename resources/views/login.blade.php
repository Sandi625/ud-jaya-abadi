@extends('layout.app')

@section('title', 'Login')

@section('content')
    <div class="flex flex-col items-center justify-center">
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 max-w-md w-full">
            <h1 class="text-3xl font-bold mb-4 text-gray-800 text-center">Login</h1>

            <div class="flex justify-center">
                <img src="{{ asset('assets/img/logo.jpg') }}" width="200" height="200" alt="">
            </div>
            @if (session('status'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                        id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                        id="password" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Login
                    </button>
                    @if (Route::has('password.request'))
                        <a class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800"
                            href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account yet?
                    <a href="{{ route('register') }}" class="text-green-500 hover:underline">
                        Register here</a>
                </p>
            </div>

        </div>
    </div>

    {{-- @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror --}}

    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif --}}


@endsection
