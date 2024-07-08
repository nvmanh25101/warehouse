<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{ $ControllerName ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/icons.css')
    @vite('resources/css/app-creative.min.css')
    @vite('resources/css/app.css')
    @stack('css')
</head>
