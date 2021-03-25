<?php
	//stampo header ma rimuovo titolo del sito
	ob_start();
	get_header();
	echo str_replace('bigHeader', '', ob_get_clean());

	//stampo posts
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', get_post_format() );
		}
	}

	
	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	//COMMENTI DISATTIVATI PER DEFAULT!
	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


	/*/se commenti aperti stampo form
	if ( comments_open() || get_comments_number() ) {?>
		<div class='card postComments'>
			<?php
				//prendo testo commenti
				ob_start();
				comments_template();
				$comments =  ob_get_clean();

				//formatto il testo
				$comments = str_replace('-author vcard', '-meta', $comments);
				$comments = str_replace('<cite class="fn">', '', str_replace('</cite>', '', $comments));
				$comments = preg_replace('/<span class="says">([0-z :+,.?\-_@#]+)<\/span>/mi', '', $comments);
				$comments = preg_replace('/<a href="http(s?):\/\/([\/0-z\- #_?;&=.]+)">([0-z :\/\\\-_\t\n]+)<\/a>/mi', 'il ${3}', $comments);
				$comments = preg_replace('/<\/div>([\n\t]*)<div class="comment-meta commentmetadata">/mi', '', $comments);
				$comments = str_replace('(Modifica)', '<span class="dashicons dashicons-edit"></span>', $comments);
				
 
 				//stampo output
				echo $comments;
			?>
		</div>
	<?php
	}*/
	
	//stampo footer
	get_footer();
	?>