@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row gap-12">

            {{-- 左側：画像エリア --}}
            <div class="w-full md:w-1/2">
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
            </div>

            {{-- 右側：詳細情報エリア --}}
            <div class="w-full md:w-1/2">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-sm text-gray-500 mb-4">{{ $product->brand_name ?? 'ブランド名' }}</p>

                <div class="mb-4">
                    <span class="text-2xl font-bold text-gray-900">¥{{ number_format($product->price) }}</span>
                    <span class="text-xs text-gray-500 ml-1">(税込)</span>
                </div>

                <div class="flex items-center gap-6 mb-6">
                    {{-- いいね：ログイン前でも表示 --}}
                    <div class="flex flex-col items-center">
                        <form action="{{ route('like.toggle', ['product_id' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="hover:opacity-80 transition">
                                @if (Auth::check() && $product->likes()->where('user_id', Auth::id())->exists())
                                    {{-- いいね済みの時：クリック後の画像 --}}
                                    <img src="{{ asset('images/like_on.png') }}" alt="いいね済み" class="w-6 h-6 mx-6">
                                @else
                                    {{-- 未いいねの時：クリック前の画像 --}}
                                    <img src="{{ asset('images/like_off.png') }}" alt="いいね" class="w-6 h-6 mx-6">
                                @endif
                            </button>
                        </form>
                        <span class="text-xs text-gray-600">{{ $product->likes()->count() }}</span>
                    </div>
                    {{-- コメント数：ログイン前でも表示 --}}
                    <div class="flex flex-col items-center">
                        <div class="text-gray-400">
                            {{-- ここに吹き出しのSVG --}}
                            <img src="{{ asset('images/comment.png') }}" alt="コメント" class="w-6 h-6 mb-1">
                        </div>
                        <span class="text-xs text-gray-600">{{ $product->comments()->count() }}</span>
                    </div>
                </div>

                {{-- 購入手続きボタン：ログイン前でも赤色で表示 --}}
                <div class="mb-10">
                    <a href="{{ route('purchase.show', ['purchase_id' => $product->id]) }}"
                        class="block w-full text-center bg-red-500 text-white font-bold py-3 rounded-md hover:bg-red-600 transition">
                        購入手続きへ
                    </a>
                </div>

                {{-- 商品説明 --}}
                <div class="mb-10">
                    <h2 class="text-xl font-bold mb-4">商品説明</h2>
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $product->description }}</p>
                </div>

                {{-- 商品の情報 --}}
                <div class="mb-10">
                    <h2 class="text-xl font-bold mb-4">商品の情報</h2>
                    <div class="flex items-center mb-4">
                        <span class="w-32 font-bold">カテゴリー</span>
                        <div class="flex gap-2">
                            @forelse ($product->categories as $category)
                                <span class="bg-gray-200 px-3 py-1 rounded-full text-xs text-gray-600">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400">カテゴリーなし</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="w-32 font-bold">商品の状態</span>
                        <span class="text-gray-700">{{ $product->condition->name }}</span>
                    </div>
                </div>

                {{-- コメント一覧 --}}
                <div class="mb-10">
                    <h2 class="text-xl font-bold mb-6">コメント ({{ $product->comments->count() }})</h2>
                    @foreach ($product->comments as $comment)
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                                <span class="font-bold text-sm">{{ $comment->user->name }}</span>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md text-sm">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- コメント投稿フォーム：ログイン前でも表示 --}}
                <div>
                    <h3 class="font-bold mb-2 text-sm">商品へのコメント</h3>
                    <form action="{{ route('comment.store', ['product_id' => $product->id]) }}" method="POST">
                        @csrf
                        <textarea name="comment" rows="6" class="w-full border border-gray-300 rounded-md p-3 mb-4"></textarea>
                        <button type="submit"
                            class="w-full bg-red-400 text-white font-bold py-3 rounded-md hover:bg-red-500 transition">
                            コメントを送信する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
