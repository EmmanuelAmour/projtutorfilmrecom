@extends('layouts.first')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: rgb(17, 24, 39);">
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
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium
                text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-amber-400">
                Créer le compte
            </button>
        </form>

        <div class="mt-6 text-center">
            <a class="text-sm text-blue-400 hover:underline" href="{{ route('login') }}">
                Déjà un compte ? Se connecter
            </a>
        </div>
    </div>
</div>
@endsection
