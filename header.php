<?php
//urlの取得
global $url_first;
global $url_second;
global $url_third;
global $pageid;
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
<meta charset="UTF-8" />
<?php if (is_front_page()) { ?>
<title>会社名</title>
<?php }else{ ?>
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<?php } ?>
<link rel="shortcut icon" href="/images/common/favicon.ico"> 
<link rel="stylesheet" type="text/css" href="/style/common.css"/>
<link rel="stylesheet" type="text/css" href="/style/growvance.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/scripts/common.js"></script>
<?php if (is_front_page()) { ?>
<!-- bxslider -->
<link href="/scripts/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css" media="all" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type='text/javascript' src='/scripts/bxslider/jquery.bxslider.js'></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#TopSlider').bxSlider({
	    auto:true,
		controls:false,
	    minSlides: 1,
	    maxSlides: 1,
		moveSlides:1,
	    slideWidth: 810,
	    slideMargin: 2
	});
});
</script>
<?php } ?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body id="top">
<div id="wrap">
	<div id="mainArea">
		<div id="leftSide">
			<div class="globalNavi">
				<div class="logo"><a href="<?php echo home_url(); ?>/"><img src="/image/common/logo.png" alt="＠＠＠＠＠" /></a></div>
				<ul>
					<li><a href="<?php echo home_url(); ?>/company/"><img src="/image/common/gnavi_01.jpg" alt="＠＠＠＠＠" /></a></li>
					<li><a href="<?php echo home_url(); ?>/service/"><img src="/image/common/gnavi_02.jpg" alt="＠＠＠＠＠" /></a></li>
					<li><a href="<?php echo home_url(); ?>/compliance/"><img src="/image/common/gnavi_03.jpg" alt="＠＠＠＠＠" /></a></li>
					<li><a href="<?php echo home_url(); ?>/policy/"><img src="/image/common/gnavi_04.jpg" alt="＠＠＠＠＠" /></a></li>
					<li><a href="<?php echo home_url(); ?>/recruit/"><img src="/image/common/gnavi_05.jpg" alt="＠＠＠＠＠" /></a></li>
					
				</ul>
			</div>
			<!-- / .globalNavi -->
			<?php get_template_part('sub_navi', $url_first ); ?>
		</div>
		<!-- / #left_side --> 
		<div id="rightSide">
			<?php if(!is_home()){ ?>
			<h1 class="page_title"><img src="/image/common/page_title_<?php echo $url_first;?>.jpg" alt="＠＠＠＠＠" /></h1>
			<div id="contentArea">
			<?php } ?>
