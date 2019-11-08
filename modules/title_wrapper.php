<?php
/***
 * Module > Title Wrapper
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_title extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'ico_family' => '',
				'ico' => '',
				'ico_custom' => '',
				'above_icon' => 'no',
				'align' => '',
				'display' => '',
				'mark' => '',
				'sub' => '',
				'el_class' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$inner_classes = '';

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

			// Main Classes
			$classes .= $align;

			// Inner Classes
			$inner_classes .= $display;

			$inner_classes .= $mark;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			$icon_markup = '';

			if('' != $ico) :
				$icon_markup = '<i class="'.$ico_family.$ico.'"></i>';
			endif;

			if('' != $ico_custom) :
				$icon_markup = '<i class="'.$ico_custom.'"></i>';
			endif;

			// Output Form
			ob_start();
			?>
			<div class="ivan-title-main <?php echo str_replace('.', '', $this->prefix); ?>">
				<div class="ivan-title-wrapper <?php echo $classes; ?>">
					<div class="title-wrapper <?php echo $inner_classes; ?>">
						<?php if('' != $icon_markup && 'yes' == $above_icon) : ?>
							<div class="icon-above">
								<?php echo $icon_markup; ?>
							</div>
						<?php endif; ?>
						<h2>
							<?php if('' != $icon_markup && 'no' == $above_icon) : ?>
								<?php echo $icon_markup; ?>
							<?php endif; ?>
							<?php echo do_shortcode($content); ?>
						</h2>
						<?php if('' != $sub) : ?>
							<div class="sub"><?php echo do_shortcode($sub); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
			$output .= ob_get_clean();

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
			'title_css' => array(
				// Font
				'font-family' => 'h2',
				'font-weight' => 'h2',
				'font-size' => 'h2',
				'line-height' => 'h2',
				'text-transform' => 'h2',
				'color' => 'h2',
				// Spacing
				'margin-top' => '.title-wrapper',
				'margin-right' => '.title-wrapper',
				'margin-bottom' => '.title-wrapper',
				'margin-left' => '.title-wrapper',
				'padding-top' => '.title-wrapper',
				'padding-right' => '.title-wrapper',
				'padding-bottom' => '.title-wrapper',
				'padding-left' => '.title-wrapper',
				// Bg
				'background-color' => '.title-wrapper',
				// Border Radius
				'border-top-left-radius' => '.title-wrapper',
				'border-top-right-radius' => '.title-wrapper',
				'border-bottom-left-radius' => '.title-wrapper',
				'border-bottom-right-radius' => '.title-wrapper',
				// Border
				'border-top-width' => '.title-wrapper',
				'border-right-width' => '.title-wrapper',
				'border-bottom-width' => '.title-wrapper',
				'border-left-width' => '.title-wrapper',
				'border-style' => '.title-wrapper',
				'border-color' => '.title-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'highlight_css' => array(
				// Font
				'font-weight' => 'a, strong',
				'color' => 'a, strong',
				// Hovers
				'color-hover' => 'a:hover',
			),
			'subtitle_css' => array(
				// Font
				'font-family' => '.sub',
				'font-weight' => '.sub',
				'font-size' => '.sub',
				'line-height' => '.sub',
				'text-transform' => '.sub',
				'color' => '.sub, .sub a',
				// Hovers
				'color-hover' => '.sub a:hover',
				// Spacing
				'margin-top' => '.sub',
				'margin-right' => '.sub',
				'margin-bottom' => '.sub',
				'margin-left' => '.sub',
			),
			'mark_css' => array(
				// Bg
				'background-color' => '.mark:after',
				/*
				// Border Radius
				'border-top-left-radius' => '.mark:after',
				'border-top-right-radius' => '.mark:after',
				'border-bottom-left-radius' => '.mark:after',
				'border-bottom-right-radius' => '.mark:after',
				// Border
				'border-top-width' => '.mark:after',
				'border-right-width' => '.mark:after',
				'border-bottom-width' => '.mark:after',
				'border-left-width' => '.mark:after',
				'border-style' => '.mark:after',
				'border-color' => '.mark:after',
				*/
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'icon_css' => array(
				// Font
				'font-size' => '.icon-above',
				'color' => '.icon-above',
				// Spacing
				'margin-top' => '.icon-above',
				'margin-right' => '.icon-above',
				'margin-bottom' => '.icon-above',
				'margin-left' => '.icon-above',
				'padding-top' => '.icon-above',
				'padding-right' => '.icon-above',
				'padding-bottom' => '.icon-above',
				'padding-left' => '.icon-above',
				// Bg
				'background-color' => '.icon-above',
				// Border Radius
				'border-top-left-radius' => '.icon-above',
				'border-top-right-radius' => '.icon-above',
				'border-bottom-left-radius' => '.icon-above',
				'border-bottom-right-radius' => '.icon-above',
				// Border
				'border-top-width' => '.icon-above',
				'border-right-width' => '.icon-above',
				'border-bottom-width' => '.icon-above',
				'border-left-width' => '.icon-above',
				'border-style' => '.icon-above',
				'border-color' => '.icon-above',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),			
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_title_wrapper;
	$ivan_vc_title_wrapper = new WPBakeryShortCode_ivan_title( array('name' => 'Title Wrapper', 'base' => 'ivan_title') );

} // #end class check