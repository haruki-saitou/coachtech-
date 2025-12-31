@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center py-20 px-4">
        <h2 class="text-2xl font-bold mb-10">プロフィール設定</h2>
        @if (session('status'))
            <div class="w-full max-w-[680px] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif
        {{-- enctype="multipart/form-data" を忘れずに追加します --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full max-w-[680px]"
            novalidate>
            @csrf
            @method('PATCH') {{-- 更新であることをパソコンに伝えます --}}

            <div class="flex items-center mb-10">
                {{-- プロフィール画像アップロードエリア --}}
                <div class="flex items-center space-x-8">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        {{-- 登録済み画像があれば表示、なければグレーの円 --}}
                        @if ($user->image_path)
                            <img src="{{ asset('storage/' . $user->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-300"></div>
                        @endif
                    </div>
                    <label class="cursor-pointer">
                        <span
                            class="border-2 border-red-500 text-red-500 px-4 py-2 rounded-md font-bold hover:bg-red-50 transition">画像を選択する</span>
                        <input type="file" name="image_path" class="hidden"> {{-- nameをimage_pathに合わせます --}}
                    </label>
                </div>
                @error('image_path')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ユーザー名 --}}
            <div class="mb-6">
                <label for="name" class="block text-lg font-bold mb-2">ユーザー名</label>
                {{-- valueには $user->name を入れて、最初から自分の名前が出るようにします --}}
                <input type="text" name="name" id="name"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 郵便番号 --}}
            <div class="mb-6">
                <label for="post_code" class="block text-lg font-bold mb-2">郵便番号</label>
                <input type="text" name="post_code" id="post_code"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400"
                    value="{{ old('post_code', $user->post_code) }}">
                @error('post_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 住所 --}}
            <div class="mb-6">
                <label for="address" class="block text-lg font-bold mb-2">住所</label>
                <input type="text" name="address" id="address"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400"
                    value="{{ old('address', $user->address) }}">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="mb-10">
                <label for="building" class="block text-lg font-bold mb-2">建物名</label>
                <input type="text" name="building" id="building"
                    class="w-full border-2 border-gray-300 p-3 rounded-md focus:outline-none focus:border-red-400"
                    value="{{ old('building', $user->building) }}">
                @error('building')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-red-500 text-white text-lg font-bold py-3 rounded-md hover:bg-red-600 transition duration-200">
                更新する
            </button>
        </form>
    </div>
@endsection
