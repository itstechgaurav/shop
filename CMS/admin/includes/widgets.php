<?php
$wConfigs = ['posts' => 'primary', 'comments' => 'green', 'users' => 'yellow', 'categories' => 'red'];
$wIcons = ['posts' => 'file-text', 'comments' => 'comments', 'users' => 'user', 'categories' => 'list'];
function widgetsMaker() {
    global $wConfigs;
    global $wIcons;
    foreach ($wConfigs as $tableName=>$colorName) {
        $tmpRow = new Query($tableName);
        $tmpRow->preSelect('SELECT count(id) AS total')->get();
        echo template(new Objecter($tmpRow), '
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-{{color}}">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-{{wIcon}} fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class=\'huge\'>{{total}}</div>
                                <div>{{tbName}}</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{tbName}}.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        ', ['color' => $colorName, 'tbName' => $tableName, 'wIcon' => $wIcons[$tableName]]);
    }
}

?>

<!-- /.row -->

<div class="row">
    <?php
        widgetsMaker();
    ?>
</div>