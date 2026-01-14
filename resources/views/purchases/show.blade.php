@extends('layouts.app')

@section('content')
    @session('status')
        <div id="flash-message"
            class="max-w-[1400px] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-2 mx-auto text-center">
            {{ session('status') }}
        </div>
    @endsession
    <div class="flex flex-col md:flex-row items-center justify-center max-w-[1400px] mx-auto px-4 py-20">
        <form method="POST" action="{{ route('purchase.checkout', ['item_id' => $product->id]) }}"
            class="flex w-full justify-between items-center flex-col md:flex-row gap-12 px-4 md:items-start" novalidate>
            @csrf
            {{-- 左側 --}}
            <div class="w-full md:flex-1 px-6">
                <div class="flex border-b-[1.5px] border-gray-400 gap-14 pb-12 mb-20]">
                    <div class="w-50 h-50 bg-gray-300 flex-shrink-0 flex items-center justify-center relative rounded-sm">
                        @if ($product->image_path)
                            <img src="{{ str_starts_with($product->image_path, 'http') ? $product->image_path : asset('storage/' . $product->image_path) }}"
                                alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <div class="mb-4">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        </div>
                        <div class="mb-4">
                            <span class="text-3xl text-gray-900">¥ {{ number_format($product->price) }}</span>
                        </div>
                    </div>
                </div>
                <div class="pt-6 pb-10 mb-8 border-b-[1.5px] border-gray-400">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 pl-10">支払い方法</h2>
                    <div class="relative w-[280px] ml-10">
                        <select name="payment_method" id="payment_method_select"
                            class="w-full md:w-[280px] border-[1.5px] border-gray-400 font-bold text-gray-500 text-md p-2 rounded bg-white appearance-none cursor-pointer focus:outline-none ">
                            <option value="" {{ session('payment_method') == '' ? 'selected' : '' }} disabled hidden>
                                選択してください</option>
                            <option value="konbini" {{ session('payment_method') == 'konbini' ? 'selected' : '' }}>コンビニ払い
                            </option>
                            <option value="card" {{ session('payment_method') == 'card' ? 'selected' : '' }}>カード支払い
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <span class="text-md">▼</span>
                        </div>
                    </div>
                    <div class="inline-block mx-12">
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="border-b-[1.5px] border-gray-400 pb-14">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold pl-10 text-gray-900">配送先</h2>
                        <a href="#"
                            onclick="location.href='{{ route('purchase.edit', ['item_id' => $product->id]) }}?payment_method=' + document.getElementById('payment_method_select').value; return false;"
                            class="text-blue-500 hover:text-blue-700 hover:underline pr-10">変更する</a>
                    </div>
                    <div class="pl-26 font-bold">
                        <p class="text-lg mb-2 text-gray-900">
                            <span class="text-sm transform scale-y-[1.3] inline-block">〒</span> {{ $user->post_code }}
                        </p>
                        <p class="text-lg text-gray-900">
                            {{ $user->address }} {{ $user->building }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- 右側：詳細情報エリア --}}
            <div class="w-full md:w-[450px] flex flex-col mx-2 gap-8 gap-y-16 px-4 pt-10]">
                <div class="border-[1.5px] border-gray-500 rounded-sm">
                    <table class="w-full text-center">
                        <tr class="border-b-[1.5px] border-gray-500">
                            <th class="py-10 px-8 font-normal text-lg">商品代金</th>
                            <td class="py-10 px-8 font-normal text-2xl text-gray-900">¥
                                {{ number_format($product->price) }}</td>
                        </tr>
                        <tr>
                            <th class="py-10 px-8 font-normal text-lg">支払い方法</th>
                            <td id="display_payment_method" class="py-10 px-8 font-normal text-xl text-gray-900"></td>
                        </tr>
                    </table>
                </div>
                <button type="submit"
                    class="w-full text-white bg-red-400 font-bold py-3 rounded text-xl hover:bg-red-600 transition">
                    購入する
                </button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        const methodSelect = document.getElementById('payment_method_select');
        const displayMethod = document.getElementById('display_payment_method');

        function updateDisplay() {
            const selectedText = methodSelect.options[methodSelect.selectedIndex].text;
            displayMethod.textContent = methodSelect.value ? selectedText : '';
        }

        methodSelect.addEventListener('change', updateDisplay);
        window.addEventListener('load', updateDisplay);
    </script>
@endsection
