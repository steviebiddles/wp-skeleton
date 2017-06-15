<?php
namespace App\Theme;

class Scripts {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles' ) );
	}

	/**
	 *
	 */
	public function load_scripts() {
		wp_enqueue_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', null, '2.8.3', false );

		if ( ! is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', null, '1.12.4', true );
		}

		wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/site.js', array( 'jquery', ), false, true );
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.js', array( 'jquery', ), false, true );

		if ( is_front_page() ) {
			wp_enqueue_script( 'homepage-js', get_template_directory_uri() . '/assets/js/homepage.js', array( 'site-js', ), false, true );
		}
	}

	/**
	 *
	 */
	public function load_styles() {
		wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css', false, false );
	}
}