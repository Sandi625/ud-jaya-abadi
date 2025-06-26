@extends('layout.app')

@section('title', 'Register')

@section('content')
    <div class="flex flex-col items-center justify-center">
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 max-w-md w-full">
            <h1 class="text-3xl font-bold mb-4 text-gray-800 text-center">Register</h1>

            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/img/logo.jpg') }}" width="200" height="200" alt="Logo">
            </div>

            @if (session('status'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input id="password" type="password" name="password" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Retype
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                {{-- reCAPTCHA Section --}}
                {{-- <div class="mb-4">
                    {!! htmlFormSnippet() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <p class="text-red-500 text-xs italic mt-2">
                            {{ $errors->first('g-recaptcha-response') }}
                        </p>
                    @endif
                </div> --}}


                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Register
                    </button>
                    <a href="{{ route('login') }}"
                        class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800">
                        Already have an account?
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
