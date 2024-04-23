<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<header>
    <h1>歡迎來到我的網站</h1>
</header>
<nav>
    <ul>
        <li><a href="#">首頁</a></li>
        <li><a href="#">服務</a></li>
        <li><a href="#">關於</a></li>
    </ul>
</nav>
<main>
    <section>
        <h2>文章標題</h2>
        <p>這裡是文章內容...</p>
    </section>
</main>
<footer>
    <p>版權所有 © 2024</p>
</footer>
</body>
</html>
