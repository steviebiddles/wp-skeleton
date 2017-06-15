<?php

namespace App\Controller;

use Timber;

class ArchiveController extends BaseController {

	public function indexAction() {
		$templates = array(
			'index.html.twig',
		);

		$posts      = Timber::get_posts();
		$pagination = Timber::get_pagination();

		$title = $this->get_title();

		if ( is_category() ) {
			array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.html.twig' );
		} else if ( is_post_type_archive() ) {
			array_unshift( $templates, 'archive-' . get_post_type() . '.html.twig' );
		}

		return $this->render( $templates, array(
			'posts'      => $posts,
			//'widgets'    => $this->getDynamicWidgets(),
			'title'      => $title,
			'pagination' => $pagination,
		) );
	}

	/**
	 * @return string
	 */
	private function get_title() {
		$title = 'Blog';

		if ( is_day() ) {
			$title = 'Archive: ' . get_the_date( 'D M Y' );
		} else if ( is_month() ) {
			$title = 'Archive: ' . get_the_date( 'M Y' );
		} else if ( is_year() ) {
			$title = 'Archive: ' . get_the_date( 'Y' );
		} else if ( is_tag() ) {
			$title = 'Tag: ' . single_tag_title( '', false );
		} else if ( is_category() ) {
			$title = 'Category: ' . single_cat_title( '', false );
		} else if ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		return $title;
	}
}
