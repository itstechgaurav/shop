<div class="row">
    <div id="columnchart_material" style="width: 800px; height: 500px;margin: 100px auto 100px auto;"></div>
</div>

<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['table', 'count'],
            <?php
                $tables = ['posts', 'users', 'comments', 'categories'];
                foreach($tables as $table) {
                    $data = new Query($table);
                    $data->preSelect("SELECT count(id) AS total")->get();
                    echo template($data, '
                        [\'{{fName}}\', {{total}}],
                    ', ['fName' => $table]);
                }
            ?>
        ]);

        var options = {
            chart: {
                title: 'Company Performance',
                subtitle: 'Sales, Expenses, and Profit: 2014-2017',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>