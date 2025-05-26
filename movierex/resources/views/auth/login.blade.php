@extends('layouts.default')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900">
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

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 text-amber-400 focus:ring-amber-400 border-gray-600 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">Se souvenir de moi</label>
                </div>
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium
                text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-amber-400">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection
