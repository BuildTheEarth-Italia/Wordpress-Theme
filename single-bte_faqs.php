<?php
// Stampo header
get_header();

// Importo stile
wp_enqueue_style('bte_faq_style');

// Prendo il post corrente
global $post;

// Costruisco l'autore
$name = get_the_author_meta('display_name', $post->post_author);
$link = get_the_author_meta('url', $post->post_author);

if (!empty($link) && $name != '') {
    $name = '<a href="' . $link . '" class="author-name" rel="author" title="Link al profilo di ' . $name . '">' . $name . '</a>';
}

?>

<div class="grass"></div>
<article class="card postContent">
    <h1 class="post-title"><?php the_title(); ?></h1>
    <div class="post-author">
        di <?= $name ?>
    </div>
    <div class="post-content"><?php the_content(); ?></div>
    <div class="need-more-help">
        <h1 class="title">Hai ancora bisogno di aiuto?</h1>
        <p class="join-discord">Entra nel nostro server <a href="https://discord.com/invite/dMahHCH" title="Link al server Discord" rel="nofollow">Discord</a> per ricevere ulteriore assistenza!</p>
    </div>
</article>

<?php
// Stampo footer
get_footer();
?>