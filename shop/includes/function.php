<?php

class Objecter {
    public function __construct($array = [])
    {
        $this->setData($array);

    }
    public function setData($array) {
        foreach ($array as $key=>$value) {
            $this->{$key} = $value;
        }
    }
    public static function __classObjToObj($obj) {
        $ob = new Objecter();
        foreach ($obj->col_name as $value) {
            $ob->{$value} = $obj->{$value};
        }
        return $ob;
    }
}

function template($object, $string, $customs = array()) {
    foreach ($object as $key=>$value) {
        if(!is_array($value)) $string = str_replace("{{" . $key . "}}", $value, $string);
    }
    foreach ($customs as $key=>$value) {
        if(!is_array($value)) $string = str_replace("{{" . $key . "}}", $value, $string);
    }
    return $string;
}

function templateIterator($object, $fun, $customs = array()) {
    $string = '';
    foreach ($object as $obj) {
        $string .= template($obj, $fun($obj), $customs);
    }
    return $string;
}

function templateAuto($qry, $string) {
    query($qry, function ($res) use ($string) {
        while($object = mysqli_fetch_object($res)) {
            echo template($object, $string);
        }
    });
}

function templateFunction($qry, $function) {
    query($qry, function ($res) use ($function) {
        while($object = mysqli_fetch_object($res)) {
            echo template($object, $function($object));
        }
    });
}

function topHeader($main) {
    echo '
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">'. $main .'</h1>
        </div>
    ';
}

function includer($name, $alt = "") {
    if($alt == "") $alt = $name . "s";
    $sources = [
        'add' => "add-$name.php",
        'edit' => "edit-$name.php",
        'all' => "all-$alt.php"
    ];

    if(isset($_GET['source'])) {
        $source = $_GET['source'];
        if(array_key_exists($source, $sources)) {
            include "includes/" . $sources[$source];
        } else {
            include "includes/" . $sources['all'];
        }
    } else {
        include "includes/" . $sources['all'];
    }
}

function updateUser($id) {
    global $notifications;
    $user = new Query('users', $id);
    $oldPass = $user->password;
    $user->setdata($_POST);
    $image = new Objecter($_FILES['image']);
    if(strlen(trim($_POST['password'])) > 0) $user->password = encryptPassword(trim($_POST['password']));
    else $user->password = $oldPass;
    if(is_uploaded_file($image->tmp_name) && file_exists($image->tmp_name)) {
        $user->image = time() . "-Profile-" . $image->name;
        move_uploaded_file($image->tmp_name, realpath('./../images/') . "/" . $user->image);
    }
    $user->update();
    redirector();
}

function registerUser($type) {
    global $_noti;
    $user = new Query("users");
    $_POST['email'] = trim($_POST['email']);
    $user->selectWhere(['email' => $_POST['email']]);
    if(strlen($user->id) == 0) {
        $user->setdata($_POST);
        $user->password = encryptPassword($user->password);
        $user->role = $type;
        $user->image = 'default-logo.png';
        $user->insert();
        $_noti->set("primary", "Users Added");
        redirector("index.php");
    } else {
        $_noti->set("warning", "Email already Exist");
        redirector();
    }
}

function redirector($url = "") {
    $url = $url == "" ? (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php") : $url;
    header("Location: $url");
    die();
}

define('_SALT' , '!@#6^&*(ASD$7F3%GHJ2L)');
function checkPassword($pass, $hashed) {
    return password_verify($pass, $hashed);
}

function encryptPassword($pass) {
    return password_hash($pass, PASSWORD_BCRYPT);
}


// check is loged in

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    if(isLoggedIn()) {
        return $_SESSION['user']->role == 'admin';
    }
}

function onlyAdmins() {
    if(!isAdmin()) {
        global $notifications;
        $notifications->set("danger", "Only admins Are Allowed There");
        redirector();
    }
}

function getIds($array, $name) {
    $ids = [];
    foreach ($array AS $itm) {
        array_push($ids, $itm->{$name});
    }
    return implode(",",$ids);
}

function delImage($file) {
    if(!unlink(realpath("./../uploads/") . "\\$file")) {
        var_dump("Unable to delete File");
    }
}

function checkActiveLink($name) {
    $script = $_SERVER['SCRIPT_NAME'] ? $_SERVER['SCRIPT_NAME'] : "";
    return strpos($script, $name) ? 'active' : '';
}
