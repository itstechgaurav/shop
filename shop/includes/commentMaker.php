<?php
    global $_noti;
    if(isset($_POST['content'])) {
        $comment = new Query('comments');
        $comment->setdata($_POST);
        $comment->setdata(['user_id' => $_SESSION['user']->id, 'product_id' => $_GET['product_id'], 'approved' => 'yes']);
        $comment->insert();
        $_noti->set("success", "You Just Made A Comment");
        redirector();
    }
?>


<form id="review_form" action="" method="post">
    <div>
        <h1>Add Comment</h1>
    </div>
    <div>
        <textarea id="review_message" class="input_review" name="content"  placeholder="Your Review" rows="4" required data-error="Please, leave us a review."></textarea>
    </div>
    <div class="text-left text-sm-right">
        <button id="review_submit" type="submit" class="btn red_button review_submit_btn trans_300" value="Submit">submit</button>
    </div>
</form>