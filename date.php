<?php
/* date.php */
?>
<?php get_header(); ?>

<?php

	$query_option = array(
				'post_type' => 'blog',
				'posts_per_page' => 10,
				'paged' => $paged
				);

	if(is_month()){

		$setYear=get_the_date('Y');
		$setMonth=get_the_date('m');

		$query_option['year']=$setYear;
		$query_option['monthnum']=$setMonth;

	}


	query_posts($query_option);
	
	if ( is_month() ){
		get_template_part('loop-blog_cat');
	}else{
		get_template_part('loop-blog');
	}			


 ?>

<!-- 投稿ここから -->
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<!-- /投稿ここまで -->

<?php get_footer(); ?>
<!-- /page.php -->
