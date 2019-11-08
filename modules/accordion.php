<?php
/***
 * Extension > Accordion
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Accordion') ) {
	class Ivan_VC_Accordion {

		// Contructor
		function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_accordion_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_vc_accordion_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

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

			$output = '<div class="ivan-accordion-wrap '.str_replace('.', '', $this->prefix).'">';
			
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
				'font-family' => '.wpb_accordion_header a',
				'font-weight' => '.wpb_accordion_header a',
				'font-size' => '.wpb_accordion_header a',
				'line-height' => '.wpb_accordion_header a',
				'text-transform' => '.wpb_accordion_header a',
				'color' => '.wpb_accordion_header, .wpb_accordion_header a',
				// Spacing
				'margin-top' => '.wpb_accordion_header',
				'margin-right' => '.wpb_accordion_header a',
				'margin-bottom' => '.wpb_accordion_header',
				'margin-left' => '.wpb_accordion_header a',
				'padding-top' => '.wpb_accordion_header a',
				'padding-right' => '.wpb_accordion_header a',
				'padding-bottom' => '.wpb_accordion_header a',
				'padding-left' => '.wpb_accordion_header a',
				// Bg
				'background-color' => '.wpb_accordion_header, .wpb_accordion_header a',
				// Border Radius
				'border-top-left-radius' => '.wpb_accordion_header a',
				'border-top-right-radius' => '.wpb_accordion_header a',
				'border-bottom-left-radius' => '.wpb_accordion_header a',
				'border-bottom-right-radius' => '.wpb_accordion_header a',
				// Border
				'border-top-width' => '.wpb_accordion_header a',
				'border-right-width' => '.wpb_accordion_header a',
				'border-bottom-width' => '.wpb_accordion_header a',
				'border-left-width' => '.wpb_accordion_header a',
				'border-style' => '.wpb_accordion_header a',
				'border-color' => '.wpb_accordion_header a',
				// Hovers
				'color-hover' => '.wpb_accordion_header a:hover, .wpb_accordion_header:hover span, .ui-accordion-header-active a, .ui-accordion-header-active span',
				'border-color-hover' => '.wpb_accordion_header:hover, .wpb_accordion_header a:hover, .ui-accordion-header-active a',
				'background-color-hover' => '.wpb_accordion_header:hover, .wpb_accordion_header a:hover, .ui-accordion-header-active a',
			),
			'content_css' => array(
				// Font
				//'font-family' => 'p',
				//'font-weight' => 'p',
				//'font-size' => 'h4',
				//'line-height' => 'p',
				//'text-transform' => 'p',
				//'color' => '.wpb_toggle_content h1, .wpb_toggle_content h2, .wpb_toggle_content h3, .wpb_toggle_content h4, .wpb_toggle_content p, .wpb_toggle_content a, .wpb_toggle_content li',
				// Spacing
				'margin-top' => '.wpb_accordion_content',
				'margin-right' => '.wpb_accordion_content',
				'margin-bottom' => '.wpb_accordion_content',
				'margin-left' => '.wpb_accordion_content',
				'padding-top' => '.wpb_accordion_content',
				'padding-right' => '.wpb_accordion_content',
				'padding-bottom' => '.wpb_accordion_content',
				'padding-left' => '.wpb_accordion_content',
				// Bg
				'background-color' => '.wpb_accordion_content',
				// Border Radius
				'border-top-left-radius' => '.wpb_accordion_content',
				'border-top-right-radius' => '.wpb_accordion_content',
				'border-bottom-left-radius' => '.wpb_accordion_content',
				'border-bottom-right-radius' => '.wpb_accordion_content',
				// Border
				'border-top-width' => '.wpb_accordion_content',
				'border-right-width' => '.wpb_accordion_content',
				'border-bottom-width' => '.wpb_accordion_content',
				'border-left-width' => '.wpb_accordion_content',
				'border-style' => '.wpb_accordion_content',
				'border-color' => '.wpb_accordion_content',
				// Hovers
				//'color-hover' => '.wpb_toggle_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),	
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_accordion;
	$ivan_vc_accordion = new Ivan_VC_Accordion();

	if ( !function_exists( 'vc_theme_before_vc_accordion' ) ) {
		function vc_theme_before_vc_accordion($atts, $content = null) {
			return apply_filters( 'ivan_vc_accordion_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_accordion' ) ) {
		function vc_theme_after_vc_accordion($atts, $content = null) {
			return apply_filters( 'ivan_vc_accordion_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check