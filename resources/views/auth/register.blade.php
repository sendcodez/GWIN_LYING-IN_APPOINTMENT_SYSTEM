@extends ('layouts.register')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/toastr.min.css') }}" />
<style>
    .input-valid {
        border-color: green;
    }

    .input-invalid {
        border-color: red;
    }

    .toast {
        background-color: #333 !important;
        color: #fff !important;
    }

    .toast-success {
        background-color: #28a745 !important;
        /* Green for success */
    }

    .toast-error {
        background-color: #dc3545 !important;
        /* Red for error */
    }
</style>
<form method="POST" action="{{ route('register') }}">
    @csrf

    @section('firstname')
        <x-input-label for="firstname" :value="__('First Name')" />
        <x-text-input id="firstname" class="form-control" type="text" name="firstname" :value="old('firstname')" required autofocus
            autocomplete="firstname" pattern="[A-Za-z\s]+" title="Only letters are allowed." />
        <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        <div id="firstname-error" class="text-danger mt-1"></div> <!-- Error message div -->
    @endsection

    @section('middlename')
        <x-input-label for="middlename" :value="__('Middle Name')" />
        <x-text-input id="middlename" class="form-control" type="text" name="middlename" :value="old('middlename')"
            autocomplete="middlename" pattern="[A-Za-z\s]*" title="Only letters are allowed." />
        <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
        <div id="middlename-error" class="text-danger mt-1"></div> <!-- Error message div -->
    @endsection

    @section('lastname')
        <x-input-label for="lastname" :value="__('Last Name')" />
        <x-text-input id="lastname" class="form-control" type="text" name="lastname" :value="old('lastname')" required
            autofocus autocomplete="lastname" pattern="[A-Za-z\s]+" title="Only letters are allowed." />
        <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        <div id="lastname-error" class="text-danger mt-1"></div> <!-- Error message div -->
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
        <span id="password-match-status"></span>
    @endsection

    @section('terms')
        <div class="form-group">
            <input type="checkbox" id="termsCheckbox" onclick="toggleSubmitButton()">
            I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a>
        </div>
    @endsection
    @section('signin')
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
    @endsection

    @section('register')
        <x-primary-button class="btn btn-primary btn-block" id="submitButton" disabled>
            {{ __('Register') }}
        </x-primary-button>
    @endsection
</form>

<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <h4>1. Introduction</h4>
                <p>Welcome to Gwin Lying-in. These Terms and Conditions govern your use of our website and services. By
                    accessing or using our website, you agree to comply with and be bound by these Terms. If you do not
                    agree with these Terms, please do not use our website or services.</p><br>

                <h4>2. Use of the Website</h4>

                <li>You agree to use the website only for lawful purposes and in a way that does not infringe the rights
                    of others or restrict their use and enjoyment of the website.</li><br>
                <li>You are responsible for maintaining the confidentiality of your account and password and for all
                    activities that occur under your account.</li><br>


                <h4>3. Intellectual Property</h4>

                <li>All content on the Gwin Lying-in website, including text, graphics, logos, images, and software, is
                    the property of Gwin Lying-in and is protected by copyright, trademark, and other intellectual
                    property laws.</li><br>
                <li>You may not reproduce, distribute, modify, or create derivative works of any content on our website
                    without our express written permission.</li><br>


                <h4>4. User Content</h4>
                <p>You retain ownership of any content you submit to the website, but you grant Gwin Lying-in a
                    non-exclusive, royalty-free, worldwide license to use, display, reproduce, and distribute such
                    content. You agree that any content you submit does not violate any third-party rights and is not
                    unlawful, offensive, or otherwise objectionable.</p><br>

                <h4>5. Privacy</h4>
                <p>Your privacy is important to us. Please review our Privacy Policy, which explains how we collect,
                    use, and protect your personal information.</p><br>

                <h4>6. Limitation of Liability</h4>

                <li>Gwin Lying-in is not liable for any direct, indirect, incidental, consequential, or punitive damages
                    arising from your use of the website or services.</li><br>
                <li>We do not guarantee that the website will be available at all times or that it will be free from
                    errors, viruses, or other harmful components.</li><br>


                <h4>7. Changes to the Terms</h4>
                <p>Gwin Lying-in reserves the right to modify these Terms at any time. We will notify you of any changes
                    by posting the new Terms on our website. Your continued use of the website after such changes
                    constitutes your acceptance of the new Terms.</p><br>

                <h4>8. Governing Law</h4>
                <p>These Terms are governed by and construed in accordance with the laws of the jurisdiction in which
                    Gwin Lying-in operates. Any disputes arising out of or relating to these Terms will be resolved in
                    the courts of that jurisdiction.</p><br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="{{ asset('vendors/scripts/toastr.min.js') }}"></script>
@if (session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error('{{ session('error') }}');
    </script>
@endif
<script>
    function validateNameInput(event) {
        const regex = /^[A-Za-z\s]+$/; // Regular expression for letters and spaces only
        const input = event.target.value;
        const errorField = document.getElementById(`${event.target.id}-error`);

        if (!regex.test(input)) {
            errorField.textContent = "Only letters are allowed."; // Display error message
        } else {
            errorField.textContent = ''; // Clear error message if valid
        }
    }

    // Add event listeners to the fields
    document.getElementById('firstname').addEventListener('input', validateNameInput);
    document.getElementById('middlename').addEventListener('input', validateNameInput);
    document.getElementById('lastname').addEventListener('input', validateNameInput);
    


    document.addEventListener('DOMContentLoaded', function() {
        var password = document.getElementById('password');
        var passwordConfirmation = document.getElementById('password_confirmation');
        var passwordMatchStatus = document.getElementById('password-match-status');

        function checkPasswordMatch() {
            if (password.value === passwordConfirmation.value) {
                passwordConfirmation.classList.add('input-valid');
                passwordConfirmation.classList.remove('input-invalid');
                passwordMatchStatus.textContent = 'Passwords match';
                passwordMatchStatus.style.color = 'green';
            } else {
                passwordConfirmation.classList.add('input-invalid');
                passwordConfirmation.classList.remove('input-valid');
                passwordMatchStatus.textContent = 'Passwords do not match';
                passwordMatchStatus.style.color = 'red';
            }
        }

        password.addEventListener('input', checkPasswordMatch);
        passwordConfirmation.addEventListener('input', checkPasswordMatch);
    });

    function toggleSubmitButton() {
        var checkbox = document.getElementById('termsCheckbox');
        var submitButton = document.getElementById('submitButton');
        submitButton.disabled = !checkbox.checked;
    }

    function openTermsModal() {
        var modal = document.getElementById('termsModal');
        modal.style.display = 'block';
    }

    function closeTermsModal() {
        var modal = document.getElementById('termsModal');
        modal.style.display = 'none';
    }
</script>
