<div id="notificationContainer"
style="
    position: fixed;
    width: 250px;
    top: 10px;
    right: 10px;
    z-index: 2000;
"
>
    <?php
        global $_noti;
        echo templateIterator($_noti->get(),
        function () {
            return '
                <div class="alert alert-{{type}}" role="alert">
                    {{content}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ';
        }
        );
    ?>
</div>

<script>
    $(".alert").alert();
</script>