<?php
/* loop.php */
?>
<!-- loop.php -->
<?php while ( have_posts() ) : the_post();//ループの開始 ?>


	<!-- 各呼び出し　-->
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


	<!-- newsパターン -->
	<dl>
		<dt><?php the_time('Y/m/d'); ?><?php add_new(get_the_time('U'),2); ?></dt>
		<dd>
		<?php if(get_field('link')) {?>
		
		<a href="<?php the_field('link') ?>" target="_blank"><?php the_field('news'); ?></a>
		
		<?php }else{ ?>
		<?php the_field('news'); ?>
		<?php } ?>
		
		</dd>
	</dl>
	
	
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



<?php endwhile; ?>
<!-- /loop.php -->