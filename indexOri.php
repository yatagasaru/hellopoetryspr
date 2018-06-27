<?php
    //gladysbot google image parser template//
    $url =  "https://hellopoetry.com/ga/poems/";
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
    
     $rawpage = getPage($url);//file_get_contents('rawPage.txt');

     /*//++for future use++//
     $next = strpos($rawpage, "Next page");
     if($next){
         
         echo "Next Page found!";
         preg_match('|<a href="(.*?)" class="btn btn-block">|', $rawpage, $match);
         $nextURL = $match[1];
     }*/


     preg_match_all('|<a href="/(.*?)" class="poem-title nocolor">|', $rawpage, $poemurl);
     foreach($poemurl[1] as &$val){
        $val = "https://hellopoetry.com/".$val;
     }

    preg_match_all('|class="poem-title nocolor">(.*?)</a>|', $rawpage, $match);
    preg_match_all('|<div class="poem-part continue-reading poem-body wordwrap">[\r\n][ \t](.*?)<br>[\r\n]|', $rawpage, $match2);
    //preg_match_all('|[ \t](.*?)"2018|', $rawpage, $match3);
      echo "<pre>";
    // print_r($match2[1]);
    // print_r($match2);
     //print_r($match3);
     print_r($poemurl[1]);
      echo "</pre>";
    
    // for($i = 0; $i<5; $i++){
    //     $match3[1][$i] = "http://www.imigrasi.go.id".$match3[1][$i];
    // }
    //  for($i = 0; $i<5; $i++){
    //         $json[$i]['title'] = $match[1][$i];
    //         $json[$i]['date'] = $match2[1][$i];
    //         $json[$i]['readmore'] = $match3[1][$i];
    //  }  
    // // $json[0]['title'] = $match[1][0];
    // // $json[0]['date'] = $match2[1][0];
    // // $json[0]['readmore'] = $match3[1][0];
    // // $json[1]['title'] = $match[1][1];
    // // $json[1]['date'] = $match2[1][1];
    // // $json[1]['readmore'] = $match3[1][1];
    $temp = array();
    //$tempContent = array();
    for($i = 0; $i < sizeof($match[1]); $i++ ){
        $tmp['title'] = $match[1][$i];
        $tmp['content'] = ltrim($match2[1][$i]);
        array_push($temp, $tmp);
        //array_push($tempContent, $tmp);
    }
    // foreach($match[1] as $val){
    // }

    $json['ret'] = $temp;
    $json['count'] = sizeof($match[1]);
    $json['status'] = "OK";
    header('Content-Type: application/json');
    echo json_encode($json, JSON_PRETTY_PRINT);
    //file_put_contents('return.json', json_encode($json, JSON_PRETTY_PRINT));
    // echo str_replace('\\', "",file_get_contents('return.json')); 

?>