<?php
    $user = new Objecter($_SESSION['user']);
    $post_id = $_GET['id'];
    if(isset($_POST['comment'])) {
        $comment = new Query('comments');
        $comment->setdata($_POST);
        $comment->setdata(['post_id' => $post_id, 'user_id' => $user->id, 'status' => 'approved']);
        $comment->insert();
    }
?>

<div class="well">
    <h4>Leave a Comment:</h4>
    <form role="form" method="post" action="">
        <div class="form-group">
            <textarea required name="content" id="commentArea" class="form-control" rows="3"></textarea>
        </div>
        <button name="comment" type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    console.log($);
    $('#commentArea').summernote({
        placeholder: 'Make a Beautiful comment',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'video']],
            ['view', ['fullscreen']]
        ]
    });
</script>