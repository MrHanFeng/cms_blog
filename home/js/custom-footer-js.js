/*
 *		文件名：custom-footer-js.js
 *		文件描述：自定义的 Javascript 脚本，用于实现功能
 *		作者：翼帆远航
 */
 
jQuery(document).ready(function($){



	// 判断是否详情页
	function is_single()
	{
		if ( $('body.single').length > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function is_page()
	{
		if ( $('body.page').length > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
	// 在详情页按下 Tab 键自动跳转到评论框
	if ( $('body.single').length > 0 || $('body.page').length > 0 )
	{
		if ( $('#respond').length > 0 )
		{
			if ( $('body').attr('class').indexOf('logged-in') == -1 )
			{
				$("#respond form p input#author").attr('tabIndex','1');
				$("#respond form p input#email").attr('tabIndex','2');
				$("#respond form p input#url").attr('tabIndex','3');
				$("#respond form p textarea#comment").attr('tabIndex','4');
				$("#respond form p input#submit").attr('tabIndex','5');
			}
			else
			{
				$("#respond form p textarea#comment").attr('tabIndex','1');
				$("#respond form p input#submit").attr('tabIndex','2');
				$("#wpadminbar .screen-reader-shortcut").attr('tabIndex','3');
			}
		}
	}



	// Ctrl + Enter 提交评论
	if ( $("#comment").length > 0 ) {
		document.getElementById("comment").onkeydown = function(moz_ev) {
			var ev = null;
			if (window.event) {
				ev = window.event;
			} else {
				ev = moz_ev;
			}
			if (ev != null && ev.ctrlKey && ev.keyCode == 13) {
				document.getElementById("submit").click();
			}
		}
		$("#respond #submit").attr('value', '发表评论（Ctrl+Enter）');
	}



	// 快捷键
	function do_function_by_keycode()
	{
		var key = event.keyCode;
		var activeElement = document.activeElement.tagName.toLowerCase();
		if ( activeElement != 'input' && activeElement != 'textarea' )	// 在任何输入框内不响应快捷键
		{
			if ( key == '36' )	//	按 Home 键回到首页
			{
				window.location.href = $(".header-content .logo a").attr('href');
				event.returnValue = false;
			}
			else if ( key == '83' )	// 按 s 使搜索框获得焦点
			{
				$(".search-block input#s").focus();
				event.returnValue = false;
			}
			else if ( key == '37' ) // 按 方向左 时
			{
				if ( $(".content article.post .post-inner").length > 0 )	// 在文章页按方向左切换到上一篇文章
				{
					var prevlink = $(".post-navigation .post-previous a").attr('href');
					if ( prevlink != null && prevlink.indexOf('http://') != -1 )
					{
						window.location.href = prevlink;
						event.returnValue = false;
					}
				}
				else if ( $('body.home').length > 0 || $('body.archive').length > 0 || $('body.search').length > 0 )
				{
					var prevlink = $('link[rel="prev"]').attr('href');		// 文章列表页按方向左切换到上一页
					if ( prevlink != null && prevlink.indexOf('http://') != -1 )
					{
						window.location.href = prevlink;
						event.returnValue = false;
					}
				}
			}
			else if ( key == '39' ) // 按 方向右 时
			{
				if ( $(".content article.post .post-inner").length > 0 )	// 在文章页按方向右切换到下一篇文章
				{
					var nextlink = $(".post-navigation .post-next a").attr('href');
					if ( nextlink != null && nextlink.indexOf('http://') != -1 )				
					{
						window.location.href = nextlink;
						event.returnValue = false;
					}
				}
				else if ( $('body.home').length > 0 || $('body.archive').length > 0 || $('body.search').length > 0 )
				{
					var nextlink = $('link[rel="next"]').attr('href');		// 文章列表页按方向右切换到下一页
					if ( nextlink != null && nextlink.indexOf('http://') != -1 )
					{
						window.location.href = nextlink;
						event.returnValue = false;
					}
				}
			}
			else if ( key == '82' )	// 按 R 键时，查看随机文章
			{
				var randomlink = $("a.random-article").attr('href');
				if ( randomlink.indexOf('http://') != -1 )
				{
					window.location.href = randomlink;
					event.returnValue = false;
				}
			}
		}
	}
	
	if ( navigator.userAgent.indexOf('Firefox') == -1 )
	{
		window.onkeydown = function(){ do_function_by_keycode(); }
	}
	
	
	
	// 每隔一段时间保存一次评论草稿
	if ( $('#respond').length > 0 )
	{
		function get_post_id()
		{
			var post_id = '0';
			var classnames = $('body').attr('class').split(" ");
			for ( var i = 0; i < classnames.length; i++ )
			{	
				if ( classnames[i].indexOf('postid-') != -1 )
				{
					post_id = classnames[i];
					break;
				}
			}
			return post_id;
		}
		
		function get_cookie_key()
		{
			return ('efan-sahifaplus-comment-draft-' + get_post_id());
		}
		
		// 向评论框上添加草稿保存提示
		var comment_draft_tips = '<div class="comment-draft-status"></div>';
		$('#respond form p.comment-form-comment').append(comment_draft_tips);
		
		// 写评论时自动保存
		var is_comment_writing = false;
		var auto_save_draft_time = 500;
		var is_draft_restored = false;
		$('#respond form p textarea#comment').focus(function(){
			if ( is_comment_writing == false )
			{
				is_comment_writing = true;
			}
		});
		setInterval(function(){
			if ( is_comment_writing == true )
			{
				var comment_text = '';
				if ( $('#respond form p textarea#comment').val() != '' )
				{
					comment_text = $('#respond form p textarea#comment').val();
				}
				var cookie_key = get_cookie_key();
				cookie.set(cookie_key, comment_text, { expires: 7 });
				if ( $('#respond form p textarea#comment').val() != '' )
				{
					$('.comment-draft-status').text('草稿已保存');
				}
			}
		}, auto_save_draft_time);
		
		// 文章页加载时，自动载入草稿
		var saved_comment_draft = '';
		var cookie_key = get_cookie_key();
		saved_comment_draft = cookie.get(cookie_key);
		if ( saved_comment_draft != '' )
		{
			$('#respond form p textarea#comment').val(saved_comment_draft);
			$('#respond form p textarea#comment').css('color','#515151');
			is_draft_restored = true;
		}
		
		// 提交评论时，清空提示信息
		$('#respond #submit').click(function(){
			$('.comment-draft-status').text('');
			is_comment_writing = false;
			var cookie_key = get_cookie_key();
			cookie.set(cookie_key, '', { expires: 7 });
		});
		
		$('.comment-draft-status').css('color','#81bd00').css('float','right').css('padding-right','40px').css('padding-top','15px');
		
		
	}
	
	
	
	// 评论者链接显示提示信息，并在新标签页打开
	if ( $('body.single').length > 0 || $('body.page').length > 0 )
	{
		if ( $('ol.commentlist').length > 0 )
		{
			$('ol.commentlist div.comment div.author-comment cite.fn a').each(function(){
				$(this).attr('target','_blank');
				$(this).attr('title','进入'+$(this).text()+'的网站 '+$(this).attr('href'));
			});
		}
	}
	
	
	
	// 匿名评论按钮
	if ( $('body.single').length > 0 || $('body.page').length > 0 )
	{
		if ( $('#respond').length > 0 )
		{
			if (cookie.get('sahifa-comment-anonymously') == null)
			{
				cookie.set('sahifa-comment-anonymously','false');
			}
			$('p.comment-form-author label').after('<style> .anonymous-comment { padding-left: 20px; font-size: 0.9em; color: #888; } #i-wanna-be-anonymous:hover, #i-wanna-be-real:hover { text-decoration: underline; cursor: pointer; } .comment-notes-anonymous { font-size: 1.1em; } </style>');
			$('p.comment-form-author label').after('<span class="anonymous-comment">(<span id="i-wanna-be-anonymous">我要匿名评论</span>)</span>');
			$('p.comment-notes').after('<p class="comment-notes-anonymous" style="display: none;">当前为匿名评论，<span id="i-wanna-be-real">留下你的大名？</span></p>');
			
			var input_author = $('input#author').val();
			var input_email = $('input#email').val();
			var input_url = $('input#url').val();
			
			function comment_anonymously()
			{
				$('p.comment-form-author, p.comment-form-email, p.comment-form-url').hide();
				input_author = $('input#author').val();
				input_email = $('input#email').val();
				input_url = $('input#url').val();
				$('input#author, input#email, input#url').val('');
				$('p.comment-notes-anonymous').show();
				$('p.comment-notes').hide();
			}

			function comment_real()
			{
				$('p.comment-form-author, p.comment-form-email, p.comment-form-url').show();
				$('input#author').val(input_author);
				$('input#email').val(input_email);
				$('input#url').val(input_url);
				$('p.comment-notes').show();
				$('p.comment-notes-anonymous').hide();
			}

			$('#i-wanna-be-anonymous').click(function(){
				comment_anonymously();
				$('textarea#comment').focus();
				cookie.set('sahifa-comment-anonymously', 'true');
			});
			
			$('#i-wanna-be-real').click(function(){
				comment_real();
				$('input#author').focus();
				cookie.set('sahifa-comment-anonymously', 'false');
			});

			if (cookie.get('sahifa-comment-anonymously') == 'true')
			{
				comment_anonymously();
			}
		}
	}

	
	
	// 在非详情页加载内容与侧边栏的分界线
	if ( !is_single() && !is_page() )
	{
		if ( $('#sidebar').length > 0 && $('#sidebar').css('display') != 'none' )
		{
			var heightOfContent = $('.content').height();
			var heightOfSidebar = $('#sidebar').height();
			if ( heightOfContent >= heightOfSidebar )
			{
				$('.content').css('border-right','1px solid #DDD');
			}
			else
			{
				$('#sidebar').css('border-left','1px solid #DDD');
			}
		}
	}
	
	
	
	
	/****************************************************************
	 *****	固定侧边栏
	 ****************************************************************/
	
	// 基本的函数
	function is_wpadminbar_exists()
	{
		if ( $("#wpadminbar").length > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	var is_fixed_main_nav_enabled = false;
	
	// 设置一些基本的高度信息
	var paddingTopValue = 7;
	if ( is_fixed_main_nav_enabled == true )
	{
		paddingTopValue += 53;
	}
	if ( is_wpadminbar_exists() == true )
	{
		paddingTopValue += 30;
	}
	
	// offset_additional_value 暂时无用
	var offset_additional_value = 0;
	
	// 判断是否 IE 6
	function is_IE6()
	{
		if ($.browser.msie)
		{
            if ($.browser.version == "6.0")
				return true;
        }
        return false;
	}
	
	if ( $("#sidebar").length > 0 && $("#sidebar").css("display") != "none" )
	{
		// 开始固定侧栏的标记
		$("#sidebar").append('<div id="rollstart"></div>');
		
		// 开始固定侧栏
		if ( ! is_IE6() )
		{
			var rollStart = $('#rollstart');														// 固定从这里开始
			var rollSetValue = $('meta[name="efan_sidebar_rollSet"]').attr('content');				// 从 head 的 meta 信息获取需要固定的侧栏id
			var rollSet = $(rollSetValue);															// 选择要固定的元素
			rollStart.before('<div id="sidebar_rollbox_1" class="sidebar_rollbox"></div>');
			var offset = rollStart.offset();
			var objWindow = $(window);
			var rollBox = rollStart.prev();
			rollSet.clone().prependTo('.sidebar_rollbox');
			rollBox.hide();
			
			objWindow.scroll(function(){
				if ( objWindow.width() > 986 )
				{
					var anmTop = $(document).height() - $(document).scrollTop() - $('.sidebar_rollbox').height() - $('#theme-footer').height() - 118;
					if ( is_wpadminbar_exists() == true )
					{
						anmTop -= 30;
					}
					if ( objWindow.scrollTop() > ( offset.top + offset_additional_value ) )
					{
						if ( anmTop > 0 )
						{
							rollBox.show().stop().animate({
								top: 0,
								paddingTop: paddingTopValue
							}, 0);
						}
						else
						{
							rollBox.show().stop().animate({
								top: anmTop,
								paddingTop: paddingTopValue
							}, 0);
						}
					}
					else
					{
						rollBox.hide().stop().animate({
							top: 0
						}, 0);
					}
				}
				
			});
			
			objWindow.resize(function(){
				if (objWindow.width() < 986)
				{
					rollBox.hide().stop().animate({
						top: 0
					}, 0);
				}
			});
			
		}
		
		// 设置固定盒子的CSS属性
		$("#sidebar .sidebar_rollbox").css('position','fixed').css('width','310px');
	}
	
	
	
	


});
