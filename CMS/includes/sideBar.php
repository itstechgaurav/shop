
<!-- Blog Search Well -->
<div class="well">
    <h4>Search Posts</h4>
    <form method="get" action="search.php" class="input-group">
        <input name="s" type="text" class="form-control">
        <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
        </span>
    </form>
    <!-- /.input-group -->
</div>

<!--
Login Form
-->
<?php

    if(!$logedIn) include "loginForm.php";

?>


<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php
                    templateAuto("SELECT id,UPPER(name) AS name FROM categories", '
                        <li><a href="category.php?id={{id}}">{{name}}</a></li>
                    ');
                ?>
            </ul>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<div class="well">
    <h4>Side Widget Well</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
</div>
