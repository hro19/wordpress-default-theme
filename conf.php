<?php
//エラー出力
ini_set( 'display_errors', 1 );

//urlの取得
$url = my_url();
$url_first = isset($url['path'][0]) ? $url['path'][0] : NULL ;
$url_second = isset($url['path'][1]) ? $url['path'][1] : NULL ;
$url_third = isset($url['path'][2]) ? $url['path'][2] : NULL ;
$pageid = $url_first=="" ? 'top' : $url_first ;
?>