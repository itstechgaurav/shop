<?php

if(isset($_GET['post_delete_id'])) {
    $post = new Query('posts', $_GET['post_delete_id']);
    $post->delete();
    $comments = new Query('comments');
    $comments->selectWhere(['post_id' => $post->id]);
    foreach ($comments->rows As $comment) $comment->delete();
    global $notifications;
    $notifications->set('success', 'Post Deleted');
    redirector();
} else if(isset($_GET['status_id'])) {
    $post = new Query('posts', $_GET['status_id']);
    $post->status = ($post->status == 'active') ? 'draft' : 'active';
    $post->update();
    global $notifications;
    $notifications->set('success', "Post Marked As $post->status");
    redirector();
}else if(isset($_POST['applyAction'])) {
    $ids = isset($_POST['ids'])  ? $_POST['ids'] : array();

    foreach($ids as $id) {
        $post = new Query('posts', $id);
        if($_POST['action'] == 'delete') {
            $post->delete();
            $comments = new Query('comments');
            $comments->selectWhere(['post_id' => $post->id]);
            foreach ($comments->rows As $comment) $comment->delete();
        } else if($_POST['action'] == 'clone') {
            $post->insert();
        } else {
            $post->status = $_POST['action'];
            $post->update();
        }
    }

    global $notifications;
    $notifications->set('success', "Action " . $_POST['action'] . " is Done");
    redirector();
}

?>



<form class="row" method="post">
    <?php topHeader('posts', 'all posts'); ?>
    <div class="col-lg-12">
        <div class="form-group">
            <select name="action" id="" class="form-control" style="width: 300px; float: left; margin-right: 10px;">
                <option value="clone">Make Clone</option>
                <option value="active">Mark As Active</option>
                <option value="draft">Mark As Draft</option>
                <option value="delete">Delete Posts</option>
            </select>
            <button class="btn btn-success" name="applyAction">Apply</button>
            <a href="?source=add" class="btn btn-primary" name="applyAction">Add New</a>
        </div>
    </div>
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">
                    <input type="checkbox" name="" id="markAllcheck">
                </th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Category</th>
                <th scope="col">Status</th>
                <th scope="col">Image</th>
                <th scope="col">Tags</th>
                <th scope="col" title="Total Comments">TC</th>
                <th scope="col">Date</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $posts = new Query('posts');
            $posts->preSelect("SELECT posts.*,
                                (
                                    SELECT count(comments.id) FROM comments WHERE comments.post_id = posts.id
                                ) 
                                AS TC, 
                                categories.name AS 'cat_name', users.name AS user_name ")
                ->postSelect(" INNER JOIN users ON posts.user_id = users.id
                                INNER JOIN categories ON posts.category_id = categories.id");

                if(!isAdmin()) {
                    $posts->postSelect("WHERE posts.user_id = " . $_SESSION['user']->id);
                }
                $posts->postSelect(" ORDER BY posts.id DESC")
                ->paginate()
                ->get();
             echo templateIterator($posts->rows, function() {
                return '
                    <tr>
                        <td scope="row"><input type="checkbox" name="ids[]" class="action-ids" value="{{id}}"></td>
                        <td scope="row">
                           <a target="_blank" href="../post.php?id={{id}}">{{title}}</a>                     
                        </td>
                        <td scope="row">{{user_name}}</td>
                        <td scope="row">{{cat_name}}</td>
                        <td scope="row">
                            <a href="?status_id={{id}}" class="btn btn-sm btn-info">
                                <span class="glyphicon glyphicon-refresh"></span> &nbsp;{{status}}
                            </a>                  
                        </td>
                        <td scope="row" style="text-align: center">
                            <img width="50" src="../images/{{image}}" alt="">
                        </td>
                        <td scope="row">{{tags}}</td>
                        <td scope="row">
                            <a href="comments.php?post_id={{id}}">{{TC}}</a>                    
                        </td>
                        <td scope="row">{{created_at}}</td>
                        <td>
                            <a href="?source=edit&id={{id}}" class="btn btn-sm btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </td>
                        <td>
                            <a href="?post_delete_id={{id}}" class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                ';
            })
            ?>
            </tbody>
        </table>
        <?php
            $pageination = new Pagination('posts');
            if(!isAdmin()) {
                $pageination->condition("WHERE posts.user_id = " . $_SESSION['user']->id);
            }
            $pageination->render();
        ?>
    </div>
</form>

<script>
    let markAllcheck = document.getElementById("markAllcheck");
    markAllcheck.addEventListener("click", _ => {
        document.querySelectorAll(".action-ids").forEach(id => id.checked = markAllcheck.checked);
    })
</script>