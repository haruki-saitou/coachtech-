@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center py-20 px-4">
        <h2 class="text-2xl font-bold mb-10">会員登録</h2>
        <form method="POST" action="{{ route('register') }}" class="w-full max-w-[680px]" novalidate>
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-lg font-bold mb-2">ユーザー名</label>
                <input type="text" name="name" id="name"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400"
                    value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
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
            <div class="mb-10">
                <label for="password_confirmation" class="block text-lg font-bold mb-2">パスワード確認</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border-2 border-gray-300 mb-6 p-3 rounded-md focus:outline-none focus:border-red-400" required>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-red-500 text-white text-lg font-bold mt-10 py-3 rounded-md hover:bg-red-600 transition duration-200">
                登録する
            </button>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-blue-500">ログインはこちら</a>
            </div>
        </form>
    </div>
@endsection
