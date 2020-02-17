<?php
    require_once "./utils/selectSource.php";
    
    $poemurlTemp;
    $poemurl = array();
    $source = selectSource();
    $url = $source["url"];

    function fromPoems($url){
        global $poemurl, $poemurlTemp, $pagePoems;
        $rawpage = $pagePoems;//selectSource.php;
        preg_match_all('|<a href="/(.*?)" class="poem-title nocolor">|', $rawpage, $poemurlTemp);

        foreach($poemurlTemp[1] as $val){
            array_push($poemurl, "https://hellopoetry.com/".$val);
        }
    }
    
    function fromStream($url){
        global $poemurl, $poemurlTemp, $pageStream;
        $rawpage = $pageStream;////selectSource.php;
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
    $json['source']['name'] = $source['count'];
    $json['source']['url'] = $url;
    $json['count'] = sizeof($poemurl);
    $json['status'] = "OK";
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    echo json_encode($json, JSON_PRETTY_PRINT);
?>
