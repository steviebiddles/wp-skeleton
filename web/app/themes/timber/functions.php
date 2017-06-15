<?php
if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	} );
	return;
}

if (!defined('SRC_PATH')) {
	define('SRC_PATH', realpath(__DIR__ . '/../../../../src'));
}

Timber::$dirname = array('templates', 'views');
Timber::$cache = (defined('WP_ENV') && WP_ENV != 'development');

global $app;
$app = new \App\App();