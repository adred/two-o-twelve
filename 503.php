<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<title><?php bloginfo('name'); ?> &raquo; <?php echo $this->g_opt['mamo_pagetitle']; ?></title>
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/images/shortcut-icon.png" />
	
	<!-- THIS FUNCTION AUTOMATICALLY GRABS "style.css" -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/globals.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/page.css" type="text/css" media="screen" />
	
	<!-- THIS FUNCTION GETS THE TEMPLATES DIRECTORY, AND SHOULD BE USED FOR ALL IMAGES AND FILE REFERENCES INSTEAD OF ABSOLUTE OR RELATIVE PATHS -->
	<script src="<?php bloginfo('template_directory'); ?>/javascripts/css-browser-selector.js" type="text/javascript"></script>
		
</head>

<body>

	<?php echo $this->mamo_template_tag_message(); ?>

</body>
</html>
