@extends('layouts.app')

@section('content')
    @error ('success')
        <div class="alert alert-success" id="flash-success-message">
            {{ session('success') }}
        </div>
    @enderror
    @if ($is_empty ?? false)
        <div class="alert alert-danger" id="flash-error-message">
            「{{ $keyword }}」に一致する商品が見つかりませんでした。
        </div>
    @endif
    <div class="border-b-2 border-gray-300 mt-8">
        <div class="max-w-7xl mx-auto px-4 flex gap-10 pb-2 pt-4">
            <a href="{{ route('product.index', ['keyword' => $keyword ?? '']) }}"
                class="ml-12 text-lg font-bold cursor-pointer {{ request()->query('tab') !== 'mylist' ? 'text-red-500' : 'text-gray-500' }}">
                おすすめ
            </a>

            <a href="{{ route('product.index', ['tab' => 'mylist', 'keyword' => $keyword ?? '']) }}"
                class="ml-12 text-lg font-bold cursor-pointer {{ request()->query('tab') === 'mylist' ? 'text-red-500' : 'text-gray-500 hover:text-black transition' }}">
                マイリスト
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-4 gap-x-8 gap-y-12">
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
        </div>
    </div>
@endsection
