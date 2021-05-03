<?php

function init_bte_blocks() {
    // Stile blocco di avviso
	wp_register_style('bte_faqs_warn_style', get_template_directory_uri() . '/blocks/faqs/warn/style.css', is_admin() ? array( 'wp-editor' ) : array('dashicons'), null);

	// Script blocco di avviso
	wp_register_script('bte_faqs_warn_script', get_template_directory_uri() . '/blocks/faqs/warn/block.build.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ), null, true);

	register_block_type(
		'bte/faqs-warn', array(
			'style'         => 'bte_faqs_warn_style',
			'editor_script' => 'bte_faqs_warn_script',
		)
	);
}

add_action( 'init', 'init_bte_blocks' );

?>