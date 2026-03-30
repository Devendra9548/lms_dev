<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? config('app.name') }}</title>
    </head>
    <body>
       <ul>
         <li><a href="/" wire:navigate>Home</a></li>
         <li><a href="/about" wire:navigate>About</a></li>
        </ul>
        {{ $slot }}
    </body>
</html>
