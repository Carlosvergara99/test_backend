<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

        <link href="{{mix('css/app.css')}}" rel="stylesheet">
        
    </head>
    <body>
        <div id="app" class="content">
            <competition-component></competition-component>
        </div>
    <script src="{{asset('js/app.js')}}"></script> 
</body>
</html>