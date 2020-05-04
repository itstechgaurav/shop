<?php

global $notifications;
if(isset($_GET['id'])) {
    $post = new Query('posts', $_GET['id']);
    if(!isAdmin()) {
        if($_SESSION['user']->id != $post->user_id) {
            $notifications->set("danger", "You cannot edit others posts");
            redirector();
        };
    }
} else {
    $notifications->set("danger", "No id Found");
    redirector();
}

if(isset($_POST['editPost'])) {
    $post = new Query('posts', $_GET['id']);
    $post->setdata($_POST);
    $image = new Objecter($_FILES['image']);
    if(is_uploaded_file($image->tmp_name) && file_exists($image->tmp_name)) {
        echo "Hello";
        $post->image = time() . "-Ninja-Man-" . $image->name;
        move_uploaded_file($image->tmp_name, realpath('./../images/') . "/" . $post->image);
    }
    $post->update();
    header('Location: ?');
}

$post = new Query('posts', $_GET['id']);

?>


<div class="row">
    <?php
        topHeader('posts', "Edit: $post->title");
    ?>
    <div class="col-lg-12 box">
        <h2 class="tac">
            Edit Post
        </h2>
        <form action="" method="post" enctype="multipart/form-data">
            <?php
                if(!isset($_GET['id'])) die("Error no id found");
                $id = $_GET['id'];
                templateFunction("SELECT * FROM posts WHERE id = '$id'", function($res) {
                    return '
                        <div class="form-group">
                            <label for="">Title</label>
                            <input name="title" type="text" class="form-control" placeholder="(Intro To Php)" value="{{title}}">
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_id" id="" class="form-control"> ';});
                                    templateFunction("SELECT * FROM categories", function($res) use($id) {
                                        return '
                                            <option value="{{id}}" ' . ($res->id == $id ? "selected" : "") . '>{{name}}</option>
                                        ';
                                    });
                templateFunction("SELECT * FROM posts WHERE id = '$id'", function($res) {
                    return '
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tags</label>
                            <input name="tags" type="text" class="form-control" placeholder="php, html" value="{{tags}}">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input name="image" type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" id="editorJSW" cols="30" rows="10" class="form-control">{{content}}</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" type="submit" name="editPost">Edit Post</button>
                        </div>
                    ';
                });
            ?>
        </form>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#editorJSW').summernote();
    });
</script>