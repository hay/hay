#!/usr/bin/php
<?php
require 'class-http-request.php';

function apirequest($args) {
    return "http://commons.wikimedia.org/w/api.php?" .
           http_build_query($args);
}

function request($cmcontinue = false) {
    $args = array(
        "format" => "json",
        "action" => "query",
        "list" => "categorymembers",
        "cmtitle" => "Category:Images_from_Wiki_Loves_Monuments",
        "cmlimit" => "10"
    );

    if ($cmcontinue) {
        array_push($args, "cmcontinue" => $cmcontinue;
    }

    $url = apirequest($args);

    echo "Getting $url\n";

    $r = new HttpRequest("get", $url);
    if ($r->getError()) {
        echo $r->getError();
    } else {
        return json_decode($r->getResponse(), true);
    }
}

$images = array();

do {
    $cmcontinue = (isset($data['query-continue']))
                  ? $data['query-continue']['categorymembers']['cmcontinue'])
                  : false;

    $data = request($cmcontinue);

    if ($data['error']) {
        echo "FATAL ERROR: " . $data['error']['info'] . "\n";
        break;
    } else {
        echo "Adding images...\n";
        for ($data['query']['categorymembers'] as $c) {
            echo $c['title'] . "\n";
        }
        array_push($images, $data['query']['categorymembers']);
    }
} while (true);

echo "Done!\n";
print_r($images);

file_put_contents("files.json", json_encode($images));