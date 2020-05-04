<?php
include("db.php");

if(isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $qry = "DELETE FROM users WHERE id='$id'";
    $result = query($qry);
    if($result) echo "DONE";
    else echo "!!!DONE";
}

    $qry = "SELECT * FROM users";
    $result = query($qry);

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
    <div class="w-6" style="width: 60%; margin: 100px auto 100px auto">
        <?php
            while($row = $result->fetch_object()) {
                echo "-------------------<br>";
//                print_r($row);
                echo "Name: $row->name <br>";
                echo "Email: $row->email <br>";
                echo "password: $row->password <br>";
                echo "<form method='post'><button name='delete' value='$row->id' class='btn btn-danger'>DELETE</button></button></form>";
                echo "-------------------<br>";
                echo "<br>";
            }
        ?>
    </div>
</body>
</html>
