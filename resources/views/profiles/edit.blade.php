@extends('layouts.app')

@section('content')
    <div class="max-w-[1400px] mx-auto flex flex-col items-center justify-center py-12 px-4">
        <h2 class="text-2xl font-bold mb-10 text-center">プロフィール設定</h2>
        {{-- enctype="multipart/form-data" を忘れずに追加します --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full max-w-[680px]"
            novalidate>
            @csrf
            @method('PATCH') {{-- 更新であることをパソコンに伝えます --}}

            <div class="flex items-center mb-14">
                {{-- プロフィール画像アップロードエリア --}}
                <div class="flex items-center space-x-8 cursor-pointer" onclick="document.getElementById('profile-image_path').click()">
                    <div class="w-30 h-30 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        {{-- 登録済み画像があれば表示、なければグレーの円 --}}
                        @if ($user->image_path)
                            <img id="profile-preview" src="{{ asset('storage/' . $user->image_path) }}"
                                class="w-full h-full object-cover">
                        @else
                            <img id="profile-preview" src="" class="hidden w-full h-full object-cover">
                            <div id="default-icon"class="w-full h-full bg-gray-300"></div>
                        @endif
                    </div>
                    <label class="cursor-pointer">
                        <span
                            class="border-[1.5px] border-red-400 text-red-400 px-4 py-2 rounded-md font-bold hover:bg-red-50 transition">画像を選択する</span>
                        <input type="file" name="image_path" id="profile-image_path" accept="image/*" class="hidden">
                    </label>
                </div>
                @error('image_path')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ユーザー名 --}}
            <div class="mb-6">
                <label for="name" class="block text-lg font-bold mb-2 text-left w-full">ユーザー名</label>
                {{-- valueには $user->name を入れて、最初から自分の名前が出るようにします --}}
                <input type="text" name="name" id="name"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 郵便番号 --}}
            <div class="mb-6">
                <label for="post_code" class="block text-lg font-bold mb-2 text-left w-full">郵便番号</label>
                <input type="text" name="post_code" id="post_code"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('post_code', $user->post_code) }}">
                @error('post_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 住所 --}}
            <div class="mb-6">
                <label for="address" class="block text-lg font-bold mb-2 text-left w-full">住所</label>
                <input type="text" name="address" id="address"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('address', $user->address) }}">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="mb-10">
                <label for="building" class="block text-lg font-bold mb-2 text-left w-full">建物名</label>
                <input type="text" name="building" id="building"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('building', $user->building) }}">
                @error('building')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-red-400 text-white text-lg font-bold py-3 rounded mt-6 hover:bg-red-600 transition duration-200">
                更新する
            </button>
        </form>
    </div>
@endsection
@section('js')
    <script>
        const imageInput = document.getElementById('profile-image_path');
        const previewImage = document.getElementById('profile-preview');
        const defaultIcon = document.getElementById('default-icon');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    if (defaultIcon) {
                        defaultIcon.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
