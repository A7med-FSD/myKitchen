<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyKitchen</title>
  {{-- main font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  
  {{-- main logo --}}
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{Vite::asset('resources/images/favicon_io/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{Vite::asset('resources/images/favicon_io/favicon-16x16.png')}}">
  <link rel="manifest" href="/site.webmanifest">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Alpine Plugins --}}
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  {{-- Entrance Animations --}}
  <link rel="stylesheet" href="{{ asset('assets/css/entrance.css') }}">
</head>
<body class="bg-gradient-to-br from-yellow-50 to-orange-20 min-h-screen flex items-center justify-center p-4">
    
  {{ $slot }}

</body>
</html>
