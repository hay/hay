#!/usr/bin/php
<?php
// Convert JSON file to list of downloadable files
require 'dlcomcatcm.php';

$files = json_decode(file_get_contents("files.json"), true);

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
    logit("GET: " . $f['title']);

    $r = request($f['title']);
    $pid = $r['query']['pageids'][0];
    $url = $r['query']['pages'][$pid]['imageinfo'][0]['url'];

    $images[] = $url;
    file_put_contents("imageurl.json", json_encode($images));

    logit("FOUND: $url");

    // Download
    exec('wget -nc "' . $url . '"');
}
logit("DONE");