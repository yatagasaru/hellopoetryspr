<?php
//gladysbot google image parser template//
    $url1 =  "https://hellopoetry.com/ga/poems/";
    $url2 = "https://hellopoetry.com/ga/";
    define('FAKE_USER_AGENT', "Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36");

    function getPage($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, FAKE_USER_AGENT);
        $data = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: text/plain');
        return $data;
    }

    $countPoems = getPage($url1);
    preg_match('|<div class="header-tab-stat s eq">[\r\n][ \t](.*?)[\r\n]|', $countPoems, $count);
    $countPoems = (int) $count[1];

    $countStream = getPage($url2);
    preg_match('|<div class="header-tab-stat s eq">[\r\n][ \t](.*?)[\r\n]|', $countStream, $count);
    $countStream = (int) $count[1];

    function selectSource(){
        if($countStream > $countPoems){
            $ret['count'] = "stream"; 
            $ret['url'] = $GLOBALS["url2"];
            return $ret;
        }
        else{
            $ret['count'] = "poems"; 
            $ret['url'] = $GLOBALS["url1"];
            return $ret;
        }
    }

    $url = selectSource();
    print_r($url);

?>