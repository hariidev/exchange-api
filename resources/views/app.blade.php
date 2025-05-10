<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exchange Rate App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav>
            <router-link to="/">View Rates</router-link>
            <router-link to="/admin/rates">Manage Rates</router-link>
        </nav>
        <router-view></router-view>
    </div>
</body>
</html>