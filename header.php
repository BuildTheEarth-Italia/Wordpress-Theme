<!DOCTYPE html>
<html lang="<?= get_bloginfo('language') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= get_bloginfo('description'); ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito&family=Open+Sans:wght@300;400;800&family=Raleway&family=PT+Sans:wght@700&display=swap">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css"> -->
    <link rel="stylesheet" href="<?= bloginfo('stylesheet_url') ?>">

    <?php wp_head(); ?>
</head>

<body class="lax <?= join(' ', get_body_class()) ?>" data-lax-bg-pos-y="0 0, 600 -80">
    <nav class="navbar">
        <a href="<?= get_bloginfo('wpurl') ?>" rel="home" class="brand">
            <img class="logo" height="36" width="36" src="<?= get_site_icon_url(36) ?>" alt="Lugo ufficiale di <?= get_bloginfo('name') ?>" rel="home" />
            <h1 class="name"><?= get_bloginfo('name') ?></h1>
        </a>
        <?php wp_nav_menu(
            array(
                'theme_location' => 'header-menu',
                'container_class' => 'navItem'
            )
        ); ?>
    </nav>
    <main class="root">