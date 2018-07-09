<?php
//gladysbot google image parser template//
    $url1 =  "https://hellopoetry.com/ga/poems/";
    $url2 = "https://hellopoetry.com/ga/";

    $pagePoems = getPage($url1);
    preg_match('|<div class="header-tab-stat s eq">[\r\n][ \t](.*?)[\r\n]|', $pagePoems, $count);
    $countPoems = (int) $count[1];

    $pageStream = getPage($url2);
    preg_match('|<div class="header-tab-stat s eq">[\r\n][ \t](.*?)[\r\n]|', $pageStream, $count);
    $countStream = (int) $count[1];

    function selectSource(){
        global $countPoems, $countStream, $url1, $url2;
        if($countStream > $countPoems){
            $ret['count'] = "stream"; 
            $ret['url'] = $url2;
            return $ret;
        }
        else{
            $ret['count'] = "poems"; 
            $ret['url'] = $url1;
            return $ret;
        }
    }

?>