<?php

require_once realpath(__DIR__ . '/Feed.php');
include('get.php');
include('config.php');
$feed = new \Zelenin\Feed;
// $feed->addChannel();
$feed->addChannel();

// required channel elements
$feed
    ->addChannelTitle($websitetitle)
    ->addChannelLink($websitelink)
    ->addChannelDescription($websitedescription);
// optional channel elements
$feed
    ->addChannelLanguage('zh-CN')
    ->addChannelPubDate(time()) // timestamp/strtotime/DateTime
    ->addChannelLastBuildDate(time()) // timestamp/strtotime/DateTime
    ->addChannelTtl(60);
$feed->addItem();

$result = get($api . '/api/article');
$postc = $result['data']['count'];
$i = 0;
while($i<$postc)
{
    
    $feed
    ->addItemTitle($result['data']['data'][$i]['title'])
    ->addItemDescription(mb_strimwidth($result['data']['data'][$i]['description'], 0, 60, "..."))
    ->addItemLink('https://' . $site . '/#/article/' . $result['data']['data'][$i]['id'])
    ->addItemAuthor($result['data']['data'][$i]['expand']['author']['nickname'])
    ->addItemPubDate($result['data']['data'][$i]['create_time']);
    $i++;
}


echo $feed;
// $feed->save(realpath(__DIR__ . '/rss.xml'));