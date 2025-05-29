<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Hills of Glory</title>
</head>

{{-- <body class="bg-full bg-center" style="background-image: url(./background_one.jpg)"> --}}
<body class="bg-[url(/public/background_one.jpg)] bg-center bg-no-repeat bg-fixed text-white">
    <div class=" bg-black/50 h-full">
        <div id="signin-component" class="h-screen w-1/3 bg-white absolute right-0 text-black text-center align-middle py-60">
            <h1 class="text-6xl">Welcome!</h1>
            <h2 class="text-2xl">Login your account</h2>
            <form action="/dashboard" class="grid col-2 w-100 m-auto">
                <input type="text" id="username" placeholder="Username" class="col-span-2 bg-[#d9dfbc] p-2 rounded-md w-100 m-2">
                <input type="password" id="username" placeholder="Password" class="col-span-2 bg-[#d9dfbc] p-2 rounded-md w-100 m-2">
                <span class="text-start">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                </span>
                <a href="/" class="text-end">Forgot Password?</a>
                <input type="submit" value="Sign in" class="col-span-2 underline bg-[#6b8b7a] px-5 py-3 rounded-xl text-white w-50 m-auto my-20">
            </form>
        </div>
        <header class="grid grid-cols-3 w-full justify-between px-15 py-5">
            
            <div class="flex">
                <img src="/logo.png" alt="logo" class=" size-15">
                <h1 class="text-2xl">Hills of Glory - Mabalacat</h1>
            </div>
            <nav>
                <ul class="flex justify-between">
                    <li class="px-3">About</li>
                    <li class="px-3">Ministries</li>
                    <li class="px-3">Services</li>
                    <li class="px-3">Connect</li>
                </ul>
            </nav>
            <button data-collapse-toggle="signin-component" class="text-xl underline text-end" aria-controls="signin-component" aria-expanded="false">Sign in</button>
        </header>
        <div class="px-10">
            <div class="">
                <h1 class="text-6xl p-10 w-1/2">To honor God and to raise committed disciples</h1>
            </div>
            <div>
                <h2 class="h-fit text-4xl px-10">Who are able to discple multitudes</h2>
            </div>
            <div class="flex w-1/2 p-20 mt-50">
                <div>
                    <h1 class="text-3xl py-3">Announcments</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia doloribus fuga autem vel quasi porro. Placeat, quibusdam officia dolore culpa repudiandae doloribus eius doloremque ratione sequi cupiditate nostrum asperiores porro?</p>
                </div>
                <div>
                    <h1 class="text-3xl py-3">Upcoming Events</h1>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia ab, hic sint ratione ea voluptatem aut veniam aperiam pariatur. Tenetur eum dolore reiciendis veritatis illum, dolores aut numquam quibusdam velit.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>