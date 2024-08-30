<?php
/**
 * Plugin Name: Modo SEO
 * Description: Ajout de divers widgets compatibles SEO
 * Version:     2.0.1
 * Author:      Agence Mōdo
 * Author URI:  https://agence-modo.fr/
 * Text Domain: modo-seo
 */

function register_widgets( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/seo-unfold-widget.php' );
	require_once( __DIR__ . '/widgets/seo-accordion-widget.php' );

	$widgets_manager->register( new \Elementor_SEO_Accordion_Widget() );
	$widgets_manager->register( new \Elementor_SEO_Unfold_Widget() );

}
add_action( 'elementor/widgets/register', 'register_widgets' );


function modo_seo_enqueue_style_and_script(){
	//SEO Unfold
    wp_enqueue_style('seo-unfold-style', plugins_url('modo-seo/assets/css/seo-unfold.css'));
	wp_enqueue_script('seo-unfold-script', plugins_url('modo-seo/assets/js/seo-unfold.js'), array('jquery'));

	//SEO Accordion
	wp_enqueue_style('seo-accordion-style', plugins_url('modo-seo/assets/css/seo-accordion.css'));
	wp_enqueue_script('seo-accordion-script', plugins_url('modo-seo/assets/js/seo-accordion.js'), array('jquery'));
	
}
add_action( 'wp_enqueue_scripts', 'modo_seo_enqueue_style_and_script', 999 );


function modo_seo_enqueue_style_in_editor(){
	//SEO Unfold
	wp_register_style( 'seo-unfold-style', plugins_url('modo-seo/assets/css/seo-unfold.css'));
	wp_enqueue_style( 'seo-unfold-style' );

	//SEO Accordion
	wp_register_style( 'seo-accordion-style', plugins_url('modo-seo/assets/css/seo-accordion.css'));
	wp_enqueue_style( 'seo-accordion-style' );
}
add_action( 'elementor/editor/after_enqueue_styles', 'modo_seo_enqueue_style_in_editor');
add_action( 'elementor/editor/after_enqueue_styles', 'modo_seo_enqueue_style_in_editor');


function modo_seo_enqueue_script_in_editor(){
	//SEO Unfold
	wp_register_script( 'seo-unfold-script', plugins_url('modo-seo/assets/js/seo-unfold.js'), array('jquery') );
	wp_enqueue_script( 'seo-unfold-script' );

	//SEO Accordion
	wp_register_script( 'seo-accordion-script', plugins_url('modo-seo/assets/js/seo-accordion.js'), array('jquery') );
	wp_enqueue_script( 'seo-accordion-script' );
}
add_action( 'elementor/editor/after_enqueue_scripts', 'modo_seo_enqueue_script_in_editor');
add_action( 'elementor/editor/after_enqueue_scripts', 'modo_seo_enqueue_script_in_editor');
