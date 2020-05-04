<?php
    if(isset($_GET['submit'])) {
        echo "<h1>NAME: " . $_GET['name'] . "</h1>";
        echo "<h1>Email: " . $_GET['email'] . "</h1>";
        echo "<h1>Passcode: " . $_GET['passcode'] . "</h1>";
    }
?>
<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="">
    <span>Name: </span>
    <input name="name" type="text" placeholder="name"><br>
    <span>Email: </span>
    <input name="email" type="email" placeholder="email"><br>
    <span>Passcode: </span>
    <input name="passcode" type="password" placeholder="passcode"><br>
    <input name="submit" type="submit">
</form>
</body>
</html>
