#!/usr/bin/php
<?php
require 'dlcomcatcm.php';

$files = file("piet.txt");

function request($title) {
    $mw = new MwApiRequest(array(
        "format" => "json",
        "action" => "query",
        "titles" => $title,
        "prop" => "imageinfo",
        "iiprop" => "url",
        "indexpageids" => "1"
    ));

    return $mw->getResponse();
}

function logit($msg) {
    file_put_contents("dllog.log", "$msg \n", FILE_APPEND);
}

$images = array();
foreach ($files as $f) {
    logit("GET: " . $f);

    $r = request($f);
    $pid = $r['query']['pageids'][0];
    $url = $r['query']['pages'][$pid]['imageinfo'][0]['url'];

    $images[] = $url;
    file_put_contents("imageurl.json", json_encode($images));

    logit("FOUND: $url");

    // Download
    exec('wget -P jpg -nc "' . $url . '"');
}
logit("DONE");