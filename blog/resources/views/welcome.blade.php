<!DOCTYPE html>
<html lang="en" data-theme="" class='h-full'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>

<body class="h-full">
    <div id="app"></div>
</body>

</html>
