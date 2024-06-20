<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Verifikasi</title>
        <style>
          
        </style>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

        
    </head>
    <body  class="font-sans leading-normal tracking-normal">
      <div class="min-h-screen flex flex-wrap content-center justify-center">
        <div class="w-1/3 p-8 shadow-md rounded-md bg-gray-100">
          <div class="ml-2 text-medium">
            {{ (($message == 'Success') ? 'Email Berhasil Diverifikasi, Silahkan Login' : 'Email gagal diverifikasi') }}
          </div>
        </div>
      </div>
    
    </body>
</html>