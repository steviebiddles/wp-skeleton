<?php
namespace App\Controller;

use Timber;
use App\App;

class BaseController {

	/**
	 * @var App
	 */
	protected $app;

	/**
	 * @var Timber
	 */
	protected $context;

	/**
	 * BaseController constructor.
	 */
	public function __construct() {
		global $app;

		$this->app     = $app;
		$this->context = Timber::get_context();
	}

	/**
	 * @return \TimberFunctionWrapper
	 */
	protected function getDynamicWidgets() {
		return Timber::get_widgets( 'dynamic_sidebar' );
	}

	/**
	 * @param $view
	 * @param array $data
	 *
	 * @return string
	 */
	protected function render( $view, array $data = array() ) {
		if ( is_string( $view ) ) {
			$view = array( $view );
		}

		$data = array_merge( $this->context, $data );

		return (string) Timber::render( $view, $data );
	}
}