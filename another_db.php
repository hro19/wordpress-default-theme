<?php
/*DB設定を行います。*/
$another_db_name = 'test55_019_osatest';//DB名
$another_db_user = 'test55';//DBユーザ
$another_db_pass = 'h8b24sb76z';//DBパス
$another_db_host = 'mysql501.db.sakura.ne.jp';//DBホスト
$another_tb_prefix = 'wpfabb7b';//DBプレフィックス

$anoteher_wpdb = new wpdb($another_db_user, $another_db_pass, $another_db_name, $another_db_host);
$anoteher_wpdb->set_prefix($another_tb_prefix);
?>
<?php get_header(); ?>
<div id="main">
<ul>
<?php
//SQLの参考サイト　http://www.webopixel.net/wordpress/113.html
$results = $anoteher_wpdb->get_results("SELECT post_title FROM $anoteher_wpdb->posts");
foreach ($results as $value) {
    print('<li>'.$value->post_title.'</li>');
}
?>
</ul>
</div><!-- /#main -->
<?php get_footer(); ?>
<?php
/*
■SQL 記述例

SELECT * FROM `wpposts` LEFT JOIN wppostmeta ON(wpposts.ID = wppostmeta.post_id)
WHERE wpposts.post_status = 'publish'
AND meta_key = 'endday'
AND meta_value > '2016-11-10'
ORDER BY meta_value ASC LIMIT 10


SELECT ID,post_date,post_title,meta_key,meta_value FROM `wpposts` LEFT JOIN wppostmeta ON(wpposts.ID = wppostmeta.post_id)
WHERE wpposts.post_status = 'publish'
AND meta_key = 'startday'
AND meta_value <= '2016-10-22'
AND meta_value <= '2016-11-11'
ORDER BY meta_value DESC, post_date ASC LIMIT 20

?>