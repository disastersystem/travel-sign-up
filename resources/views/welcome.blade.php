<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Travel</title>

        <!-- fonts/icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,500,600,700,800,900" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,500,600,700,800,900" rel="stylesheet" type="text/css">
        
        <!-- include this because the import does not work -->
        <link rel="stylesheet" href="https://unpkg.com/element-ui@2.0.10/lib/theme-chalk/index.css">
        
        <link href="css/css.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <trip></trip>
        </div>
        
        <script src="./js/app.js"></script>
    </body>
</html>