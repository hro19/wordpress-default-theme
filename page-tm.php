<?php
/**
 * The template for displaying all single posts
 *
 * Template Name:テンプレート名
 * Template Post Type:page,カスタム投稿1type,カスタム投稿2type
 *
 */
?>
<?php include_once 'conf.php'; ?>
<?php get_template_part('header/header',$url_first); ?>

<section class="wrap">
	<div class="inner">
	<?php
	if( have_rows('宿題') ):
		while ( have_rows('宿題') ) : the_row();

			
				get_sub_field('日付', false, false);
				$title = get_sub_field('タイトル');

		endwhile;
	endif;
		?>
	</div><!-- / .inner -->
</section><!-- / .wrap -->

<?php get_template_part('footer/footer',$url_first); ?>
<?php include_once 'conf.php'; ?>
<?php get_header(); ?>

<!-- 投稿ここから -->
<?php if(have_posts()): while(have_posts()): the_post(); ?>

<?php the_content(); ?>

<?php the_time('Y年m月d日'); ?>
<?php the_time('Y/m/d'); ?>
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>



<?php the_field('呼び出す項目名') ?>

<?php if( have_rows('繰り返し名',固定ページID) ): ?>
<?php while( have_rows('繰り返し名',固定ページID) ): the_row(); ?>

<?php if(get_sub_field('呼び出す項目名') != ""){ ?>
	<a href="<?php the_sub_field('呼び出す項目名') ?>">
	<?php ACF_img('呼び出す項目名','','','row'); ?></a><br />
<?php } ?>

<?php endwhile; ?>
<?php endif; ?>


<!-- バナー読みこみ -->
<?php
if( have_rows('バナー画像') ):
	while ( have_rows('バナー画像') ) : the_row();
	?>
<li><a href="<?php the_sub_field('link'); ?>"><?php ACF_img('画像','row'); ?></a></li>
<?php	
	endwhile;
else :
	// no rows found
endif;
?>

<!-- 記事読み込み -->
<?php
$query_option = array(
	'post_type' => '投稿タイプ名',
	'posts_per_page' => 99,
	'paged' => $paged,
	'tax_query' => array(
		'relation' => 'AND',//デフォルトでandではあるが念のため
		array(
			'taxonomy' => 'タクソノミー名',
			'field'    => 'slug',
			'terms'    => 'スラグ名',
			'operator' => 'IN'
		),
		array(
			'taxonomy' => 'タクソノミー名',
			'field'    => 'slug',
			'terms'    => 'スラグ名',
			'operator' => 'NOT IN'
		)
	)
);

query_posts($query_option);
get_template_part('loop');
wp_reset_query();
?>



<?php endwhile; endif; ?>
<!-- /投稿ここまで -->

<?php get_footer(); ?>
<!-- /page.php --> 
