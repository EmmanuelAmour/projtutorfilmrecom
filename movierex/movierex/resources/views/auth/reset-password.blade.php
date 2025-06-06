@extends('first.default')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background-color: rgb(17, 24, 39);">
    <div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-amber-400 mb-6 text-center">Réinitialiser le mot de passe</h2>

        @if ($errors->any())
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="email_display" class="block text-sm font-medium text-gray-300">Email</label>
                <input type="email" id="email_display" value="{{ $email }}" disabled
                    class="mt-1 block w-full px-3 py-2 bg-gray-600 border border-gray-600 rounded-md text-gray-300">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Nouveau mot de passe</label>
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
                Réinitialiser le mot de passe
            </button>
        </form>

        <div class="mt-6 text-center">
            <a class="text-sm text-blue-400 hover:underline" href="{{ route('login') }}">
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
