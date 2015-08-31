
	<?php 
		include_once('header.php');
		

		// 如果点击了分类栏,输入该分类ID，查询文章
		if(isset($_GET['action']) && $_GET['action']='second' ){
			$cate_id = $_GET['cat_id'];
		}else{
			$cate_id = '-1';
		}


		// 查询文章,分类，评论信息，用于文章列表[分页]
		if(!isset($_GET['page'])){
			$_GET['page'] = '1';
		}
		$arr = get_article_cate(@$_GET['page'],6,$cate_id);
		$ar_ca_info = $arr['info'];
		$page = $arr['page_html'];
		// show($ar_ca_info);

		// 查询评论条数
		$comment_num = get_com_num();

		// 查询评论，文章,用户信息，用于最新留言
		$cm_ar_info = get_cm_art_user(5);
		// show($cm_ar_info);		

		// 随机获取文章
		$rand_article = get_rand_ar(10);

		// 统计文章数量
		$ar_num = count_article_num();
		// 评论数量
		$cm_num = count_com_num(6);
		// 运行天数计算
		$time =	count_run_time();
		// 上次更新时间
		$last_update = get_last_update_time();

		//将分类的二维数组变为已分类ID为KEY的二维数组 
		$cate_arr=array();
		foreach ($cate_info as $key => $value) {
			$cate_arr[$value['cat_id']]=$value;
		}



	 ?>
<!-- 中部  -->

	<div id="main-content" class="container">
		<div id="loading-bar">
			<div style="width: 100%; display: none;"></div>
		</div>

	<!--如果是次级分类的主页面-->
	<?php if (isset($_GET['action']) && $_GET['action']="second") : ?>
		
		<div id="loading-bar"><div style="width: 100%; display: none;"></div></div>
		<div class="page-head">
					<h1 class="page-title"><?php echo $cate_arr[$_GET['cat_id']]['cat_name'] ?>	</h1>
					<div class="stripe-line"></div>
					<div class="clear"></div>
					<div class="archive-meta">
						<p><?php echo $cate_arr[$_GET['cat_id']]['cat_content'] ?></p>
					</div>		
	</div>
	<?php endif ?>



		<!--中左侧-->
		<div class="content" style="border-right-width: 1px; border-right-style: solid; border-right-color: rgb(221, 221, 221);">
			<div class="post-listing">
	<?php 
		if(!empty($ar_ca_info) ){
			foreach ($ar_ca_info as $k => $v) {  ?>

				<article class="item-list">
					<h2 class="post-box-title">
						<a target="_blank" href="<?php  echo HOME_PATH."detail.php?article_id=$v[article_id]" ?>" title="<?php echo $v['article_title'] ?>" rel="bookmark"><?php echo $v['article_title'] ?>
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
						<a target="_blank" href="<?php  echo HOME_PATH."detail.php?article_id=$v[article_id]" ?>" title="显示“快速访问” 的固定链接" rel="bookmark">
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

	<?php   
				}//end foreach
			}else{
				echo "<h1>抱歉，暂无文章,你能把我咋滴</h1>";
			}
	?>

			</div>



			<!-- 分页显示-->
			<div class="pagination">
				<?php echo $page; ?>
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
									<span class="erch_name" title="<?php echo $vv['article_title'] ?>"><?php echo $vv['cm_nickname'] ?></span>
									<span class="erch_date"><?php echo date("Y-m-d H:i:s",$vv['cm_time']) ?></span>
								</div>
								<div class="erc_body">
									<a class="ercb_content" href="<?php echo HOME_PATH."detail.php?article_id=$vv[article_id]#comment-$vv[cm_id]" ?>" target="_blank"><?php echo $vv['cm_content'] ?></a>
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