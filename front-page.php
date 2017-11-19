<?php include_once 'conf.php'; ?>
<?php get_header(); ?>
			<ul id="TopSlider" class="slider">
				<?php
					//呼び出すブログの条件設定
					//query_posts('67');

					//TOPの固定ページ読み込み
					$query_option = array('page_id' => 67,);
					query_posts($query_option);
					get_template_part('loop','slider');
					wp_reset_query();
				?>
			</ul>
		</div>
		<!-- / #right_side -->

		<article id="news">
			<h2 class="news_title"><img src="/image/top/top_news.jpg" alt="ニュース＆トピックス" /></h2>
			<div class=" news_newsBox">
				<?php
					//呼び出すブログの条件設定
					$query_option = array(
							'post_type' => 'news',
							'posts_per_page' => 200,
						);
					query_posts($query_option);
					get_template_part('loop');
					wp_reset_query();
				?>
			</div>
		</article>


<?php get_footer(); ?>
<!-- /home.php -->