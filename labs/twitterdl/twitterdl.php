<?php
    require 'class-http-request.php';

    // Get query or die
    $query = $argv[1];
    if (empty($query)) {
        die("No query given\n");
    }

    echo "Downloading tweets with query '$query'\n";

    $page = 1;
    $baseUrl = "http://search.twitter.com/search.json?q=$query&rpp=100";
    $tweets = array();

    do {
        $url = $baseUrl . "&page=$page";
        echo "REQUEST: $url \n";
        $r = new HttpRequest("GET", $url);
        if ($r->getError()) {
            echo "HTTP ERROR: " . $r->getError();
            break;
        } else {
            $json = json_decode($r->getResponse(), true);

            // No more tweets?
            $length = count($json['results']);
            if ($length < 1) {
                echo "NO MORE TWEETS\n";
                break;
            }

            $tweets = array_merge($tweets, $json['results']);
            print_r($tweets);
            file_put_contents("$query.json", json_encode($tweets));
            $page++;
        }
    } while (true);

    // Convert to CSV as well
    $csvdata = array_map(function($tweet) {
        return array(
            "id" => $tweet['id'],
            "from_user" => $tweet['from_user'],
            "created_at" => $tweet['created_at'],
            "text" => $tweet['text']
        );
    }, $tweets);

    $file = fopen("$query.csv", "w");

    // Put keys
    fputcsv($file, array("id", "from_user", "created_at", "text") );

    foreach ($csvdata as $fields) {
        fputcsv($file, $fields);
    }