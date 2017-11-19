<?php

// カスタム投稿タイプの設定
require_once('functions/custom-post.php');
require_once('functions/own_functions.php');

//カスタム投稿が表示されない場合のパーマリンクリセット
/*global $wp_rewrite;
  $wp_rewrite->flush_rules();*/

//WPアップデート通知を非表示
//add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));

//プラグイン更新通知を非表示
//remove_action( 'load-update-core.php', 'wp_update_plugins' );
//add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

// 更新のお知らせを消すためのもの
/*add_action('admin_menu', 'remove_counts');
function remove_counts(){
	global $menu,$submenu;
	$menu[65][0] = 'プラグイン';
	$submenu['index.php'][10][0] = 'Updates';
}
*/

//アイキャッチ画像に対応
add_theme_support( 'post-thumbnails' );
add_image_size( 'top_slider', 810, 360, true );//topスライダー
add_image_size( 'w700', 700, 0, true );//横幅700
add_image_size( 'w180', 1800, 0, true );//横幅180


/**
* 管理画面の「投稿一覧」と「固定ページ一覧」の最大表示数を変更する
* @return i
*/
function my_edit_posts_per_page ($posts_per_page) {
	return 75;
}
add_filter('edit_posts_per_page', 'my_edit_posts_per_page');


/**
* 各投稿タイプの一覧に表示する件数を設定
* @return void
*/
function change_posts_per_page($wp_query) {
        if ( is_admin() || ! $wp_query->is_main_query() ) return;

        if ( $wp_query->is_post_type_archive('hoge')) {//カスタム投稿
            //初期設定
			$wp_query->set( 'posts_per_page', '-1' );
		}
}
add_action( 'pre_get_posts', 'change_posts_per_page' );

/**
* URLの取得 「/」区切りで配列
* @return array
*/
function my_url(){
	$str = str_replace("/srcowp/", "/", $_SERVER["REQUEST_URI"]);
	$my_url['url'] = $str;
	$my_url['url'] = substr_replace($my_url['url'], "", 0,1);//一文字目の/を削除
	$my_url['path'] = explode("/", $my_url['url']);
	$my_url['url'] = "/".$my_url['url'];//一応/をいれておく。
	return $my_url;
}

/**
* NEWマーク1
* @return string
* $days 何日後に削除するか。
* $date 以下の値（Unix Epoch）を入れる
* 投稿日 get_the_time('U');
* 更新日 get_the_modified_date('U');
*/
/*
function add_new($date,$days){
    $today = date_i18n('U');
    $elapsed = date('U',($today - $date)) / 86400;
    if( $days > $elapsed ){
        $re = '<span>New!</span>';
    }else{
    	$re = NULL;
    }
    return $re;
}
*/

/**
* NEWマーク2
* @return string
* $days 何日後に削除するか。
* $date YYYY-MM-DD の形式で渡す
*/
function add_new($date,$days=7){
	$new_date = date("Y-m-d", strtotime("-".$days." day"));
    if( $date > $new_date ){
        $re = '<span>New!</span>';
    }else{
    	$re = NULL;
    }
    return $re;
}

/**
* 文字数制限
* $str 文字　,$int カット文字数,$end 語尾の文字
* @return str
*/
function na_trim_words($str,$int,$end='…'){
	$post_content = strip_tags($str);
	if(mb_strlen($post_content)>$int ) {
		$post_content = mb_substr($post_content,0,$int);
		$post_content = str_replace(array("\r", "\n"), '', $post_content).$end; 
	} else { 
		$post_content = str_replace(array("\r", "\n"), '', $post_content);
	}
	return $post_content;
}

/**
* taxonomyPAGE用のデータ取得
* @return str
*/
function na_taxonomy_data(){
	$queried_object = get_queried_object();
	$taxonomy = get_taxonomy($queried_object -> taxonomy);
	
	$r['label'] = $taxonomy -> label;//ラベル名
	$r['parent_url'] =  '/'.$taxonomy -> rewrite['slug'].'/';//親
	$r['tag_title'] = $queried_object -> name;
	$r['slug'] = $queried_object -> slug;
	$r['taxonomy'] = $queried_object -> taxonomy;
	$r['url'] = $r['parent_url'].$r['slug'].'/';
	
	return $r;
}

