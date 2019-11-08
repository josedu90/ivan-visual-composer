<?php
/***
 * Extension > Call to Action
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_CallToAction') ) {
	class Ivan_VC_CallToAction {

		// Contructor
		function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_calltoaction_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_vc_calltoaction_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

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

			$output = '<div class="ivan-calltoaction-wrap '.str_replace('.', '', $this->prefix).'">';
			
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
			'main_css' => array(
				// Font
				//'font-family' => '.wpb_toggle',
				//'font-weight' => '.wpb_toggle',
				//'font-size' => '.wpb_toggle',
				//'line-height' => '.wpb_toggle',
				//'text-transform' => '.wpb_toggle',
				//'color' => '.wpb_toggle',
				// Spacing
				'margin-top' => '.vc_call_to_action',
				'margin-right' => '.vc_call_to_action',
				'margin-bottom' => '.vc_call_to_action',
				'margin-left' => '.vc_call_to_action',
				'padding-top' => '.vc_call_to_action',
				'padding-right' => '.vc_call_to_action',
				'padding-bottom' => '.vc_call_to_action',
				'padding-left' => '.vc_call_to_action',
				// Bg
				'background-color' => '.vc_call_to_action',
				// Border Radius
				'border-top-left-radius' => '.vc_call_to_action',
				'border-top-right-radius' => '.vc_call_to_action',
				'border-bottom-left-radius' => '.vc_call_to_action',
				'border-bottom-right-radius' => '.vc_call_to_action',
				// Border
				'border-top-width' => '.vc_call_to_action',
				'border-right-width' => '.vc_call_to_action',
				'border-bottom-width' => '.vc_call_to_action',
				'border-left-width' => '.vc_call_to_action',
				'border-style' => '.vc_call_to_action',
				'border-color' => '.vc_call_to_action',
				// Hovers
				//'color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'border-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'background-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
			),
			'title_css' => array(
				// Font
				'font-family' => 'h2',
				'font-weight' => 'h2',
				'font-size' => 'h2',
				'line-height' => 'h2',
				'text-transform' => 'h2',
				'color' => 'h2',
				// Spacing
				'margin-top' => 'h2',
				'margin-right' => 'h2',
				'margin-bottom' => 'h2',
				'margin-left' => 'h2',
				//'padding-top' => '.vc_call_to_action',
				//'padding-right' => '.vc_call_to_action',
				//'padding-bottom' => '.vc_call_to_action',
				//'padding-left' => '.vc_call_to_action',
				// Bg
				//'background-color' => '.vc_call_to_action',
				// Border Radius
				//'border-top-left-radius' => '.vc_call_to_action',
				//'border-top-right-radius' => '.vc_call_to_action',
				//'border-bottom-left-radius' => '.vc_call_to_action',
				//'border-bottom-right-radius' => '.vc_call_to_action',
				// Border
				//'border-top-width' => '.vc_call_to_action',
				//'border-right-width' => '.vc_call_to_action',
				//'border-bottom-width' => '.vc_call_to_action',
				//'border-left-width' => '.vc_call_to_action',
				//'border-style' => '.vc_call_to_action',
				//'border-color' => '.vc_call_to_action',
				// Hovers
				//'color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'border-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'background-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
			),
			'subtitle_css' => array(
				// Font
				'font-family' => 'h4',
				'font-weight' => 'h4',
				'font-size' => 'h4',
				'line-height' => 'h4',
				'text-transform' => 'h4',
				'color' => 'h4',
				// Spacing
				'margin-top' => 'h4',
				'margin-right' => 'h4',
				'margin-bottom' => 'h4',
				'margin-left' => 'h4',
				//'padding-top' => '.vc_call_to_action',
				//'padding-right' => '.vc_call_to_action',
				//'padding-bottom' => '.vc_call_to_action',
				//'padding-left' => '.vc_call_to_action',
				// Bg
				//'background-color' => '.vc_call_to_action',
				// Border Radius
				//'border-top-left-radius' => '.vc_call_to_action',
				//'border-top-right-radius' => '.vc_call_to_action',
				//'border-bottom-left-radius' => '.vc_call_to_action',
				//'border-bottom-right-radius' => '.vc_call_to_action',
				// Border
				//'border-top-width' => '.vc_call_to_action',
				//'border-right-width' => '.vc_call_to_action',
				//'border-bottom-width' => '.vc_call_to_action',
				//'border-left-width' => '.vc_call_to_action',
				//'border-style' => '.vc_call_to_action',
				//'border-color' => '.vc_call_to_action',
				// Hovers
				//'color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'border-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'background-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
			),
			'content_css' => array(
				// Font
				'font-family' => 'p',
				'font-weight' => 'p',
				'font-size' => 'p',
				'line-height' => 'p',
				'text-transform' => 'p',
				'color' => 'p',
				// Spacing
				//'margin-top' => 'h4',
				//'margin-right' => 'h4',
				//'margin-bottom' => 'h4',
				//'margin-left' => 'h4',
				//'padding-top' => '.vc_call_to_action',
				//'padding-right' => '.vc_call_to_action',
				//'padding-bottom' => '.vc_call_to_action',
				//'padding-left' => '.vc_call_to_action',
				// Bg
				//'background-color' => '.vc_call_to_action',
				// Border Radius
				//'border-top-left-radius' => '.vc_call_to_action',
				//'border-top-right-radius' => '.vc_call_to_action',
				//'border-bottom-left-radius' => '.vc_call_to_action',
				//'border-bottom-right-radius' => '.vc_call_to_action',
				// Border
				//'border-top-width' => '.vc_call_to_action',
				//'border-right-width' => '.vc_call_to_action',
				//'border-bottom-width' => '.vc_call_to_action',
				//'border-left-width' => '.vc_call_to_action',
				//'border-style' => '.vc_call_to_action',
				//'border-color' => '.vc_call_to_action',
				// Hovers
				//'color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'border-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
				//'background-color-hover' => '.wpb_toggle.wpb_toggle_title_active, .wpb_toggle:hover',
			),
			'btn_css' => array(
				// Font
				'font-family' => '.vc_btn',
				'font-weight' => '.vc_btn',
				'font-size' => '.vc_btn',
				'line-height' => '.vc_btn',
				'text-transform' => '.vc_btn',
				'color' => '.vc_btn',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				'padding-top' => '.vc_btn',
				'padding-right' => '.vc_btn',
				'padding-bottom' => '.vc_btn',
				'padding-left' => '.vc_btn',
				// Bg
				'background-color' => '.vc_btn',
				// Border Radius
				'border-top-left-radius' => '.vc_btn',
				'border-top-right-radius' => '.vc_btn',
				'border-bottom-left-radius' => '.vc_btn',
				'border-bottom-right-radius' => '.vc_btn',
				// Border
				'border-top-width' => '.vc_btn',
				'border-right-width' => '.vc_btn',
				'border-bottom-width' => '.vc_btn',
				'border-left-width' => '.vc_btn',
				'border-style' => '.vc_btn',
				'border-color' => '.vc_btn',
				// Hovers
				'color-hover' => '.vc_btn:hover',
				'border-color-hover' => '.vc_btn:hover',
				'background-color-hover' => '.vc_btn:hover',
			),
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_calltoaction;
	$ivan_vc_calltoaction = new Ivan_VC_CallToAction();

	if ( !function_exists( 'vc_theme_before_vc_cta_button2' ) ) {
		function vc_theme_before_vc_cta_button2($atts, $content = null) {
			return apply_filters( 'ivan_vc_calltoaction_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_cta_button2' ) ) {
		function vc_theme_after_vc_cta_button2($atts, $content = null) {
			return apply_filters( 'ivan_vc_calltoaction_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check