<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1> Hi {{ $values['name'] }}</h1>
    <p>Success Register !!!</p>
    <button><a href="{{ route('shopping.login_post') }}">Chuyển sang Home</a></button>
</body>
</html>