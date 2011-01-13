<?php
require 'class-http-request.php';

class MwApiRequest {
    private $response;
    
    function __construct($args) {
        $url = $this->formatUrl($args);
    
        echo "Getting $url\n";
    
        $r = new HttpRequest("get", $url);
        if ($r->getError()) {
            echo $r->getError();
        } else {
            $this->response = json_decode($r->getResponse(), true);
        }
    }
    
    public function getResponse() {
        return $this->response;
    }
    
    private function formatUrl($args) {
        return "http://commons.wikimedia.org/w/api.php?" .
               http_build_query($args);
    }
}