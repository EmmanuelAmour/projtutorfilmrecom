@extends('layouts.default')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12">
    <div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-amber-400 mb-6 text-center">Créer un compte</h2>

        @if ($errors->any())
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-300">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-300">Date de naissance</label>
                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Mot de passe</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
                <p class="text-xs text-gray-400 mt-1">Minimum 8 caractères</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
                <div id="password-match-message" class="text-xs mt-1 hidden"></div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                    Déjà un compte ? Se connecter
                </a>
            </div>

            <button type="submit" id="submitBtn"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium
                text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-amber-400 disabled:opacity-50 disabled:cursor-not-allowed">
                Créer le compte
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const message = document.getElementById('password-match-message');
    const submitBtn = document.getElementById('submitBtn');

    function checkPasswordMatch() {
        if (passwordConfirmation.value === '') {
            message.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        if (password.value === passwordConfirmation.value) {
            message.textContent = '✓ Les mots de passe correspondent';
            message.className = 'text-xs mt-1 text-green-400';
            submitBtn.disabled = false;
        } else {
            message.textContent = '✗ Les mots de passe ne correspondent pas';
            message.className = 'text-xs mt-1 text-red-400';
            submitBtn.disabled = true;
        }
    }

    password.addEventListener('input', checkPasswordMatch);
    passwordConfirmation.addEventListener('input', checkPasswordMatch);
});
</script>
@endsection