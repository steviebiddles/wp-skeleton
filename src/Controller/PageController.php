<?php

namespace App\Controller;

use TimberPost;

class PageController extends BaseController {

	public function indexAction() {
		$post = new TimberPost();

		$templates = array(
			'page-' . $post->post_name . '.html.twig',
			'page.html.twig',
		);

		$this->render( $templates, array(
			'post' => $post,
		) );
	}
}
