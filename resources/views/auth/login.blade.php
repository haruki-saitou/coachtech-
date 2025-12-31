@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center py-20 px-4">
        <h2 class="text-2xl font-bold mb-10">ログイン</h2>
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-[680px]" novalidate>
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-lg font-bold mb-2">メールアドレス</label>
                <input type="email" name="email" id="email"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400"
                    value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-10">
                <label for="password" class="block text-lg font-bold mb-2">パスワード</label>
                <input type="password" name="password" id="password"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-red-500 text-lg text-white font-bold mt-6 py-3 rounded-md hover:bg-red-600 transition duration-200">
                ログインする
            </button>
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-blue-500">会員登録はこちら</a>
            </div>
        </form>
    </div>
@endsection
