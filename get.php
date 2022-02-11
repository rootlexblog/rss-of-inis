<?php
include('config.php');
$GLOBALS['site'] = $site;
function get(string $url, array $params = [], array $headers = [])
{
    $header  = ['Content-type'=>'application/json;','Accept'=>'application/json','origin'=>str_replace(['https','http',':','//'], '', $GLOBALS['site'])];
    $params  = !empty($params)  ? http_buld_query($params) : json_encode($params);
    $headers = !empty($headers) ? array_merge($header, $headers) : $header;
    
    foreach ($headers as $key => $val) $_headers[] = $key . ':' . $val;
    
    $curl   = curl_init();
    
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $_headers);
    curl_setopt($curl, CURLOPT_URL, $url . '?' . $params);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
    
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result,true);
    
    return $result;
}