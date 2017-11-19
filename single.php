<?php
/*single.php*
	各投稿の個別ページ。まぁほぼ必須。個別記事のページにだけブクマボタンや広告表示をつけたり等活躍します。
	
 */
?>
<?php include_once 'conf.php'; ?>
<?php get_header(); ?>

<div id="main">

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h2 class="posttitle"><?php the_title(); ?></h2>
<p class="postdate">Posted on <?php the_time('Y年n月j日(D) H:i'); ?></p>

<?php the_post_thumbnail(); 
	//アイキャッチ画像の出力 ?>

<?php the_content();
	//投稿本文の出力 ?>
	

<div class="postinfo">
<!-- echoCurrentNewsTerms($id,$tax); -->
<?php echoCurrentNewsTerms($post ->ID,'member_cat');?>
<hr>
<?php $currentCategorys = getCurrentCategorys($post ->ID,'member_cat');

	foreach ($currentCategorys as $currentCategory) {
		echo $currentCategory['name'].':';
	}
	echo '<br>';
	echo '合計数:'.$currentCategory['totalCount'];
?>
</div>

</div><!-- /.post -->



<?php endwhile; endif; ?>

<!-- ここからは、次のページ／前のページへのテキストリンクを出力するためのタグ -->
<p class="pagelink">
<span class="pageprev"><?php previous_post_link('&laquo; %link') ?></span>
<span class="pagenext"><?php next_post_link('%link &raquo;') ?></span>
</p>
<!-- /ページ送りのリンクここまで -->

</div><!-- /#main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<!-- /single.php -->