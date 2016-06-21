<?php

/**
 *
 * @package Maupassant
 * @author naihai
 * @version 0.0.1
 * @link http:/www.zhfsky.com
 */
include_once('naihai_functions.php');
	// 定义主题路径
	define( "THEMEPATH", get_bloginfo('template_directory') );

	// 定义主题版本号
	define( "THEMEVERSION", '1.13' );

	// 添加RSS
	add_theme_support( 'automatic-feed-links' );

	// 定义菜单
	register_nav_menus(
		array(
			'primary' => __('主题菜单')
		)
	);

	// Enqueue style-file, if it exists.
	add_action('wp_enqueue_scripts', 'ms_scripts');
	function ms_scripts() {
		global $wp_scripts;

		wp_enqueue_style('normalize', THEMEPATH . '/css/normalize.css', array(), THEMEVERSION, 'screen');
		wp_enqueue_style('style', get_bloginfo('stylesheet_url'), array(), THEMEVERSION, 'screen');

		wp_register_script( 'html5shiv', 'http://x.papaapp.com/farm1/a571d2/8dda131d/html5shiv.js',array(), '3.7.1');
		$wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );
		wp_enqueue_script('html5shiv');
	}

	// Maupassant's widgets
	function ms_widgets() {
		register_sidebar(array(
			'name' => 'sidebar1',
			'description' => __('主题侧边栏'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		));
	}
	add_action( 'widgets_init', 'ms_widgets' );

	// Pagenavi of archive and index part
	function pagenavi( $p = 5 ) {
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return;
		echo '<ol class="page-navigator">';

		if ( empty( $paged ) ) $paged = 1;
		if ( $paged > 1 ) p_link( $paged - 1, '&laquo; Previous', '&laquo; Previous' );
		if ( $paged > $p + 2 ) echo '<li><span>...</span></li>';
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class='current'><span>{$i}</span></li>" : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo '<li><span>...</span></li>';
		if ( $paged < $max_page ) p_link( $paged + 1,'Next &raquo;', 'Next &raquo;' );

		echo '</ol>';
	}

	function p_link( $i, $title = '', $linktype = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
		echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a></li>";
	}

	function ms_head() {
	?>
		<?php if ( is_home() ) { ?><title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title><?php } ?>
		<?php if ( is_search() ) { ?><title><?php _e('搜索&#34;');the_search_query();echo "&#34;";?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_single() ) { ?><title><?php echo trim(wp_title('',0)); ?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_author() ) { ?><title><?php wp_title(""); ?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_archive() ) { ?><title><?php single_cat_title(); ?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_year() ) { ?><title><?php the_time('Y'); ?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_month() ) { ?><title><?php the_time('F'); ?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_page() ) { ?><title><?php echo trim(wp_title('',0)); ?> - <?php bloginfo('name'); ?></title><?php } ?>
		<?php if ( is_404() ) { ?><title>404 - <?php bloginfo('name'); ?></title><?php } ?>
		<?php
		global $post;
		if (is_home()){
			$keywords = '';
			$description = '';
		}elseif (is_single()){
			$keywords = get_post_meta($post->ID, "keywords", true);
			if($keywords == ""){
				$tags = wp_get_post_tags($post->ID);
				foreach ($tags as $tag){
					$keywords = $keywords.$tag->name.",";
				}
				$keywords = rtrim($keywords, ', ');
			}
			$description = get_post_meta($post->ID, "description", true);
			if($description == ""){
				if($post->post_excerpt){
					$description = $post->post_excerpt;
				}else{
					$description = mb_strimwidth(strip_tags($post->post_content),0,200,'');
				}
			}
		}elseif (is_page()){
			$keywords = get_post_meta($post->ID, "keywords", true);
			$description = get_post_meta($post->ID, "description", true);
		}elseif (is_category()){
			$keywords = single_cat_title('', false);
			$description = category_description();
		}elseif (is_tag()){
			$keywords = single_tag_title('', false);
			$description = tag_description();
		}
		$keywords = trim(strip_tags($keywords));
		$description = trim(strip_tags($description));
		?>
		<meta name="keywords" content="<?php echo $keywords; ?>" />
		<meta name="description" content="<?php echo $description; ?>" />
		<meta name="viewport" content="initial-scale=1.0,user-scalable=no">
		<link rel="shortcut icon" href="<?php bloginfo('url'); ?>/favicon.ico" type="image/x-icon" />
		<?php wp_head();?>
	<?php
	}

	function ms_comment($comment, $args, $depth) {
	   $GLOBALS['comment'] = $comment;
	?>
	   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-author">
					<?php echo get_avatar( $comment, $size = '32'); ?>
					<cite class="fn"><?php printf(__('%s'), get_comment_author_link()) ?></cite>
    			</div>
    			<div class="comment-meta">
					<?php printf(__('%s'), get_comment_date("Y/m/d") ) ?>
            	</div>
    			<div class="comment-content">
    				<p><?php comment_text() ?></p>
    			</div>
    			<div class="comment-reply">
    				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('回复')))) ?>
    			</div>
			</div>
	<?php
	}

	//更换avatar地址
	function get_ssl_avatar($avatar) {
	    $avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"secure.gravatar.com",$avatar);
	    return $avatar;
	}
	add_filter('get_avatar', 'get_ssl_avatar');

	//通过前台不加载语言包来提高博客效率
	add_filter( 'locale', 'wpjam_locale' );
	function wpjam_locale($locale) {
	    $locale = ( is_admin() ) ? $locale : 'en_US';
	    return $locale;
	}

	//仪表盘自定义板块  2016.4.16 by naihai
	function custom_dashboard_help() {
	echo '<p><a href="  ">Ting</a></p>';
	echo '<p><a href="  ">使用说明</a></p>';
	}
	function example_add_dashboard_widgets() {
	    wp_add_dashboard_widget('custom_help_widget', 'Naihai', 'custom_dashboard_help');
	}
	add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );


	// WordPress 后台禁用Google Open Sans字体 自加
	add_filter( 'gettext_with_context', 'wpdx_disable_open_sans', 888, 4 );
	function wpdx_disable_open_sans( $translations, $text, $context, $domain ) {
	if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
	    $translations = 'off';
	  }
	  return $translations;
	}


	//禁用更新代码 自加


