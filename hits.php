<?php

    if(! array_key_exists('q', $_GET)){
        die('missing parameter q');
    }
    $q = $_GET['q'];

    $html = file_get_contents("http://mojburger.mcdonalds.pl/services/burgers/" . $q);
    $html = substr($html, 3);
    //    echo $html;
    $json = json_decode($html);

    $votes = $json->yes;

//    var_dump($json);
    echo $votes;

?>