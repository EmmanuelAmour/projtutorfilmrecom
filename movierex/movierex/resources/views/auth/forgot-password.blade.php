@extends('layouts.default')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background-color: rgb(17, 24, 39);">
    <div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-amber-400 mb-6 text-center">Mot de passe oublié</h2>
        
        <p class="text-gray-300 text-sm mb-6 text-center">
            Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        @if (session('status'))
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium
                text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-amber-400">
                Envoyer le lien de réinitialisation
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