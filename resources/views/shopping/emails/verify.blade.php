<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with the verification demo app.
            Please follow the link below to verify your email address
            {{ URL::to('register/verify/' . $confirmation_code) }}.<br/>

        </div>
</body>
</html> 