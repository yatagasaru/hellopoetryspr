<?php
    require_once "./utils/getPage.php";
    $url =  $_GET['q'];//"https://hellopoetry.com/poem/2254296/setelah-gelap/";
    $rawpage = getPage($url);//file_get_contents('rawPage.txt');

    preg_match_all('|class="nocolor">(.*?)</a>|', $rawpage, $match);
    preg_match_all('|<div class="poem-part continue-reading poem-body wordwrap">[\r\n][ \t](.*?)<br>[\r\n]|', $rawpage, $match2);
    preg_match_all('|<div class="poem-part topss poem-append s wordwrap">[\r\n][ \t](.*?)[\r\n]|', $rawpage, $match3);

    $json['title'] = $match[1][0];
    $json['content'] = ltrim($match2[1][0]);
    $json['note'] = str_replace("<br />", "<br>", ltrim($match3[1][0]));
    $json['count'] = sizeof($match[1]);
    $json['status'] = "OK";
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    echo json_encode($json, JSON_PRETTY_PRINT);
?>
