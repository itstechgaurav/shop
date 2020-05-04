<?php
include ("db.php");
$id = $_GET['id'];

$qry = "SELECT * FROM users WHERE id = $id";
$result = query($qry);

$msg = "CLICK HERE";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Query String</title>
</head>
<body>
<pre>
    <?php
    print_r($result->fetch_assoc());
    ?>
</pre>
<a href="?&id=<?php echo $id; ?>"><?php echo $msg; ?></a>
</body>
</html>
