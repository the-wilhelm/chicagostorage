<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
		<meta name="MobileOptimized" content="width">
		
		<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
		
		<link media="all" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fancybox.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css"  />
		<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/theme.css"  />
		
		<script type="text/javascript">
			var pathInfo = {
				base: '<?php echo get_template_directory_uri(); ?>/',
				css: 'css/',
				js: 'js/',
				swf: 'swf/',
			}
		</script>
		
		<?php if ( is_singular() ) wp_enqueue_script( 'theme-comment-reply', get_template_directory_uri()."/js/comment-reply.js" ); ?>
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<header id="header">
			<?php if ( $phone = get_field('phone','options') ): ?>
				<a href="tel:<?php  echo preg_replace("/[^\d]/",'',$phone); ?>" class="call"><i class="icon-phone"></i> <?php _e('Call now','chicagostorage'); ?></a>
			<?php endif; ?>
			<strong class="slogan"><i class="icon-lock2"></i> <span><?php bloginfo('description'); ?></span></strong>
			<strong class="logo"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></strong>
		</header>
		<main role="main" id="main">
			<div id="content">
