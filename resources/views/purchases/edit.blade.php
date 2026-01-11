@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center py-10 px-4">
        <h1 class="text-3xl font-bold mb-20">住所変更</h1>
        <form method="POST" action="{{ route('purchase.update', ['item_id' => $item_id]) }}" class="w-full max-w-[600px]"
            novalidate>
            @csrf
            @method('PATCH')
            <input type="hidden" name="item_id" value="{{ $item_id }}">
            {{-- 郵便番号 --}}
            <div class="mb-2">
                <label for="post_code" class="block text-lg font-bold mb-2 text-left w-full">郵便番号</label>
                <input type="text" name="post_code" id="post_code"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('post_code', $user->post_code) }}">
                <div class="inline-block">
                    @error('post_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            {{-- 住所 --}}
            <div class="mb-2">
                <label for="address" class="block text-lg font-bold mb-2 text-left w-full">住所</label>
                <input type="text" name="address" id="address"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('address', $user->address) }}">
                <div class="inline-block">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            {{-- 建物名 --}}
            <div class="mb-6">
                <label for="building" class="block text-lg font-bold mb-2 text-left w-full">建物名</label>
                <input type="text" name="building" id="building"
                    class="w-full border-[1.5px] border-gray-400 p-3 rounded focus:outline-none focus:border-gray-700"
                    value="{{ old('building', $user->building) }}">
                <div class="inline-block">
                    @error('building')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="w-full bg-red-400 text-white text-lg font-bold py-3 rounded mt-6 hover:bg-red-600 transition duration-200">
                更新する
            </button>
        </form>
    </div>
@endsection
