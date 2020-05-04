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
        echo templateIterator($notifications->get(),
        function () {
            return '
                <div onmouseenter="createHeight(this)" class="alert alert-{{type}}" style="border: none !important; padding: 0 !important;transition: .45s !important;margin-bottom: 3px; overflow: hidden" role="alert">
                    <div class="alert-text" style="padding: 20px;">
                    {{content}}
                      <button onclick="closeAlert(this.parentElement.parentElement)" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                </div>
            ';
        }
        );
    ?>
</div>

<script>
    function closeAlert(parent) {
        parent.style.height = 0 + "px";
        setTimeout(function() {
            parent.parentElement.removeChild(parent);
        }, 700);
    }
    function createHeight(parent) {
        parent.style.height = parent.offsetHeight + "px";
    }
</script>