<?php
/////////////////////////////////////////
//メインクエリーに条件を付加させていく方法がこのpre_get_posts
//アーカイブで1ページに表示される件数を制御する
/////////////////////////////////////////
/*
 * 機　能：現在のページが持っているターム情報を全て表示（echo）する
 * 使用しているテンプレート：archive-achivements.phpとsingle-achivements.php
 * @param：int($id)
 * @param：string($tax)
*/
function echoCurrentTerms($id,$tax){
	// ↓ タームの情報を取得する
	$tarms =  get_the_terms($id, $tax);
	$termsNum = count($tarms);
	//var_dump($tarms);
	//var_dump($tarms[0]);
	for($i=0;$i<$termsNum;$i++){
	echo '<p class="category">'.$tarms[$i] -> name.'</p>';
	}
}
/*
 * 機　能：現在のページが持っているターム情報（タームID,ターム名前,タームスラッグ）を取得する
 * 使用しているテンプレート：single-achivements.php
 * @param：int($id)
 * @param：string($tax)
*/
function getCurrentCategorys($id,$tax){
	$categorys =  get_the_terms($id, $tax);

    foreach($categorys as $i => $category) {
        yield [
            'term_id' => $category->term_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'totalCount' => $i,
       ];
	}

}
/*
 * 機　能：現在のページが持っているターム情報を全て表示（echo）する
 * 使用しているテンプレート：single-news.php,front-page.php
 * @param：int($id)
 * @param：string($tax)
*/
function echoCurrentNewsTerms($id,$tax){
	// ↓ タームの情報を取得する
	$tarms =  get_the_terms($id, $tax);
	$termsNum = count($tarms);
	//var_dump($tarms);
	//var_dump($tarms[0]);
	for($i=0;$i<$termsNum;$i++){
	echo '<a href="/news/cat/'.$tarms[$i] -> slug.'/">'.$tarms[$i] -> name.'</a>';
	}
}