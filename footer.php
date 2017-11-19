<!-- footer.php -->
<?php if (!is_front_page()): ?>
			<br clear="all">
			</div>
			<!-- / #contentArea -->
			<div class="goHome"><p><a href="<?php echo home_url(); ?>">トップページに戻る</a></p></div> 
		</div>
		<!-- / #right_side -->
<?php endif; ?>
		<div class="footerNavi">
			<h3><a href="<?php echo home_url(); ?>/recruit/">テキスト</a></h3>
			<ul>
				<li><a href="###########" target="_blank">テキスト</a></li>
			
				<li><a href="<?php echo home_url(); ?>/######/">テキスト</a></li>
			</ul>
		</div>
		<!-- / .footerNavi -->
		<div class="copyright">
		<?php get_template_part('none'); ?>
		</div>
<?php wp_footer(); ?>
</body>
</html>