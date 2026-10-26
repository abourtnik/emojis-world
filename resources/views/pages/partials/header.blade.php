<header class="h-16 bg-white flex items-center justify-between p-3 border-b border-gray-300">
    <a href="{{route('pages.index')}}" class="flex items-center space-x-3">
        <img src="{{asset('images/logo.png')}}" class="h-8" alt="{{config('app.name')}} Logo">
        <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap text-yellow-500">{{config('app.name')}}</span>
    </a>
    <h1 class="text-xl sm:text-2xl text-center hidden sm:block">✂️ Copy and Paste Emojis 📋</h1>
    <a class="text-white bg-black hover:bg-black/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-3 py-2 text-center" href={{route('pages.api')}}>
        Try our API
    </a>
</header>
