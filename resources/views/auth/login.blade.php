@extends('layouts.login')


<!-- Session Status -->

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    @section('email')
        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus
            autocomplete="username" />
    @endsection

    <!-- Password -->

    @section('password')
        <x-text-input id="password" class="form-control" type="password" name="password" required
            autocomplete="current-password" />
    @endsection




    @section('forgot')
        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    @endsection

    @section('button')
        <x-primary-button class="btn btn-primary btn-block">
            {{ __('Log in') }}
        </x-primary-button>
    @endsection
</form>
