<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COACHTECH-FRIMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="bg-black text-white p-4 py-3 flex flex-col md:flex-row items-center gap-4">
        <div class="flex-shrink-0">
            <a href="{{ route('product.index') }}">
                <img src="{{ asset('images/COACHTECH.png') }}" alt="COACHTECH" class="h-6 md:h-8 ml-2">
            </a>
        </div>
        @if (!Route::is('login') && !Route::is('register') && !Route::is('verification.notice'))
            <div class="flex-1 w-full md:max-w-xl lg:max-w-2xl mx-auto">
                <form action="{{ route('product.index') }}" method="GET" class="relative">
                    <input type="text" name="keyword"
                        class="bg-white text-black px-6 py-2 rounded-sm text-base focus:outline-none w-full"
                        placeholder="なにをお探しですか？">
                </form>
            </div>
            <nav class="flex items-center gap-4 text-sm md:text-base">
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="hover:text-gray-300">ログアウト</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-gray-300">ログイン</a>
                @endauth
                <a href="{{ route('profile.index') }}" class="hover:text-gray-300 ml-6">マイページ</a>
                <a href="{{ route('product.create') }}" class="bg-white text-black mx-6 px-4 py-1 rounded-sm">出品</a>
            </nav>
        @endif
    </header>

    <main class="max-w-[1400px] mx-auto">
        @yield('content')
    </main>

</body>

</html>
