<?php
    require 'class-http-request.php';
    $page = 1;
    $query = "vpro+wikileaks+reeepidee";
    $baseUrl = "http://search.twitter.com/search.json?q=$query";
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