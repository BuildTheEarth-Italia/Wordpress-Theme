<!DOCTYPE html>
<html lang="<?=get_bloginfo('language')?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?=get_bloginfo( 'description' ); ?>">	
	
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=bloginfo('stylesheet_url')?>">
	
	<?php wp_head();?>
</head>
<body class="lax  <?=join(' ', get_body_class())?>" data-lax-bg-pos-y="0 0, 600 -30">
    <nav class="mainNav lax" data-lax-bg-pos-y="0 0, 600 -30">
        <a href="<?=get_bloginfo('wpurl')?>" rel="home" class="navItem navLogo"><img src="<?=get_site_icon_url(36)?>" alt="Home"/><?=get_bloginfo('name')?></a>
		<?php wp_nav_menu(
                array(
                    'theme_location' => 'header-menu',
                    'container_class' => 'navItem'
                )
            );?>
    </nav>
    <header class="heading bigHeader lax" data-lax-opacity="(vh*0.20) 1, (vh*0.25) 0.8, (vh*0.38) 0" data-lax-translate-y="0 0, (vh*0.25) -15, (vh*0.38) -40">
        <h1><?=get_bloginfo('name')?></h1>
        <h2><?=get_bloginfo('description')?></h2>
    </header>
    <main class="content">
		<img src="<?=get_template_directory_uri()?>/resources/grass-pattern.svg" class="grass"/>
		<div>