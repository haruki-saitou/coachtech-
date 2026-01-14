@extends('layouts.app')

@section('content')
    <h1 class="sr-only">商品一覧</h1>
    @if (session('status'))
        <div id="flash-message"
            class="max-w-[1400px] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-2 mx-auto text-center">
            {{ session('status') }}
        </div>
    @endif
    @if ($is_empty ?? false)
        <div class="alert alert-danger text-center pt-4 text-lg text-gray-700" id="flash-message">
            @if (!empty($keyword))
                {{ $keyword }}に一致する商品が見つかりませんでした。
            @endif
        </div>
    @endif
    <div class="flex border-b-2 border-gray-300 w-full mt-8">
        <div class="max-w-[1400px] px-40 flex gap-10 pb-2 pt-4">
            <a href="{{ route('product.index', array_merge(request()->query(), ['tab' => null])) }}"
                class="ml-12 text-lg font-bold cursor-pointer {{ request()->query('tab') !== 'mylist' ? 'text-red-500' : 'text-gray-500' }}">
                おすすめ
            </a>
            <a href="{{ route('product.index', array_merge(request()->query(), ['tab' => 'mylist'])) }}"
                class="ml-12 text-lg font-bold cursor-pointer {{ request()->query('tab') === 'mylist' ? 'text-red-500' : 'text-gray-500 hover:text-black transition' }}">
                マイリスト
            </a>
        </div>
    </div>
    <div class="max-w-[1400px] mx-auto text-center pt-12 text-lg text-gray-700">
        @if ($tab === 'mylist' && $is_empty ?? false)
            お気に入りに登録した商品はまだありません。
        @endif
    </div>
    <div id="product-list"class="max-w-[1400px] mx-auto px-8 py-4">
        <div class="grid grid-cols-4 gap-x-8 gap-y-8">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product->id) }}"
                    class="flex flex-col items-start group transition-all duration-300 hover:shadow-lg p-2 rounded">
                    <div
                        class="relative w-full aspect-square bg-gray-200 animate-pulse rounded mb-3 overflow-hidden flex items-center justify-center">
                        <span class="text-gray-600 text-xl font-bold">商品画像</span>
                        @if ($product->image_path)
                            <img src="{{ str_starts_with($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}"
                                alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover"
                                onload="this.parentElement.classList.remove('animate-pulse')">
                        @endif
                        @if ($product->is_sold)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span
                                    class="text-white text-5xl font-black tracking-widest uppercase transform rotate-[-45deg]">
                                    Sold
                                </span>
                            </div>
                        @endif
                    </div>
                    <p class="text-base font-medium text-gray-800 text-left transition">
                        {{ $product->name }}</p>
                </a>
            @endforeach
        </div>
        <div id="pagination-wrapper" class="hidden">{{ $products->links() }}</div>
    </div>
    <div id="loading-spinner" class="text-center py-10 hidden">
        <div class="inline-block animate-spin h-8 w-8 border-4 border-gray-900 rounded-full border-t-transparent"></div>
        <p class="text-lg text-gray-700">Loading...</p>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('scroll', function() {
            const wrapper = document.getElementById('pagination-wrapper');
            if (!wrapper) return;
            const nextNavLink = wrapper.querySelector('a[rel="next"]');
            if (!nextNavLink) return;
            const scrollHeight = document.documentElement.scrollHeight;
            const scrollPosition = window.innerHeight + window.pageYOffset;
            if ((scrollHeight - scrollPosition) / scrollHeight < 0.05) {
                loadMoreProducts(nextNavLink.href);
            }
        });

        let isFetching = false;

        function loadMoreProducts(url) {
            if (isFetching) return;
            isFetching = true;
            document.getElementById('loading-spinner').classList.remove('hidden');
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProducts = doc.querySelectorAll('#product-list .grid > a');
                    const grid = document.querySelector('#product-list .grid');
                    newProducts.forEach(item => grid.appendChild(item));
                    const newPagination = doc.getElementById('pagination-wrapper');
                    if (newPagination && newPagination.innerHTML.trim() !== "") {
                        document.getElementById('pagination-wrapper').innerHTML = newPagination.innerHTML;
                    }else{
                        document.getElementById('pagination-wrapper').remove();
                    }
                    isFetching = false;
                    document.getElementById('loading-spinner').classList.add('hidden');
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
