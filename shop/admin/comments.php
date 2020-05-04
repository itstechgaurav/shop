<?php include "includes/header.php"; ?>

          <!-- Page Heading -->

        <?php topHeader("Comments"); ?>

          <!-- Content Row -->

          <div class="row">
              <?php
              global $_noti;
              if(isset($_POST['del-comment'])) {
                    $comment = new Query('comments', $_POST['del-comment']);
                    $comment->delete();
                    $_noti->set("success", "Comment: Deleted");
                    redirector();
              }

              if(isset($_POST['comment-status'])) {
                  $comment = new Query('comments', $_POST['comment-status']);
                  $comment->approved  = $comment->approved == 'yes' ? 'no' : 'yes';
                  $comment->update();
                  $_noti->set("success", "Comment: flag set to $comment->approved");
                  redirector();
              }

              ?>

              <div class="card shadow mb-4 mx-auto w-100">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Product Name</th>
                                  <th>User</th>
                                  <th>Date</th>
                                  <th>approved</th>
                                  <th>Delete</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              $comments = new Query("comments");
                              $comments->preSelect("SELECT comments.*, products.name AS pName, users.name AS uName, DATE_FORMAT(comments.created_at, '%D %M %Y') AS date");
                              $comments->postSelect("    
                                                    INNER JOIN products ON products.id = comments.product_id
                                                    INNER JOIN users ON users.id = comments.user_id")
                                  ->postSelect("ORDER BY ID DESC")
                                  ->paginate(10)
                                  ->get();
                              echo templateIterator($comments->rows, function($category) {

                                  return '
                            <tr>
                                <td>{{id}}</td>
                                <td>{{pName}}</td>
                                <td>{{uName}}</td>
                                <td>{{date}}</td>                       
                                <td>
                                    <form action="" method="post">
                                        <button name="comment-status" class="btn btn-sm btn-success" value="{{id}}"> <i class="fas fa-fw fa-redo"></i> {{approved}}</button>    
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="post">
                                      <button name="del-comment" value="{{id}}" class="btn btn-sm btn-danger"> <i class="fas fa-fw fa-trash"> </i></button>                                  
                                    </form>                  
                                </td>
                            </tr>
                        ';
                              })
                              ?>
                              </tbody>
                          </table>
                          <?php
                          $pagination = new Pagination('comments');
                          $pagination->render();
                          ?>
                      </div>
                  </div>
              </div>
          </div>

  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
<!--Footer -->
<?php include "includes/footer.php"; ?>