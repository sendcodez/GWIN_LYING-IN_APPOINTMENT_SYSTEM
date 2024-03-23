@extends ('layouts.register')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    @section('name')
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus
            autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    @endsection

    <!-- Email Address -->
    @section('email')
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
            autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    @endsection

    <!-- Password -->
    @section('password')
    <x-input-label for="password" :value="__('Password')" />

    <x-text-input id="password" class="form-control" type="password" name="password" required
        autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
    @endsection

    <!-- Confirm Password -->
    @section('confirm_password')
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required
        autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    @endsection

    @section('signin')
    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
    </a>
    @endsection 

    @section ('register')
    <x-primary-button class="btn btn-primary btn-block">
        {{ __('Register') }}
    </x-primary-button>
    @endsection
</form>
