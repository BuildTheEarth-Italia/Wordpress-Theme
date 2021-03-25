<?php
//stampo header
get_header();

//stampo posts
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'mini-post', get_post_format() );
	}
}
	
//stampo footer
get_footer();
?>