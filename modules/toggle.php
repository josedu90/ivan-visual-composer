<?php
/***
 * Extension > Toggle
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Toggle') ) {
	class Ivan_VC_Toggle {

		// Contructor
		function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_toggle_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_vc_toggle_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

		}

		// Shortcode
		public function shortcode_before($output, $atts, $content) {
			// Extract shortcode attributes
			/*
			extract( shortcode_atts( array(
				'row_width_style' => 'theme_default',
			), $atts) );
			*/
			
			// Output customizer rules
			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
					if( !empty($match[0]) ) {
						$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
						$atts[$key] = str_replace( $match[0], "", $atts[$key] );
					}
				}
			}

			$output = '<div class="ivan-toggle-wrap '.str_replace('.', '', $this->prefix).'">';
			
			return $output;
		}

		// Shortcode
		public function shortcode_after($output, $atts, $content) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			/*
			extract( shortcode_atts( array(
				'row_width_style' => 'theme_default',
			), $atts) );
			*/

			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
					if( !empty($match[0]) ) {
						$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
						$atts[$key] = str_replace( $match[0], "", $atts[$key] );
					}
				}
			}

			$output = '';

			if(is_admin())
				$output .= '<div class="dummy_div_to_margin"></div>';

			$output .= '</div>';

			$style = '';

			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix );
				}
			}

			// Print style
			if(is_admin()) {
				$output .= '<style type="text/css">'
				. $style
				. '</style>';
			}
			else {
				$ivan_custom_css .= $style;
			}

			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'toggle_css' => array(
				// Font
				'font-family' => '.wpb_toggle',
				'font-weight' => '.wpb_toggle',
				'font-size' => '.wpb_toggle',
				'line-height' => '.wpb_toggle',
				'text-transform' => '.wpb_toggle',
				'color' => '.wpb_toggle',
				// Spacing
				'margin-top' => '.wpb_toggle',
				'margin-right' => '.wpb_toggle',
				'margin-bottom' => '.wpb_toggle',
				'margin-left' => '.wpb_toggle',
				'padding-top' => '.wpb_toggle',
				'padding-right' => '.wpb_toggle',
				'padding-bottom' => '.wpb_toggle',
				'padding-left' => '.wpb_toggle',
				// Bg
				'background-color' => '.wpb_toggle',
				// Border Radius
				'border-top-left-radius' => '.wpb_toggle',
				'border-top-right-radius' => '.wpb_toggle',
				'border-bottom-left-radius' => '.wpb_toggle',
				'border-bottom-right-radius' => '.wpb_toggle',
				// Border
				'border-top-width' => '.wpb_toggle',
				'border-right-width' => '.wpb_toggle',
				'border-bottom-width' => '.wpb_toggle',
				'border-left-width' => '.wpb_toggle',
				'border-style' => '.wpb_toggle',
				'border-color' => '.wpb_toggle',
				// Hovers
				'color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				'border-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				'background-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
			),
			'content_css' => array(
				// Font
				//'font-family' => 'p',
				//'font-weight' => 'p',
				//'font-size' => 'h4',
				//'line-height' => 'p',
				//'text-transform' => 'p',
				'color' => '.wpb_toggle_content h1, .wpb_toggle_content h2, .wpb_toggle_content h3, .wpb_toggle_content h4, .wpb_toggle_content p, .wpb_toggle_content a, .wpb_toggle_content li',
				// Spacing
				'margin-top' => '.wpb_toggle_content',
				'margin-right' => '.wpb_toggle_content',
				'margin-bottom' => '.wpb_toggle_content',
				'margin-left' => '.wpb_toggle_content',
				'padding-top' => '.wpb_toggle_content',
				'padding-right' => '.wpb_toggle_content',
				'padding-bottom' => '.wpb_toggle_content',
				'padding-left' => '.wpb_toggle_content',
				// Bg
				'background-color' => '.wpb_toggle_content',
				// Border Radius
				'border-top-left-radius' => '.wpb_toggle_content',
				'border-top-right-radius' => '.wpb_toggle_content',
				'border-bottom-left-radius' => '.wpb_toggle_content',
				'border-bottom-right-radius' => '.wpb_toggle_content',
				// Border
				'border-top-width' => '.wpb_toggle_content',
				'border-right-width' => '.wpb_toggle_content',
				'border-bottom-width' => '.wpb_toggle_content',
				'border-left-width' => '.wpb_toggle_content',
				'border-style' => '.wpb_toggle_content',
				'border-color' => '.wpb_toggle_content',
				// Hovers
				'color-hover' => '.wpb_toggle_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),	
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_toggle;
	$ivan_vc_toggle = new Ivan_VC_Toggle();

	if ( !function_exists( 'vc_theme_before_vc_toggle' ) ) {
		function vc_theme_before_vc_toggle($atts, $content = null) {
			return apply_filters( 'ivan_vc_toggle_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_toggle' ) ) {
		function vc_theme_after_vc_toggle($atts, $content = null) {
			return apply_filters( 'ivan_vc_toggle_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check