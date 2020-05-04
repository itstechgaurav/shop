<?php
include("db.php");
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass = Bcrypt::hashPassword($pass);
    echo $name . "\n";
    echo $email . "\n";
    echo $pass . "\n";
    $qry = "INSERT INTO users(name, email, password) ";
    $qry .= " VALUES('$name', '$email', '$pass')";
    $result = query($qry);
    if($result) echo "DONE";
    else echo "!!DONE";
}




?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <form autocomplete="off" method="post" class="w-6" style="width: 60%; margin: 100px auto 100px auto">
        <div class="" style="margin-bottom: 20px">
            <div class="label">Name</div>
            <input name="name" type="text" class="form-control">
        </div>
        <div class="" style="margin-bottom: 20px">
            <div class="label">Email</div>
            <input name="email" type="email" class="form-control">
        </div>
        <div class="" style="margin-bottom: 20px">
            <div class="label">Password</div>
            <input name="password" type="password" class="form-control">
        </div>
        <div class="" style="margin-bottom: 20px">
            <button name="submit" type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>
</body>
</html>
