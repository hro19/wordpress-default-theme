<?php include_once 'conf.php'; ?>
<?php get_header(); ?>

<!-- 投稿ここから -->
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<!-- /投稿ここまで -->

<?php get_footer(); ?>
<!-- /page.php -->