/**
* query_posts を post__in 順に並び替える
* $post__in_ids に post__in の値を必ず入れる。query_posts(）の前に実行
*
* 例：
* $post__in_ids = $data;//ソート用ID配列
* add_filter( 'posts_orderby' , 'post_ids_orderby' );
* query_posts($query_option);
* @return $orderby
*/
function post_ids_orderby( $orderby ) {
    global $post__in_ids;
	//var_dump($orderby);
    return 'FIELD(ID, ' . join( ", " , $post__in_ids ) . ')';
}


/**
 * 自動整形停止
 */
add_action('init', function() {
    remove_filter('the_title', 'wptexturize');
    remove_filter('the_content', 'wptexturize');
    remove_filter('the_excerpt', 'wptexturize');
    remove_filter('the_title', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('the_editor_content', 'wp_richedit_pre');
});

add_filter('tiny_mce_before_init', function($init) {
    $init['wpautop'] = false;
    $init['apply_source_formatting'] = true;
    return $init;
});



/**
 * 絵文字スクリプト削除
 */
function disable_emoji() {
     remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
     remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
     remove_action( 'wp_print_styles', 'print_emoji_styles' );
     remove_action( 'admin_print_styles', 'print_emoji_styles' );
     remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
     remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
     remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emoji' );




/**
 * page-***.php の階層を持たせるフィルター
 * 例：page-xxx-yyy.php  （/xxx/yyyy/）
 */
function my_page_template ( $template ){
	global $post;
	$post_type = get_post_type_object($post->post_type);
	if ( $post_type->hierarchical ){
		$slug = get_page_uri($post->ID);
		$slug = str_replace( '/', '-', $slug );
		$buf_template = locate_template('page-' . $slug . '.php');
		$buf_page_template = get_page_template_slug();
		if ( !empty($buf_template) && empty($buf_page_template) ){
			$template = $buf_template;
		}
	}
	return $template;
}
add_filter( 'page_template', 'my_page_template' );


/**
 * single-***.php の階層を持たせるフィルター
 * 例：single-xxx-yyy.php  （/xxx/yyyy/）
 */
function my_single_template ( $template ){
	global $post;
	$post_type = get_post_type_object($post->post_type);
	if ( $post_type->hierarchical ){
		$slug = get_page_uri($post->ID);
		$slug = str_replace( '/', '-', $slug );
		$buf_template = locate_template('single-' . $slug . '.php');
		$buf_page_template = get_page_template_slug();
		if ( !empty($buf_template) && empty($buf_page_template) ){
			$template = $buf_template;
		}
	}
	return $template;
}
add_filter( 'single_template', 'my_single_template' );


/**
 * User agent 振り分け
 * @return bool　[true]→スマホ,[false]→PCタブレット
 */
function UA_check (){
   /* 端末のUAを取得 */
    $ua = $_SERVER['HTTP_USER_AGENT'];

    /* iPhone/iPod/Androidスマホが該当 */
    if ((strpos($ua, 'iPhone') !== false)
    || (strpos($ua, 'iPod') !== false)
    || (strpos($ua, 'Android') !== false)
    && (strpos($ua, 'Mobile') !== false)) {
		$r = true;
    }

    /* iPhone/iPad/iPod/Androidスマホ/Androidタブレットが該当 */
    if ((strpos($ua, 'iPhone') !== false)
    || (strpos($ua, 'iPod') !== false)
    || (strpos($ua, 'iPad') !== false)
    || (strpos($ua, 'Android') !== false)) {
		$r = false;
    }
	return $r;
}

/**
 * 管理画面CSS読み込み
 */
function custom_enqueue($hook_suffix) {
	// 新規投稿または編集画面のみ
	if( 'post.php' == $hook_suffix ) {
		wp_enqueue_style('custom_css', get_template_directory_uri() . '/css/admin_custom.css');
	}
}
add_action( 'admin_enqueue_scripts', 'custom_enqueue' );


/**
 * hook_suffix を管理画面に表示
 */
/*
function current_pagehook(){
	global $hook_suffix;
	if( !current_user_can( 'manage_options') ) return;
	echo '<div class="updated"><p>hook_suffix : '.$hook_suffix.'</p></div>';
}
add_action('admin_notices', 'current_pagehook');
*/

/**
 * wp-pagenavi　HTML置換
 */
/*
add_filter( 'wp_pagenavi', 'custom_wp_pagenavi' );
function custom_wp_pagenavi($html) {
	$out = '';
	$out = str_replace("<div", "", $html);
	$out = str_replace("class='wp-pagenavi'>", "", $out);
	$out = str_replace("<a", "<li><a", $out);
	$out = str_replace("</a>", "</a></li>", $out);
	$out = str_replace("<span", "<li><span", $out);
	$out = str_replace("</span>", "</span></li>", $out);
	$out = str_replace("</div>", "", $out);
	$out = str_replace("<li><span class='current'>", "<li class='current'><span>", $out);

	return $out;
}
*/



/*************************************
 Contact7
**************************************/
/*必要なページ以外は JS CSS を読み込まない*/
switch ($_SERVER['REQUEST_URI']) {
	case "/hoge/contact/": break;

    default:
    add_filter( 'wpcf7_load_js', '__return_false' );
	add_filter( 'wpcf7_load_css', '__return_false' );
}



//contact7　メール確認フォーム
//[email* your-email]　→　確認用 [email* your-email_confirm]
add_filter( 'wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2 );
function wpcf7_text_validation_filter_extend( $result, $tag ) {
	$type = $tag['type'];
	$name = $tag['name'];
	$_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );
	if ( 'email' == $type || 'email*' == $type ) {
		if (preg_match('/(.*)_confirm$/', $name, $matches)){
			$target_name = $matches[1];
			if ($_POST[$name] != $_POST[$target_name]) {
				$result['valid'] = false;
				$result['reason'][$name] = '確認用のメールアドレスが一致していません';
			}
		}
	}
return $result;
}




/*//////////////////////////////////////
■ACF画像の呼び出し v1.1
ACF_image('項目名','サイズ','種類');
種類：photo、url、alt、title、caption

■種類とサイズは省略可能。
サイズ　→　full
種類	→　imgタグが呼び出されます。

■CF画像の返り値は必ず「画像オブジェクト」にする。
*//////////////////////////////////////
function ACF_img($str,$size_name='full',$type='photo',$row=''){

	//空入力を有効に
	if($type ==''){$type = 'photo';}

	//rowを第2因数以降でも有効に
	if($size_name == 'row' || $type == 'row' ){
		$row = 'row';
		$type='photo';
		if($size_name == 'row'){
			$size_name='full';
		}
	}

	//rowの処理
	if($row != 'row'){
		$image = get_field($str);
	}else{
		//繰り返し（repeater）の画像呼び出し
		$image = get_sub_field($str);
	}

	//画像情報の読み込み
	if( !empty($image) ){
		// vars
		$url = $image['url'];
		$alt = $image['alt'];
		$title = $image['title'];
		$caption = $image['caption'];

		// Resize
		if(($size_name != '') && ($size_name != 'full')){
			$thumb = $image['sizes'][$size_name];
		}else{
			$thumb = $url;
		}

		switch ($type){
			case 'photo': 	$photo = '<img src="'.$thumb.'" alt="'.$alt.'" />';break;
			case 'url': 	$photo = $thumb;break;
			case 'alt': 	$photo = $image['alt'];break;
			case 'title': 	$photo = $image['title'];break;
			case 'caption': $photo = $image['caption'];break;
		}

		echo $photo;

	}

}

//繰り返し（repeater）の画像呼び出し
function ACF_row_img($str,$size_name='',$type='photo'){

	$image = get_sub_field($str);

	if( !empty($image) ){
		// vars
		$url = $image['url'];
		$alt = $image['alt'];
		$title = $image['title'];
		$caption = $image['caption'];

		// Resize
		if($size_name){
			$thumb = $image['sizes'][$size_name];
		}

		switch ($type){
			case 'photo': 	$photo = '<img src="'.$thumb.'" alt="'.$alt.'" />';break;
			case 'url': 	$photo = $thumb;break;
			case 'alt': 	$photo = $image['alt'];break;
			case 'title': 	$photo = $image['title'];break;
			case 'caption': $photo = $image['caption'];break;
		}

		echo $photo;

	}

}

/***************************
AFC リストとして表示する
****************************/
function ACF_list($str,$tag='li'){
	$str = get_field($str);
	$fieldData = explode("\n",$str);
	$i = 0;
	foreach ($fieldData as $value){
		if ( $value ){
			echo '<'.$tag.'>' . $value . '</'.$tag.'>';
		}
		$i++;
	}
}


?>