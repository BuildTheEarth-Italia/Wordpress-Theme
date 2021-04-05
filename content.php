<div class="grass"></div>
<article class="card postContent">
    <h2 class="post-title"><?php the_title(); ?></h2>
    <div class="post-content"><?php the_content();?></div>
    <?php
    $link = get_the_author_meta('url');
    $name = get_the_author_meta('display_name') ; 	
	if($name == "") {
		$name = get_the_author_meta('first_name') . " " .get_the_author_meta('last_name');
	}
	if($name == "") {
		$name = get_the_author_meta('nickname');
	}
	$description = get_the_author_meta('description');
	

    if(empty($link)) {
        echo '<div class="post-author">';
    } else {
        echo '<a href="' . $link . '" class="post-author" title="Link al profilo di ' . $name . '">';
    }
        echo get_avatar(get_the_author_meta('ID'), 80, 'retro', 'Foto profilo di ' . $name, ['class' => 'author-img', 'loading' => 'lazy']);?>
		
		<div class="author-info">
			<span class="author-name"><?=$name?></span>
			<span class="author-description"><?=$description?></span>
		</div>

    <?php if(empty($link)) {
        echo '</div>';
    } else {
        echo '</a>';
    }
    
    ob_start();
    the_category();
    echo str_replace('<li>', '<li class="post-category custom-background lax" data-lax-bg-pos-y="(vh*1.02) -20, (vh*1.72) 0">', ob_get_clean());
    ?>
</article>