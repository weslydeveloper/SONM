<html>
    <head>
        <title>SONM</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="icon.png">
    </head>
<body>
    <img id="logo" src="logo.png">
    <h1 id="prijs"></h1>
    <h2 id="percent"></h2>

    <?php
    include 'config.php';

    $query = $pdo->query('select * from sonm where id % 4 = 0 ORDER BY id DESC limit 71');
    $result = $query->fetchAll();
    $arrayValues = array();

    foreach ($result as $value){
        $sonmValue = $value['sonmValue'];
        $sonmValue = floatval($sonmValue);
        array_unshift($arrayValues, $sonmValue);
    }

    $y1 = $arrayValues;
    $y2 = $arrayValues;
    array_pop($y1);
    array_shift($y2);

    $max = max(array(max($y1),  max($y2)));
    $min = min(array(min($y1),  min($y2)));

    $num = $max - $min;
    $nummer = 500/$num;
    $abstract = $min * $nummer;
    $values = array(0,0,0,0,0);

    for ($i=0;$i<5;$i++){
        $values[$i] = number_format( $min + $num / 5 * $i,1);
    }

    echo '<div class="graph" >';
    echo '<div class="nums">';
    for ($i=4;$i>-1;$i--) {
        echo '<div class="num"><a>'.$values[$i].'</a></div>';
    }
    echo '</div>';

    ?>
    <div class="lines" style="">
        <div class="line line1"></div>
        <div class="line line2"></div>
        <div class="line line3"></div>
        <div class="line line4"></div>
        <div class="line line5"></div>
        <?php

        for($i=0;$i<72;$i++){


            $done = $y1[$i]*$nummer - $abstract;
            $done = 500 - $done;


            $done2 = $y2[$i]*$nummer - $abstract;
            $done2 = 500 - $done2;

            echo '
            <svg height="500" width="9.72" style="margin-left:'. $i * 9.72 .'px; position: absolute">
            <line x1="0" y1="'. ($done) .'" x2="9.72" y2="'. ($done2) .'" style="stroke:rgb(255,0,0);stroke-width:2" />
            </svg>';
        }

        ?>
    </div>
    </div>
    <h3 class="unit">SONM price in centen, last 7 days.</h3>

    <script>
    getData();
    function getData(){

        var url = "https://api.coinmarketcap.com/v1/ticker/sonm/?convert=EUR";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var json = JSON.parse(this.responseText);

                var prijs = json[0].price_eur;
                var change = json[0].percent_change_24h;
                var percent =  document.getElementById("percent");

                document.getElementById("prijs").innerHTML = '\u20AC '+prijs;
                if ( parseFloat(change) >= 0)
                {
                    percent.innerHTML = '(' + change + '%)';
                    percent.style.color = '#093';
                } else {
                    percent.innerHTML = '(' + change + '%)';
                    percent.style.color = '#d14836';
                }
            }
        };
        xmlhttp.open("GET", url , true);
        xmlhttp.send();
        setTimeout( getData, 4000 );
    }

    </script>
</body>