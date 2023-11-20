<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bim Task Home</title>
    <link rel="icon" href="{{asset('assets/media/favicon.ico')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"
        rel="stylesheet"
    />
</head>
<body>
<div id="app">
     <router-view name="content-viewport"></router-view>
</div>

<script src="/js/app.js"></script>
</body>
</html>
