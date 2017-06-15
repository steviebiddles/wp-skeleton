<?php
namespace App\Theme;

use TimberMenu;

class Setup {

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'configure_theme' ) );
		add_action( 'init', array( $this, 'disable_wp_emojicons' ) );

		add_filter( 'timber_context', array( $this, 'add_menus' ) );
		add_filter( 'embed_oembed_html', array( $this, 'custom_oembed_filter' ), 10, 4 );
	}

	public function configure_theme() {
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5' );
	}

	public function add_menus( $data ) {
		$data['menus'] = array(
			'main'     => new TimberMenu( 'main' ),
		);

		return $data;
	}

	public function disable_wp_emojicons() {
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	}

	/**
	 * @param $html
	 * @param $url
	 * @param $attr
	 * @param $post_ID
	 *
	 * @return string
	 */
	function custom_oembed_filter( $html, $url, $attr, $post_ID ) {
		$html = str_replace( '<iframe', '<iframe class="embed-responsive-item"', $html );

		return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
	}
}