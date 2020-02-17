<?php
    define('FAKE_USER_AGENT', "Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36");
    function getPage($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FAKE_USER_AGENT');
        $data = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: text/plain');
        return $data;
    }
?>