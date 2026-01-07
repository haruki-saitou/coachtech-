@extends('layouts.app')

@section('content')
    <div class="flex py-10 max-w-[1400px] mx-auto px-4">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto p-6">
            @csrf
            <h2 class="text-3xl font-bold mb-12 text-center">商品の出品</h2>

            <!-- 商品画像 -->
            <div class="mb-12">
                <label class="block font-bold mb-2 text-xl">商品画像</label>
                <div
                    class="relative w-full h-42 border-2 border-dashed border-gray-300 rounded flex item-center justify-center overflow-hidden">
                    <img id="product-preview" class="hidden absolute inset-0 w-full h-full object-cover z-10 cursor-pointer"
                        onclick="document.getElementById('image_path').click()">
                    <div id="upload-prompt" class="flex flex-col items-center justify-center w-full h-full">
                        <label for="image_path"
                            class="w-[180px] m-auto cursor-pointer border-2 border-red-500 text-red-500 py-2 rounded-lg font-bold hover:bg-red-50 transition text-center">画像を選択する
                        </label>
                        <input type="file" name="image_path" id="product-image_path" class="hidden" accept="image/*">
                    </div>
                </div>
                @error('image_path')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-12">
                <h3 class="text-2xl text-gray-500 font-bold border-b-[1.5px] border-gray-500 mb-8 pb-2">商品の詳細</h3>
                <div class="mb-10">
                    <label class="block text-xl font-bold mb-6">カテゴリー</label>
                    <div class="flex flex-wrap gap-x-4 gap-y-6">
                        @foreach ($categories as $category)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="hidden peer">
                                <span
                                    class="inline-block px-3 py-1 border-2 border-red-400 rounded-full text-sm text-red-400 transition peer-checked:bg-red-400 peer-checked:text-white">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="text-red-500 text-sm mt-4">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-12">
                    <label class="block text-xl font-bold mb-4">商品の状態</label>
                    <div class="relative">
                        <select name="condition_id" id="condition_id"
                            class="w-full border-[1.5px] border-gray-400 p-3 rounded text-gray-500 text-sm font-bold appearance-none cursor-pointer focus:outline-none focus:border-gray-400">
                            <option value="" disabled selected hidden>
                                選択してください
                            </option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <span class="text-lg">▼</span>
                        </div>
                    </div>
                    @error('condition_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 商品名 -->
            <div class="mb-12">
                <h3 class="text-3xl text-gray-500 font-bold border-b-[1.5px] border-gray-400 mb-8 pb-2">商品名と説明</h3>
                <div class="mb-8">
                    <label for="name" class="block text-xl font-bold mb-1">商品名</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border-[1.5px] border-gray-400 p-2 rounded focus:outline-none focus:border-gray-700">
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-8">
                    <label for="name" class="block text-xl font-bold mb-1">ブランド名</label>
                    <input type="text" name="brand_name" id="brand_name" value="{{ old('brand_name') }}"
                        class="w-full border-[1.5px] border-gray-400 p-2 rounded focus:outline-none focus:border-gray-700">
                    @error('brand_name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-8">
                    <label for="description" class="block text-xl font-bold mb-1">商品の説明</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700 resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-18">
                    <label for="price" class="block text-xl font-bold mb-1">販売価格</label>
                    <div class="relative">
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            class="w-full border-[1.5px] border-gray-400 py-2 pr-2 pl-6 rounded focus:outline-none focus:border-gray-700 appearance-none"
                            style="-moz-appearance: textfield;">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                            <span class="font-bold text-md transform scale-y-[1.3] inline-block">¥</span>
                        </div>
                    </div>
                    @error('price')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="w-full bg-red-400 text-white text-xl font-bold py-3 rounded mt-6 hover:bg-red-600 transition duration-200">
                出品する
            </button>
        </form>
    </div>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
    </style>
@endsection
@section('js')
    <script>
        const imageInput = document.getElementById('product-image_path');
        const previewImage = document.getElementById('product-preview');
        const fileNameDisplay = document.getElementById('file-name');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    document.getElementById('upload-prompt').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
