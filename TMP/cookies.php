<?php
include ("db.php");

if(isset($_POST['set-c'])) {
    $name = $_POST['name'];
    $content = $_POST['content'];
    $expiration = time() + (60*60*24*7*4*12);
    setcookie($name, $content, $expiration);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Query String</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>

<form action="" method="post" style="width: 60%;margin: 100px auto;">
    <div class="form-group">
        <div class="label">Name</div>
        <input name="name" type="text" class="form-control">
    </div>
    <div class="form-group">
        <div class="label">Content</div>
        <input name="content" type="text" class="form-control">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" name="set-c">Set Cookie</button>
    </div>
</form>

<?php
    foreach ($_COOKIE as $key=>$value) {
        ?>
            <pre>
<?php echo "[$key]" . "<br>" . $value; ?>
            </pre>
            </pre>
        <?php
    }
?>
</body>
</html>
