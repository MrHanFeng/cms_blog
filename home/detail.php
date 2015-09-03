<?php 
	include_once('header.php');
	
	// 获得特定文章所有信息
	$article = get_article($_GET['article_id']);

	// 获得该文章评论信息
	$comment = get_comment($_GET['article_id']);

	if(@$_POST['submit']){
		array_pop($_POST);
		// show($_POST);exit;
		$re = insert_comment($_POST);
		if($re){
			echo "<script>alert('插入成功');</script>";
		}else{
			echo "<script>alert('插入失败')</script>";
		}
	}
 ?>


<div id="main-content" class="container">
	<div id="loading-bar"><div style="width: 100%; display: none;"></div></div>
	<div class="content">
		<article class="post-listing post-8531 post type-post status-publish format-standard has-post-thumbnail hentry category-software-recommendation tag-everything tag-listary tag-871 tag-829">
			<div class="post-inner">
				<h1 class="name post-title entry-title" itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Thing">
					<span itemprop="name">
						<?php echo $article['article_title'] ?>
					</span>
				</h1>
					<p class="post-meta">
						<span><?php echo date("Y-m-d H:i:s",$article['article_create_time'] )?></span>	
						<span>分类：
							<a href="" rel="category tag">
								<?php echo $cate[$article['article_category_id']] ?>
							</a>
						</span>
						<span>已被阅读 <?php echo $article['article_read_num'] ?></span>
						<span><a href="#comments"><?php echo count($comment) ?>条评论</a></span>
					</p>
					<div class="clear"></div>
					<div class="entry">
						

					<?php echo $article['article_content']; ?>


					</div><!-- .entry /-->
					<span style="display:none"></span>				
					<span style="display:none" class="updated">2015-01-18</span>
					<div style="display:none" class="vcard author" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
						<strong class="fn" itemprop="name"><a href="" title="由eFanchy发布" rel="author">eFanchy</a></strong>
					</div>
			</div><!-- .post-inner -->
		</article><!-- .post-listing -->

		<p class="post-tag">标签：
			<a href="" rel="tag">Everything</a> 
			<a href="" rel="tag">Listary</a> 
			<a href="" rel="tag">效率提升</a> 
			<a href="" rel="tag">软件推荐</a>
		</p>
					



		<div class="post-navigation">
			<div class="post-previous"><a href="http://www.ipeld.net/archives/53.html" rel="prev"><span>上一篇：</span> 有哪些提高效率的习惯？</a></div>
			<div class="post-next"><a href="http://www.ipeld.net/archives/7117.html" rel="next"><span>下一篇：</span> 实用的 Chrome 扩展程序整理与推荐</a></div>
		</div><!-- .post-navigation -->
		


		<div id="comments">
		<?php if (!empty($comment)){ ?>
			<h3 id="comments-title"><?php echo count($comment) ?>条评论</h3>
			

			<ol class="commentlist">	
			<?php foreach ($comment as $kc => $vc): ?>
				<li id="comment-<?php echo $vc['cm_id'] ?>">
					<div class="comment even thread-even depth-1 comment-wrap">
						<div class="comment-avatar">
							<img alt="" src="images/user.png" class="avatar avatar-45 photo" height="45" width="45" style="display: inline;">
						</div>
						<div class="author-comment">
							<cite class="fn"><a href="<?php echo $vc['cm_url'] ?>" rel="external nofollow" class="url" target="_blank" title="进入<?php echo $vc['cm_nickname'] ?>的网站 <?php echo $vc['cm_url'] ?>"><?php echo $vc['cm_nickname'] ?></a></cite>				
							<div class="comment-meta commentmetadata">	<?php echo date("Y年m月d日 H时i分s秒",$vc['cm_time']) ?></div><!-- .comment-meta .commentmetadata -->
						</div>
						<div class="clear"></div>	
						<div class="comment-content">
							<p><?php echo  $vc['cm_content'] ?></p>
						</div>
						<div class="reply">
							<a rel="nofollow" class="comment-reply-link" href="" onclick="return addComment.moveForm( &quot;comment-5645&quot;, &quot;5645&quot;, &quot;respond&quot;, &quot;8531&quot; )" aria-label="回复给<?php echo $vc['cm_nickname'] ?>">
								回复
							</a>
						</div><!-- .reply -->
					</div><!-- #comment-##  -->
				</li><!-- #comment-## -->
			<?php endforeach ?>
			</ol>
			

	<?php }else{ ?>
			<h1>暂无评论</h1>

	<?php } ?>
			<div id="respond" class="comment-respond">
				<h3 id="reply-title" class="comment-reply-title">
					发表评论 
				</h3>
				<form action="" method="post" >
					<p class="comment-notes">您的邮箱地址将不会被公开</p>
					<p class="comment-notes-anonymous" style="display: none;">
						当前为匿名评论，
						<span id="i-wanna-be-real">
							留下你的大名？
						</span>
					</p>							
					<p class="comment-form-author">
						<br><label for="author">
							昵称
						</label>
						<input id="author" name="cm_nickname" type="text" value="" size="30" tabindex="1">
					</p>

					<p class="comment-form-email">
						<br><label for="email">邮箱</label> 
						<input id="email" name="cm_email" type="text" value="" size="30" tabindex="2">
					</p>
					<p class="comment-form-url">
						<br><label for="url">网站</label>
						<input id="url" name="cm_url" type="text" value="" size="30" tabindex="3">
					</p>
					<p class="comment-form-comment">
						<br><label for="comment">评论</label> 
						<textarea name="cm_content" id="" cols="30" rows="10"></textarea>
<!-- 					</p> -->

					<input type="hidden" name="cm_arid" value="<?php echo $article['article_id'] ?>">
					<input type="hidden" name="cm_ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">
					<input type="hidden" name="cm_agent" value="<?php echo $_SERVER['HTTP_USER_AGENT']  ?>">
					<?php if (@$_SESSION['user_id']): ?>
						<input type="hidden" name="cm_user_id" value="<?php echo $_SESSION['user_id'] ?>">
					<?php endif ?>						
					<br><p class="form-submit">
						<input type="submit"  value= " " name="submit" style="background-image:url('./images/submit.png');width:175px;height:30px;">
					</p>
				</form>



			</div><!-- #respond -->
			
		</div><!-- #comments -->
	
	</div><!-- .content -->
</div>




<?php 

	include_once('footer.php');
 ?>