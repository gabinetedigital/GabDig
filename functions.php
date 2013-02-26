<?php

function twentyeleven_procergs_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Sobre', 'twentyeleven' ),
		'id' => 'sidebar-6',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Resultados 2012', 'twentyeleven' ),
		'id' => 'sidebar-7',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Resultados 2011', 'twentyeleven' ),
		'id' => 'sidebar-8',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Comite de Transito', 'twentyeleven' ),
		'id' => 'sidebar-9',
		'description' => __( 'A sidebar to show widgets on Comite Transito page', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyeleven_procergs_widgets_init' );

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'artigo-herarquico',
		array(
			'labels' => array(
				'name' => __( 'Artigo Hierárquico' ),
				'singular_name' => __( 'Artigo Hierárquico' ),
				'add_new_item' => __('Adicionar novo Artigo Hierárquico'),
				'edit_item' => __( 'Editar Artigo Hierárquico' ),
				'add_new' => __( 'Novo Artigo Hierárquico' ),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'lei'),
			'exclude_from_search' => true,
			'show_in_menu' => true,
			'hierarchical' => 'true',
			'taxonomies' => array(
				'category',
				'post_tag'
			),
			'supports' => array(
				'title','editor','author','page-attributes','comments','revisions',
			),
		)
	);
}

?>
