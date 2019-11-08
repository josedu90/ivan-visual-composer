<?php
/***
 * Module > Button
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_button extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'link' => '',
				'target' => '',
				'size' => '',
				'text' => '',
				'display' => '',
				'css_animation' => '',
				'el_class' => '',
				'ico_family' => '',
				'ico' => '',
				'ico_custom' => '',
				'align' => '',
			), $atts) );

			$output = '';
			$classes = '';

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

			$attr_target = '';
			if('yes' == $target)
				$attr_target = ' target="_blank"';

			$classes .= $size;

			//$classes .= $display;

			if('' == $text)
				$classes .= ' no-text';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Font Icon
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

			<?php 
			if('' != $align && ' default-align' != $align)
				echo '<div class="ivan-button-align '.$align.'">';
			?>

			<div class="ivan-button-wrapper <?php echo $display; ?> <?php echo str_replace('.', '', $this->prefix); ?>  <?php echo $this->getCSSAnimation($css_animation); ?>">
				<a href="<?php echo $link; ?>" class="btn <?php echo $classes; ?> ivan-button"<?php echo $attr_target; ?>>
					<?php echo $icon_markup; ?><?php echo $text; ?>
				</a>
			</div>

			<?php 
			if('' != $align && ' default-align' != $align)
				echo '</div>';
			?>

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
			'btn_css' => array(
				// Font
				'font-family' => 'a',
				'font-weight' => 'a',
				'font-size' => 'a',
				'line-height' => 'a',
				'text-transform' => 'a',
				'color' => 'a',
				// Spacing
				'margin-top' => 'a',
				'margin-right' => 'a',
				'margin-bottom' => 'a',
				'margin-left' => 'a',
				'padding-top' => 'a',
				'padding-right' => 'a',
				'padding-bottom' => 'a',
				'padding-left' => 'a',
				// Bg
				'background-color' => 'a',
				// Border Radius
				'border-top-left-radius' => 'a',
				'border-top-right-radius' => 'a',
				'border-bottom-left-radius' => 'a',
				'border-bottom-right-radius' => 'a',
				// Border
				'border-top-width' => 'a',
				'border-right-width' => 'a',
				'border-bottom-width' => 'a',
				'border-left-width' => 'a',
				'border-style' => 'a',
				'border-color' => 'a',
				// Hovers
				'color-hover' => 'a:hover',
				'border-color-hover' => 'a:hover',
				'background-color-hover' => 'a:hover',
			),
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_button;
	$ivan_vc_button = new WPBakeryShortCode_ivan_button( array('name' => 'Button', 'base' => 'ivan_button') );

} // #end class check