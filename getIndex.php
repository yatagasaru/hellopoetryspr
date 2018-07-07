<?php
    //++gladysbot google image parser template++//
    
    //$url =  "https://hellopoetry.com/ga/poems/";
    //$url = "https://hellopoetry.com/ga/";
    include_once "selectSource.php";
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
    
    $poemurlTemp;
    $poemurl = array();
    $source = selectSource();
    $url = $source["url"];

    function fromPoems($url){
        global $poemurl, $poemurlTemp;
        $rawpage = getPage($url);
        preg_match_all('|<a href="/(.*?)" class="poem-title nocolor">|', $rawpage, $poemurlTemp);

        foreach($poemurlTemp[1] as $val){
            array_push($poemurl, "https://hellopoetry.com/".$val);
        }
    }
    
    function fromStream($url){
        global $poemurl, $poemurlTemp;
        $rawpage = getPage($url);
        preg_match('|<a href="/(.*?)" class="nocolor">|', $rawpage, $poemurlTemp);
    
        foreach((array)$poemurlTemp[1] as $val){
            array_push($poemurl, "https://hellopoetry.com/".$val);
        }
    }

    if($source["count"] === "stream"){
        fromStream($url);
        fromPoems("https://hellopoetry.com/ga/poems/");
    }
    else{
        fromPoems($url);
    }

    $json =  $poemurl;
    $json['count'] = sizeof($poemurl);
    $json['status'] = "OK";
    header('Content-Type: application/json');
    echo json_encode($json, JSON_PRETTY_PRINT);
?>