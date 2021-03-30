<?php
/* ============================== */
/* 	 	 Foto della galleria 	  */
/* ============================== */
function get_photos_from_bte_theme_showcase($show_hidden = false) {
	global $wpdb;
	
	//nome tabella
	$table_name = $wpdb->prefix . "bte_theme_showcase"; 
	
	//eseguo query
	$photos = $wpdb->get_results( "SELECT * FROM $table_name " . ($show_hidden ? "" : "WHERE `visible` = true") . ";");
	
	//ritorno l'array
	return $photos;
}
function add_photo_to_bte_theme_showcase($id = NULL, $path, $title, $description) {
	global $wpdb;
	
	//nome tabella
	$table_name = $wpdb->prefix . "bte_theme_showcase"; 
	
	//eseguo query
	$wpdb->query($wpdb->prepare("INSERT INTO $table_name (`id`, `path`, `title`, `description` ) VALUES ( %d, %s, %s, %s )", $id, $path, $title, $description));
}
function delete_photo_from_bte_theme_showcase($id) {
	global $wpdb;
	
	//nome tabella
	$table_name = $wpdb->prefix . "bte_theme_showcase"; 
	
	//eseguo query
	$wpdb->delete($table_name, array('id' => $id), array('%d'));
}
function show_photo_of_bte_theme_showcase($id) {
	global $wpdb;
	
	//nome tabella
	$table_name = $wpdb->prefix . "bte_theme_showcase";
	
	//aggiorno db
	$wpdb->update( $table_name, 
		array(
			'visible' => true
		), 
		array(
			'id' => $id
		)
	);
}
function hide_photo_of_bte_theme_showcase($id) {
	global $wpdb;
	
	//nome tabella
	$table_name = $wpdb->prefix . "bte_theme_showcase";
	
	//aggiorno db
	$wpdb->update( $table_name, 
		array(
			'visible' => false
		), 
		array(
			'id' => $id
		)
	);
}


/* ============================== */
/* 	  Cambio custom background 	  */
/* ============================== */
function change_bte_theme_custom_background_cb() {
    ob_start();
    _custom_background_cb();
    echo str_replace( '.custom-background', '', ob_get_clean());
}


/* ============================== */
/* 	 	Pagina impostazioni 	  */
/* ============================== */
require(get_template_directory() . '/settings.php');


/* ============================== */
/* 	 	  Inizzializzazione 	  */
/* ============================== */
function init_bte_theme() {
	//versione installata e corrente
	$installed_ver = get_option( 'bte_theme_version' );
	$current_ver = wp_get_theme()->get('Version');
	
	//sfondo personalizzato
	$bg = array(
		'default-color'			=> 'ffffff',
		'default-image'			=> get_template_directory_uri() . '/resources/uploads/bg.png',
		'default-size'			=> 'cover',
		'default-repeat'        => 'no-repeat',
		'default-position-x'     => 'left',
        'default-position-y'     => 'top',
		'default-attachment'    => 'fixed',
		'wp-head-callback'      => 'change_bte_theme_custom_background_cb'
	);
	add_theme_support( 'custom-background', $bg );
	
	//titolo personalizzato
	add_theme_support( 'title-tag' );
	
	//menù
	register_nav_menus(
		array(
		  'header-menu' => __( 'Header Menu' )
		 )
	);
	
	//galleria foto
	global $wpdb;
	$wpdb->show_errors();
	
	//creo tabella per foto se non esiste o versione precedente
	if ( !isset($installed_ver) || $installed_ver != $current_ver ) {
		//dettagli per la creazione della tabella
		$table_name = $wpdb->prefix . 'bte_theme_showcase'; 
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE `$table_name` (
				  `id` int(4) NOT NULL AUTO_INCREMENT,
				  `path` text NOT NULL,
				  `title` text NOT NULL,
				  `description` blob NOT NULL,
				  `visible` BOOLEAN NOT NULL DEFAULT TRUE
				) $charset_collate COMMENT='Tabella per le foto dello showcase del tema BTE';";

		//creo tabella
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		//aggiorno versione
		update_option( 'bte_theme_version', $current_ver );
	}
}

//avvio funzioni per il tema
add_action('after_setup_theme', 'init_bte_theme');

//rimuovo supporto per commenti
function remove_comments_page() {
	remove_menu_page( 'edit-comments.php' );
}
function remove_admin_bar_comments() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

add_action('init', 'remove_comment_support', 100);
add_action('admin_menu', 'remove_comments_page');
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_comments' );

//registro gli scripts
//lax.js
wp_register_script('lax', 'https://cdn.jsdelivr.net/npm/lax.js@1.2.5', null, null, true);
//Three.js
wp_register_script('threejs', 'https://cdn.jsdelivr.net/npm/three/build/three.min.js', null, null, true);
//script per galleria in pagina amministrazione
wp_register_script('bte_script_admin_media', get_template_directory_uri() . '/js/admin_media.js', array('jquery'), null, true);
//script per galleria in home.php
wp_register_script('bte_script_gallery', get_template_directory_uri() . '/js/gallery.js', array('jquery'), null, true);
//script per parallax in pagine pubbliche
wp_register_script('bte_script_parallax', get_template_directory_uri() . '/js/parallax.js', array('jquery', 'lax'), null, true);
//script per testi diinamici in homepage
wp_register_script('bte_text_changer', get_template_directory_uri() . '/js/text_changer.js', null, null, true);
?>