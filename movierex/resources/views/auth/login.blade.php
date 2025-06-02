@extends('layouts.first')

@section('content')
    <div class="min-h-screen flex items-center justify-center" style="background-color: rgb(17, 24, 39);">
        <div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-md">
            <h2 class="text-2xl font-bold text-amber-400 mb-6 text-center">Connexion</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Mot de passe</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white
                    focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox">
                        <span class="ml-2 text-sm">Rester connecté</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié?
                        </a>
                    @endif

                    <a class="text-sm text-blue-600 hover:underline ml-4" href="{{ route('register') }}">
                        Créer un compte
                    </a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium
                text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-amber-400">
                    Se connecter
                </button>
            </form>

            @if ($errors->any())
                <div class="mt-4 bg-red-600 text-white p-3 rounded">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
