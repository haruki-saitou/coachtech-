@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-around my-10 max-w-7xl mx-auto px-4">
        {{-- プロフィール画像アップロードエリア --}}
        <div class="flex items-center space-x-10">
            <div class="w-30 h-30 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                {{-- 登録済み画像があれば表示、なければグレーの円 --}}
                @if ($user->image_path)
                    <img src="{{ asset('storage/' . $user->image_path) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-300"></div>
                @endif
            </div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
        </div>
        <div class="cursor-pointer ml-30">
            <a href="{{ route('profile.edit') }}"
                class="border-2 border-red-500 text-red-500 px-4 py-2 rounded-md font-bold hover:bg-red-50 transition">プロフィールを編集</a>
        </div>
    </div>


    <div class="border-b-2 border-gray-300 mt-8">
        <div class="max-w-7xl mx-auto px-4 flex gap-10 pb-2 pt-4">
            <a href="{{ route('profile.index', ['page' => 'sell']) }}"
                class="... {{ request()->query('page') !== 'buy' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500' }}">
                出品した商品
            </a>

            <a href="{{ route('profile.index', ['page' => 'buy']) }}"
                class="... {{ request()->query('page') === 'buy' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500' }}">
                購入した商品
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-4 gap-x-8 gap-y-12">
            @if ($is_empty)
                <p class="text-center text-lg text-gray-600">
                    @if (request()->query('page') === 'buy')
                        購入した商品はまだありません。
                    @else
                        出品した商品はまだありません。
                    @endif
                </p>
            @else
                @foreach ($products as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="flex flex-col items-start group">
                        <div
                            class="relative w-full aspect-square bg-gray-300 rounded-sm mb-3 overflow-hidden flex items-center justify-center">
                            <span class="text-gray-600 text-xl font-bold">商品画像</span>
                            @if ($product->image_path)
                                <img src="{{ str_starts_with($product->image_path, 'http') ? $product->image_path : asset($product->image_path) }}"
                                    alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                            @endif
                            @if ($product->is_sold)
                                <div class="absolute inset-0 bg-black/80 flex items-center justify-center">
                                    <span class="text-white text-4xl font-black tracking-widest uppercase">
                                        Sold
                                    </span>
                                </div>
                            @endif
                        </div>
                        <p class="text-base font-medium text-gray-800 text-left group-hover:text-red-500 transition">
                            {{ $product->name }}</p>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection
