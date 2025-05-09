<?php
/**
 * Flex Stylable Card – A fully configurable card element
 */
if ( ! defined( 'ABSPATH' ) || ! defined( 'BRICKS_VERSION' ) ) {
	return;
}

use Bricks\Frontend;

class BFA_Flex_Style_Card extends \Bricks\Element {

	/* ---------- Meta ---------- */
	public $category = 'Flex Addons Layout';
	public $name     = 'flex-style-card';
	public $icon     = 'fa-solid fa-square';
	public $nestable = true;

	public function get_label()    { return 'Stylable Card'; }
	public function get_keywords() { return [ 'card', 'container', 'box', 'wrapper' ]; }

	/* ---------- Pre‑insert nested children ---------- */
	public function get_nestable_children() {
		return [
			[
				'name'     => 'block',
				'label'    => esc_html__( 'Card Content', 'flex-addons' ),
				'settings' => [
					'_cssClasses' => 'bfa-style-card__content',
				],
			],
		];
	}

	/* ---------- Controls ---------- */
	public function set_controls() {
		// No controls needed - using Bricks' default div controls
	}

	public function render() {
		$root_classes = [ 'bfa-style-card' ];
		$this->set_attribute( '_root', 'class', $root_classes );

		// Render the element
		echo "<div {$this->render_attributes('_root')}>";
		
		// Try rendering any nested children (Builder defaults or user drops)
		$inner = \Bricks\Frontend::render_children( $this );

		if ( trim( $inner ) ) {
			// We have child content — output it
			echo $inner;
		} else {
			// No children saved (front‑end first load) — fallback default:
			echo '<div class="bfa-style-card__content">';
			echo   esc_html__( 'Card Content', 'flex-addons' );
			echo '</div>';
		}

		echo '</div>';
	}

	/* ---------- Enqueue JS & CSS ---------- */
	public function enqueue_scripts() {
		$base = plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'assets/';

		wp_enqueue_style(
			'bfa-style-card',
			$base . 'css/style-card.css',
			[],
			'1.0'
		);
	}
} 