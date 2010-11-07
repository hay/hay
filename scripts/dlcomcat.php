#!/usr/bin/php
<?php
// Writes a JSON file with all images in a Commons category

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
        "cmlimit" => "500"
    );

    if ($cmcontinue) {
        $args['cmcontinue'] = $cmcontinue;
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
$firstquery = true;

do {
    if (isset($data['query-continue'])) {
        $cmcontinue = $data['query-continue']['categorymembers']['cmcontinue'];
    } else {
        // First time or last query?
        if ($firstquery) {
            $cmcontinue = true;
            $firstquery = false;
        } else {
            echo "No more images..\n";
            break;
        }
    }

    $data = request($cmcontinue);

    if ($data['error']) {
        echo "FATAL ERROR: " . $data['error']['info'] . "\n";
        break;
    } else {
        echo "Adding images...\n";

        foreach ($data['query']['categorymembers'] as $c) {
            echo $c['title'] . "\n";
            $images[] = $c;
        }

        file_put_contents("files.json", json_encode($images));
    }
} while (true);

echo "Done!\n";
print_r($images);