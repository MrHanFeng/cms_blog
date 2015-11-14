<?php 
	include_once "function.php";
	// checkLogin();

	// 查询分类菜单栏
	$cate_info = get_category_mes();
	// 转换成下标为分类ID的一维数组
	foreach ($cate_info as $k => $v) {
		$cate[$v['cat_id']] = $v['cat_name'];
	}


 ?>




<!DOCTYPE html>
<html lang="zh-CN" prefix="og: http://ogp.me/ns#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<title>峰扬起航的博客</title>
	<script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"http:\/\/s.w.org\/images\/core\/emoji\/72x72\/","ext":".png","source":{"concatemoji":"http:\/\/www.ipeld.net\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.3"}};
			!function(a,b,c){function d(a){var c=b.createElement("canvas"),d=c.getContext&&c.getContext("2d");return d&&d.fillText?(d.textBaseline="top",d.font="600 32px Arial","flag"===a?(d.fillText(String.fromCharCode(55356,56812,55356,56807),0,0),c.toDataURL().length>3e3):(d.fillText(String.fromCharCode(55357,56835),0,0),0!==d.getImageData(16,16,1,1).data[0])):!1}function e(a){var c=b.createElement("script");c.src=a,c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g;c.supports={simple:d("simple"),flag:d("flag")},c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.simple&&c.supports.flag||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
	</script>
	<script src="./js/wp-emoji-release.min.js" type="text/javascript"></script>
	<style type="text/css">
		img.wp-smiley,
		img.emoji {
			display: inline !important;
			border: none !important;
			box-shadow: none !important;
			height: 1em !important;
			width: 1em !important;
			margin: 0 .07em !important;
			vertical-align: -0.1em !important;
			background: none !important;
			padding: 0 !important;
		}
	</style>
	<link rel="stylesheet" id="tie-style-css" href="./css/style.css" type="text/css" media="all">
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/jquery-migrate.min.js"></script>
	<link rel="stylesheet" href="./css/highslide.css" type="text/css">
	<script type="text/javascript" src="./js/highslide-with-gallery.packed.js"></script>
	<script type="text/javascript">
	    hs.graphicsDir = "http://sypopo.com/wp-content/plugins/auto-highslide/highslide/graphics/";
	    hs.outlineType = "rounded-white";
	    hs.dimmingOpacity = 0.8;
	    hs.outlineWhileAnimating = true;
	    hs.showCredits = false;
	    hs.captionEval = "this.thumb.alt";
	    hs.numberPosition = "caption";
	    hs.align = "center";
	    hs.transitions = ["expand", "crossfade"];
	    hs.addSlideshow({
	        interval: 5000,
	        repeat: true,
	        useControls: true,
	        fixedControls: "fit",
	        overlayOptions: {
	            opacity: 0.75,
	            position: "bottom center",
	            hideOnMouseOut: true
			}
		});
	</script>

	<script type="text/javascript">
		/* <![CDATA[ */
		var tievar = {'go_to' : '前往...'};
		var tie = {"ajaxurl":" wp-admin/admin-ajax.php" , "your_rating":"您给出的评级："};
		/* ]]> */
	</script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<link rel="stylesheet" href="./css/base.css">
	<link rel="stylesheet" id="custom-style-css" href="./css/custom-style.css" type="text/css" media="all">
	<script type="text/javascript" src="./js/comments-ajax.js"></script>
	<script type="text/javascript" src="./js/jquery.lazyload.js"></script>
	<script type="text/javascript">
		// Delay Image
		jQuery(function($) {
		$("img").lazyload({
		placeholder : " wp-content/themes/sahifa/images/grey.gif",
		effect : "fadeIn",
		threshold : 200
		});
		});
	</script>
</head>



<body id="top" class="home blog">
	<div id="float-toolbar">
		<div>
			<a href="<?php echo HOME_PATH ?>">
				<span>首页</span>
			</a>
		</div>
		<div>
			<a href="<?php echo HOME_PATH."log/login.php" ?>">
				<span>登录</span>
			</a>
		</div>
	</div>
	<div class="background-cover"></div>
	<header id="theme-header" class="theme-header">
		<div class="top-nav">
			<div class="top-menu">
				<ul id="menu-%e9%a1%b6%e9%83%a8%e5%af%bc%e8%88%aa" class="menu">
				<?php if(empty($_SESSION['user_id'])){ ?>
					<li id="menu-item-3325" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3325">
						<a href="<?php echo HOME_PATH."log/login.php" ?>" target="_blank">登录</a>
					</li>
					<li id="menu-item-3324" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3324">
						<a href="<?php echo HOME_PATH."log/register.php" ?>" target="_blank">注册</a>
					</li>
				<?php }else{ ?>
					<li id="menu-item-3325" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3325">
						<a href="" target="_blank"><?php echo $_SESSION['user_email'] ?></a>
					</li>
					<li id="menu-item-3324" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3324">
						<a href="<?php echo HOME_PATH."log/dologin.php?flag=logout" ?>" >退出</a>
					</li>
				<?php } ?>
					<li id="menu-item-8608" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-8608">
						<a href="" target="_blank">订阅本站</a>
					</li>
				</ul>
			</div>

			<!--搜索-->
			<div class="search-block">
						<form method="post" id="searchform" action="">
							<button class="search-button" type="submit" value="搜索"></button>	
							<input type="text" id="s" name="search" value="搜索..." onfocus="if (this.value == &#39;搜索...&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;搜索...&#39;;}">
						</form>
			</div><!-- .search-block /-->
		</div><!-- .top-menu /-->
			
		<div class="header-content">
			<div class="logo">
				<h1>
					<a title="峰扬起航" href="">
						<img src="./images/logo.png" alt="峰扬起航" original=" wp-content/uploads/2013/03/logo.png">
						<strong>峰扬起航 关注前端开发和个人能力提升</strong>
					</a>
				</h1>			
			</div><!-- .logo /-->
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var retina = window.devicePixelRatio > 1 ? true : false;
					if(retina) {
				       	jQuery('#theme-header .logo img').attr('src', ' wp-content/uploads/2013/03/logo_2x.png');
				       	jQuery('#theme-header .logo img').attr('width', '388');
				       	jQuery('#theme-header .logo img').attr('height', '89');
					}
				});
			</script>
			<div class="clear"></div>
		</div>	
		<nav id="main-nav" style="background:black;">
			<div class="container"  >
				<div class="main-menu" >
					<ul id="menu-%e4%b8%bb%e5%af%bc%e8%88%aa%e8%8f%9c%e5%8d%95" class="menu">
						<li id="menu-item-30" class="menu-item  menu-item-type-custom  menu-item-object-custom  current-menu-item  current_page_item  menu-item-home" style="background-image: url('./images/home.png')">
							<a title="进入首页" href="<?php echo  HOME_PATH?>">首页</a>
						</li>
						<?php  foreach ($cate_info as $k => $v) { ?>
						<li id="menu-item-5368" class="menu-item  menu-item-type-taxonomy  menu-item-object-category">
							<a href="<?php echo HOME_PATH."index.php?cat_id=$v[cat_id]&action=second" ?>"><?php echo $v['cat_name'] ?></a>
						</li>
						<?php } ?>
					</ul>
					
				</div>	<!-- end main-menu-->
				<div >
				<a href="" class="random-article tieicon-shuffle ttip" original-title="随机文章" style="background-image:url('images/random.png');float:right;"></a>
				</div>									
			</div>
		</nav><!-- .main-nav /-->
	</header><!--#header--> 
	

