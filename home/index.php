
	<?php 
		include_once('header.php');

		// 查询文章,分类，评论信息，用于文章列表
		$ar_ca_info = get_article_cate();
		// show($ar_ca_info);

		// 查询评论条数
		$comment_num = get_com_num();

		// 查询评论，文章,用户信息，用于最新留言
		$cm_ar_info = get_cm_art_user(5);
		// show($cm_ar_info);		

		// 随机获取文章
		$rand_article = get_rand_ar(3);

		// 统计文章数量
		$ar_num = count_article_num();
		// 评论数量
		$cm_num = count_com_num();
		// 运行天数计算
		$time =	count_run_time();
		// 上次更新时间
		$last_update = get_last_update_time();

	 ?>
<!-- 中部  -->

	<div id="main-content" class="container">
		<div id="loading-bar">
			<div style="width: 100%; display: none;"></div>
		</div>
		

		<!--中左侧-->
		<div class="content" style="border-right-width: 1px; border-right-style: solid; border-right-color: rgb(221, 221, 221);">
			<div class="post-listing">
	<?php foreach ($ar_ca_info as $k => $v) {  ?>

				<article class="item-list">
					<h2 class="post-box-title">
						<a target="_blank" href="" title="<?php echo $v['article_title'] ?>" rel="bookmark"><?php echo $v['article_title'] ?>
						</a>
					</h2>
					<p class="post-meta">
						<span><?php echo date("Y-m-d H:i:s",$v['article_create_time']); ?></span>	
						<span><a href="" rel="category tag"><?php echo $v['cat_name'] ?></a></span>
						<span>已被阅读<?php echo  $v['article_read_num']?>次</span>
						<span><a href="">
							<?php 
								if( empty($comment_num[$v['article_id']]) ){ 
									echo 0; 
								}else{
									echo $comment_num[$v['article_id']];
								}
							?> 条评论
							</a>
						</span>
					</p>
					<div class="post-thumbnail">
						<a target="_blank" href="http://www.ipeld.net/archives/8841.html" title="显示“快速访问” 的固定链接" rel="bookmark">
							<img width="300" height="300" src="./js/win10-quick-access-01-300x300.png" class="attachment-thumbnail wp-post-image" alt="win10-quick-access-01" original="http://www.ipeld.net/wp-content/uploads/2015/08/win10-quick-access-01-300x300.png">				
							<span class="overlay-icon"></span>
						</a>
					</div><!-- post-thumbnail /-->
					<div class="entry">
						<p>
							<?php echo mb_substr( strip_tags($v['article_content']) ,0,160,"UTF8" )?>		
							<a target="_blank" class="more-link" href="">阅读全文 »</a>
						</p>
					</div>
					<div class="clear"></div>
				</article><!-- .item-list -->

	<?php   } ?>

			</div>



			<!-- 分页显示-->
			<div class="pagination">
				<span class="pages">当前第 1 页，共 39 页</span>
				<span class="current">1</span>
				<a href="http://www.ipeld.net/page/2" class="page" title="2">2</a><a href="http://www.ipeld.net/page/3" class="page" title="3">3</a>
				<a href="http://www.ipeld.net/page/4" class="page" title="4">4</a><a href="http://www.ipeld.net/page/5" class="page" title="5">5</a>		<span id="tie-next-page">
					<a href="http://www.ipeld.net/page/2">»</a>					
				</span>
				<a href="http://www.ipeld.net/page/10" class="page" title="10">10</a>
				<a href="http://www.ipeld.net/page/20" class="page" title="20">20</a>
				<a href="http://www.ipeld.net/page/30" class="page" title="30">30</a>
				<span class="extend">...</span><a href="http://www.ipeld.net/page/39" class="last" title="最后一页 »">最后一页 »</a>	
			</div>



			
		</div><!-- .content /-->



		<!--中右侧-->
		<aside id="sidebar">

			<!--中右最新评论-->
			<div id="enhancedtextwidget-21" class="widget widget_text enhanced-text-widget">
				<div class="widget-top"><h4>最新评论</h4>
					<div class="stripe-line"></div>
				</div>
				<div class="widget-container">
					<div class="textwidget widget-text">
						<ul id="efanyh_recentcomments">
							<?php foreach ($cm_ar_info as $kk => $vv) {  ?>
							<li>
								<div class="erc_head">
									<span class="erch_name" title="<?php echo $vv['article_title'] ?>"><?php echo $vv['username'] ?></span>
									<span class="erch_date"><?php echo date("Y-m-d H:i:s",$vv['cm_time']) ?></span>
								</div>
								<div class="erc_body">
									<a class="ercb_content" href="" target="_blank"><?php echo $vv['cm_content'] ?></a>
								</div>
							</li>
							<?php } ?>
							
						</ul>
						<style>
							#efanyh_recentcomments li {
								padding: 8px 0px;
								border-bottom: 1px dashed #DDD;
							}
							#efanyh_recentcomments li:first-child {
								padding-top: 3px;
							}
							#efanyh_recentcomments li:last-child {
								border-bottom: none;
							}
							#efanyh_recentcomments li .erc_head {
								padding-bottom: 1px;
							}
							#efanyh_recentcomments li .erc_head .erch_name {
								color: #81bd00;
								cursor: default;
							}
							#efanyh_recentcomments li .erc_head .erch_date {
								float: right;
								font-size: 0.9em;
								color: #AAA;
								cursor: default;
							}
						</style>
					</div>
				</div>
			</div><!-- .widget /-->



			<!--中右随机文章-->
			<div id="enhancedtextwidget-22" class="widget widget_text enhanced-text-widget">
				<div class="widget-top">
					<h4>随机文章</h4>
					<div class="stripe-line"></div>
				</div>
				<div class="widget-container">
					<div class="textwidget widget-text">
						<ul id="efanyh_randomposts">
							<?php foreach ($rand_article as $col => $row) {?>
							<li>
								<a href="<?php echo $row['article_id'] ?>" title="查看文章《<?php echo $row['article_title'] ?>》" target="_blank"><?php echo $row['article_title'] ?></a>
							</li>
							<?php } ?>

						</ul>
						<style>#efanyh_randomposts li {white-space: nowrap;}</style>
					</div>
				</div>
			</div><!-- .widget /-->



			<!--中右博客统计-->
			<div id="enhancedtextwidget-23" class="widget widget_text enhanced-text-widget">
				<div class="widget-top">
					<h4>博客统计</h4>
					<div class="stripe-line"></div>
				</div>
				<div class="widget-container">
					<div class="textwidget widget-text">
						<ul id="efanyh_blogstats">
							<li><span>文章数量： <?php echo $ar_num; ?> 篇</span></li>
							<li><span>评论数量： <?php echo $cm_num ?> 条</span></li>
							<li><span>成立时间： <?php echo date("Y-m-d",CREATE_TIME) ?></span></li>
							<li><span>运行天数： <?php echo $time['year']."年";
														echo $time['month']."月";
														echo $time['day']."日";?></span></li>
							<li><span>最后更新： <?php echo date("Y-m-d H:s",$last_update);?></span></li>
						</ul>
					</div>
				</div>
			</div><!-- .widget /-->
			<div id="sidebar_rollbox_1" class="sidebar_rollbox" style="display: none; position: fixed; width: 310px;"></div>
			<div id="rollstart"></div>
		</aside>	

		<div class="clear"></div>
	</div><!-- .container /-->


	<?php 
		include_once('footer.php');

	 ?>