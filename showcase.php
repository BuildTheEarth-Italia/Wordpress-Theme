<?php
/*
Template Name: Showcase delle costruzioni
Template Post Type: page
*/

//stampo header
get_header();

// Importo stile
wp_enqueue_style('bte_showcase_style');

// Prendo le foto dallo showcase
$photos = get_photos_from_bte_theme_showcase();


?>

<div class="grass"></div>
<section class="panel commonPanel showcasePanel" id="showcase">
    <h2 class="post-title"><?php the_title(); ?></h2>
    <div class="post-content"><?php the_content(); ?></div>
    <div class="showcase-wrapper">
    <?php
          //itero liste foto per stamparle in html
          foreach ($photos as $id => $photo) {
            $path = $photo->path;

            // Cambio url in https se la connessione corrente lo è
            if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 || $_SERVER['X-Forwarded-Proto'] == 'https')
               $path = str_replace("http://", "https://", $path);

          ?>
            <figure class="media" data-gallery-id="<?= $id ?>">
              <img class="image" src="<?= $path ?>" class="media" loading="lazy" alt="<?= $photo->title ?> - <?= $photo->description ?>" draggable="false" />
              <figcaption class="caption">
                  <h1 class="image-title"><?= $photo->title ?></h1>
                  <p class="image-description"><?= $photo->description ?></p>
              </figcaption>
            </figure>
          <?php } ?>
    </div>
</section>

<?php get_footer(); ?>