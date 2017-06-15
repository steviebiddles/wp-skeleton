<?php
namespace App\Controller;

use Timber;

class FrontPageController extends BaseController {

	public function indexAction() {
		$templates = array( 'index.html.twig' );

		if ( is_front_page() ) {
			array_unshift( $templates, 'front-page.html.twig' );
		}

		$this->render( $templates, array(
			'content' => Timber::get_posts()
		) );
	}
}
