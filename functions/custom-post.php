<?php
/////////////////////////////////////////
// カスタム投稿タイプを作成する
/////////////////////////////////////////
//カスタムタクソノミーのリライトルール
/*
「http://mysite/wp/member/cat/gold/」にアクセスがあった場合、
「http://mysite/wp/?member_cat=gold」にリダイレクトする
add_rewrite_rule('member/cat/([^/]+)/?$', 'index.php?member_cat=$matches[1]', 'top');
*/



//社員紹介
add_action('init', 'add_member_post_type');
function add_member_post_type() {
    $params = array(
            'labels' => array(
                    'name' => '社員紹介',
                    'singular_name' => '社員紹介',
                    'add_new' => '新規追加',
                    'add_new_item' => '社員紹介を新規追加',
                    'edit_item' => '社員紹介を編集する',
                    'new_item' => '新規社員紹介',
                    'all_items' => '社員紹介一覧',
                    'view_item' => 'ページを確認',
                    'search_items' => '検索する',
                    'not_found' => '社員紹介が見つかりませんでした。',
                    'not_found_in_trash' => 'ゴミ箱内に社員紹介が見つかりませんでした。'
            ),
            'public' => true,
            'has_archive' => true,
			'menu_position' => 5,
            'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'custom-fields',
                    'revisions',
            ),
            'taxonomies' => array('member_cat','member_tag')
    );
    register_post_type('member', $params);

	/* カスタムタクソノミーを定義 */
	register_taxonomy(
	    'member_cat',
	    'member',
	    array(
	    'label' => 'カテゴリー',
	    'hierarchical' => true,//カテゴリタイプ
	    'rewrite' => array('slug' => 'member/cat')
	    )
	);

	//カスタムタクソノミー、タグ
	register_taxonomy(
		'member_tag', 
		'member', 
		 array(
	    'label' => 'タグ',
	    'hierarchical' => false,//タグタイプ
	    'rewrite' => array('slug' => 'tag')
	    )
	);
}

/* 管理画面一覧にカテゴリを表示 */
function manage_member_columns($columns) {
	$columns['member_cat'] = "カテゴリー";
	return $columns;
}

function add_member_column($column_name, $post_id){
	if( $column_name == 'member_cat' ) {
		//カテゴリー名取得
		if( 'member_cat' == $column_name ) {
			$member_cat = get_the_term_list($post_id, 'member_cat', '', ', ', '' );
		}
		//該当カテゴリーがない場合「なし」を表示
		if ( isset($member_cat) && $member_cat ) {
				echo $member_cat;
			} else {
				echo __('None');
		}
	}
}
add_filter('manage_edit-member_columns', 'manage_member_columns');
add_action('manage_posts_custom_column',  'add_member_column', 10, 2);


?>