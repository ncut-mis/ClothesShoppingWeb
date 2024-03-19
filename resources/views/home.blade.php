<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


    </head>
    <body class="font-sans antialiased">        
        @include('layouts.categories')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const categoryLinks = document.querySelectorAll('.category-link');

            categoryLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const categoryId = this.getAttribute('data-category-id');

                    // 发起 AJAX 请求到指定的端点
                    fetch(`/categories/${categoryId}`)
                        .then(response => response.text())
                        .then(html => {
                            // 将响应的 HTML 更新到页面中
                            document.getElementById('category-items-display').innerHTML = html;
                        });
                });
            });
        });
        </script>
    </body>
</html>