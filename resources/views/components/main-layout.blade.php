<!doctype html>
<html>

<head>
    <title>Buddhichal </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/css/app.css' ,'resources/js/app.js', 'resources/css/tabulators.css'])
</head>

<body class="dark:bg-[#111827] text-gray-900 dark:text-white">
    {{ $slot }}

</body>

</html>