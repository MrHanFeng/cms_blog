
<?php 
	$link_info =get_link_info();

 ?>


	<!--尾部-->
	<footer id="theme-footer">

		<div id="footer-widget-area" class="footer-1c">
			<div id="footer-first" class="footer-widgets-box">
				<div id="linkcat-305" class="footer-widget widget_links">
					<div class="footer-widget-top">
						<h4>友情链接</h4>
					</div>
					<div class="footer-widget-container">
						<ul class="xoxo blogroll">
							<?php foreach ($link_info as $key => $v): ?>
								
							<li>
								<a href="<?php echo $v['link_url'] ?>" title="<?php echo $v['link_introduce'] ?>" target="_blank"><?php echo $v['link_name'] ?></a>
							</li>

							<?php endforeach ?>
						</ul>
					</div>
				</div><!-- .widget /-->
			</div>
			<div id="footer-second" class="footer-widgets-box"></div><!-- #second .widget-area -->
		</div><!-- #footer-widget-area -->
		<div class="clear"></div>
	</footer><!-- .Footer /-->
				
	<div class="clear"></div>

	<div class="footer-bottom">
		<div class="container">
			<div class="alignright">
				Copyright © 2012 - 2015 峰扬起航. All Rights Reserved.		<br>
			<center>本网站仅供个人学习测试，非商业行为</center>
			</div>
			<div class="alignleft">
				<div style="display: none">
					<script>
					var _hmt = _hmt || [];
					(function() {
					  var hm = document.createElement("script");
					  hm.src = "//hm.baidu.com/hm.js?331974da47f0467b982a9bd2e6d7b79f";
					  var s = document.getElementsByTagName("script")[0]; 
					  s.parentNode.insertBefore(hm, s);
					})();
					</script>
				</div>		
			</div>
			<div class="clear"></div>
		</div><!-- .Container -->
	</div><!-- .Footer bottom -->
	<div id="topcontrol" class="tieicon-up-open" title="返回顶部"></div>
	<script type="text/javascript" src="./js/cookie.min.js"></script>
	<script type="text/javascript" src="./js/custom-footer-js.js"></script>
	<script type="text/javascript" src="./js/page_loading.js"></script>

	<script>
	jQuery(document).ready(function($){
	// 顶部导航的链接在新标签页打开
	$('.theme-header .top-menu .menu li a, .widget_rss a, .blogroll li a').attr('target', '_blank');
	});
	</script>
	<script type="text/javascript" src="./js/tie-scripts.js"></script>
</body>
</html>