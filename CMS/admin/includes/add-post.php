<?php

if(isset($_POST['addPost'])) {
    $post = new Query('posts');
    $data = new Objecter($_FILES['image']);
    $post->setdata($_POST);
    $post->setdata(['user_id' => $_SESSION['user']->id, 'status' => 'draft', 'image' => time() . "-Ninja-Man-" . $data->name]);
    move_uploaded_file($data->tmp_name, realpath('./../images/') . "/" . $post->image);
    $post->insert();
    header("Location: ?");
}

?>


<div class="row">
    <?php topHeader('posts', 'add post'); ?>
    <div class="col-lg-12 box">
        <h2 class="tac">
            Add Post
        </h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Title</label>
                <input name="title" type="text" class="form-control" placeholder="(Intro To Php)">
            </div>
            <div class="form-group">
                <label for="">Category</label>
                <select name="category_id" id="" class="form-control">
                    <?php
                        templateFunction("SELECT * FROM categories", function($res) {
                            return '
                                <option value="{{id}}" ' . ($res->id == 3 ? 'selected' : '') . '>{{name}}</option>
                            ';
                        });
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Tags</label>
                <input name="tags" type="text" class="form-control" placeholder="php, html">
            </div>
            <div class="form-group">
                <label for="">Image</label>
                <input name="image" type="file" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Content</label>
                <textarea name="content" id="editorJSW" cols="30" rows="10" class="form-control"></textarea>
<!--                <div name="content" id="editorJSW" style="width: 100%; height: 500px;" class="form-control"></div>-->
            </div>
            <div class="form-group">
                <button class="btn btn-info" type="submit" name="addPost">Add Post</button>
            </div>
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