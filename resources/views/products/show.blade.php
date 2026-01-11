@extends('layouts.app')

@section('content')
    <div class="max-w-[1400px] mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row my-10 gap-10 md:gap-20 justify-center">

            {{-- 左側エリア --}}
            <div class="w-full md:w-1/2 max-w-[500px]">
                <div
                    class="relative w-full max-w-[500px] aspect-square bg-gray-300 rounded-sm mb-3 overflow-hidden flex items-center justify-center">
                    <span class="text-gray-600 text-xl font-bold">商品画像</span>
                    @if ($product->image_path)
                        <img src="{{ str_starts_with($product->image_path, 'http') ? $product->image_path : asset($product->image_path) }}"
                            alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                    @endif
                    @if ($product->is_sold)
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span class="text-white text-4xl font-black tracking-widest uppercase">
                                Sold
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            {{-- 右側エリア --}}
            <div class="w-full md:w-1/2 max-w-[500px]">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-md text-gray-500 mb-4">{{ $product->brand_name ?? 'ブランド名' }}</p>
                <div class="mb-4">
                    <span class="text-3xl text-gray-900">¥ {{ number_format($product->price) }}</span>
                    <span class="text-xl text-gray-700 ml-1">(税込)</span>
                </div>
                <div class="flex items-center gap-6 mb-6">
                    <div class="flex flex-col items-center">
                        <form action="{{ route('like.toggle', ['item_id' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="hover:opacity-80 transition">
                                @if (Auth::check() && $product->likes()->where('user_id', Auth::id())->exists())
                                    {{-- クリック後の画像 --}}
                                    <img src="{{ asset('images/like_on.png') }}" alt="いいね済み" class="w-8 h-8 mx-6">
                                @else
                                    {{-- クリック前の画像 --}}
                                    <img src="{{ asset('images/like_off.png') }}" alt="いいね" class="w-8 h-8 mx-6">
                                @endif
                            </button>
                        </form>
                        <span class="text-xs text-gray-600">{{ $product->likes()->count() }}</span>
                    </div>
                    {{-- コメント数：ログイン前でも表示 --}}
                    <div class="flex flex-col items-center">
                        <div class="text-gray-400">
                            <img src="{{ asset('images/comment.png') }}" alt="コメント" class="w-8 h-8 mb-1">
                        </div>
                        <span class="text-xs text-gray-600">{{ $product->comments()->count() }}</span>
                    </div>
                </div>
                {{-- 購入手続きボタン --}}
                <div class="mb-10">
                    @if ($product->is_sold)
                        <button disabled
                            class="block w-full text-center bg-gray-400 text-white font-bold py-3 rounded cursor-not-allowed">
                            売り切れました
                        </button>
                    @else
                        <a href="{{ route('purchase.show', ['item_id' => $product->id]) }}"
                            class="block w-full text-center bg-red-400 text-white font-bold py-3 rounded hover:bg-red-600 transition">
                            購入手続きへ
                        </a>
                    @endif
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
                        <div class="flex gap-3">
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
                        <span class="text-gray-700 px-3 pb-1 rounded-full">{{ $product->condition->name }}</span>
                    </div>
                </div>
                {{-- コメント一覧 --}}
                <div class="mb-10">
                    <h2 class="text-xl font-bold mb-6">コメント ({{ $product->comments->count() }})</h2>
                    {{-- コメント全件 --}}
                    @foreach ($product->comments as $comment)
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-4">
                                {{-- コメント者のアイコン --}}
                                <div class="w-14 h-14 bg-gray-200 rounded-full overflow-hidden">
                                    @if ($comment->user->image_path)
                                        <img src="{{ asset('storage/' . $comment->user->image_path) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300"></div>
                                    @endif
                                </div>
                                <span class="font-bold text-lg">{{ $comment->user->name }}</span>
                            </div>
                            {{-- コメントの本文 --}}
                            <div class="bg-gray-200 p-4 rounded text-sm">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- コメント投稿フォーム --}}
                <div>
                    <h3 class="font-bold mb-2 text-lg">商品へのコメント</h3>
                    <form action="{{ route('comment.store', ['item_id' => $product->id]) }}" method="POST">
                        @csrf
                        <div class="mb-8">
                            <textarea name="comment" rows="6"
                                class="w-full border-[1.5px] border-gray-400 rounded p-3 mb-2 focus:outline-none focus:border-gray-400"></textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full text-lg bg-red-400 text-white font-bold py-3 rounded hover:bg-red-600 transition">
                            コメントを送信する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