add_filter('wp_headers','wpjam_headers',10,2);
function wpjam_headers($headers,$wp){
    if(!is_user_logged_in() && empty($wp->query_vars['feed'])){
        $headers['Cache-Control']   = 'max-age:600';
        $headers['Expires']         = gmdate('D, d M Y H:i:s', time()+600) . " GMT";

        $wpjam_timestamp = get_lastpostmodified('GMT')>get_lastcommentmodified('GMT')?get_lastpostmodified('GMT'):get_lastcommentmodified('GMT');
        $wp_last_modified = mysql2date('D, d M Y H:i:s', $wpjam_timestamp, 0).' GMT';
        $wp_etag = '"' . md5($wp_last_modified) . '"';
        $headers['Last-Modified'] = $wp_last_modified;
        $headers['ETag'] = $wp_etag;

        // Support for Conditional GET
        if (isset($_SERVER['HTTP_IF_NONE_MATCH']))
            $client_etag = stripslashes(stripslashes($_SERVER['HTTP_IF_NONE_MATCH']));
        else $client_etag = false;

        $client_last_modified = empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? '' : trim($_SERVER['HTTP_IF_MODIFIED_SINCE']);
        // If string is empty, return 0. If not, attempt to parse into a timestamp
        $client_modified_timestamp = $client_last_modified ? strtotime($client_last_modified) : 0;

        // Make a timestamp for our most recent modification...
        $wp_modified_timestamp = strtotime($wp_last_modified);

        $exit_required = false;

        if ( ($client_last_modified && $client_etag) ?
                 (($client_modified_timestamp >= $wp_modified_timestamp) && ($client_etag == $wp_etag)) :
                 (($client_modified_timestamp >= $wp_modified_timestamp) || ($client_etag == $wp_etag)) ) {
            $status = 304;
            $exit_required = true;
        }

        if ( $exit_required ){
            if ( ! empty( $status ) ){
                status_header( $status );
            }
            foreach( (array) $headers as $name => $field_value ){
                @header("{$name}: {$field_value}");
            }

            if ( isset( $headers['Last-Modified'] ) && empty( $headers['Last-Modified'] ) && function_exists( 'header_remove' ) ){
                @header_remove( 'Last-Modified' );
            }
            
            exit();    
        } 
    } 
    return $headers;
}

//摘要长度更改
function new_excerpt_length($length) {
    return 60;
}
add_filter('excerpt_length', 'new_excerpt_length');
 
//自定义结尾
function new_excerpt_more($more) {
    global $post;
    return '<p><a href="'.get_permalink($post->ID). '">阅读全文</a></p>';
}
add_filter('excerpt_more', 'new_excerpt_more');





//自定义logo

function my_custom_logo() {
   echo '
      <style type="text/css">
          h1 a { background-image:url('.get_bloginfo('template_directory').'/img/logo.png) !important; }
      </style>
   ';
}
add_action('login_head', 'my_custom_logo');

//自定义登录页面的LOGO链接为首页链接
add_filter('login_headerurl', create_function(false,"return get_bloginfo('url');"));
//自定义登录页面的LOGO提示为网站名称
add_filter('login_headertitle', create_function(false,"return get_bloginfo('name');"));



/* 访问计数 */
function record_visitors()
{
	if (is_singular())
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID)
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1)))
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'record_visitors');
 
/// 函数名称：post_views
/// 函数作用：取得文章的阅读次数
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
}



?>


