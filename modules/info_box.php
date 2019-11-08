<?php
/***
 * Module > Info Box
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_info_box extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'ico_family' => 'fa fa-',
				'ico' => 'cogs',
				'ico_custom' => '',
				'ico_img' => '',
				'title' => '',
				'position' => 'left',
				'vertical' => 'no',
				'align' => '',
				'style' => 'none',
				'size' => '',
				'el_class' => '',
				'css_animation' => '',
			), $atts) );

			$output = '';
			$classes = '';
			$icon_classes = '';

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

			// Icon Position
			if('left' == $position)
				$classes .= ' icon-at-left';
			else if('right' == $position)
				$classes .= ' icon-at-right';
			else if('top' == $position)
				$classes .= ' icon-at-top';

			if('yes' == $vertical)
				$classes .= ' icon-at-middle';

			$classes .= $align;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Icon
			$icon_classes .= ' icon-' . $style;

			if('' != $size)
				$icon_classes .= ' size-' . $size;

			$icon_markup = '<i class="'.$ico_family.$ico.'"></i>';
				
			if('' != $ico_custom)
				$icon_markup = '<i class="'.$ico_custom.'"></i>';

			if($ico_img != '') {
				$url = wp_get_attachment_image_src($ico_img, 'full');

				$icon_markup = '<img src="'. $url['0'].'" alt="">';

				$icon_classes .= ' icon-image';
			}

			// Output Form
			ob_start();
			?>
			<div class="ivan-info-box-wrapper <?php echo str_replace('.', '', $this->prefix); ?> <?php echo $this->getCSSAnimation($css_animation); ?>">
				<div class="ivan-info-box <?php echo $classes; ?>">
					
					<?php if('right' != $position) : ?>
						<div class="icon-wrapper <?php echo $icon_classes; ?>">
							<div class="icon-inner">
								<?php echo $icon_markup; ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="infos">
						<?php if('' != $title) : ?>
							<div class="title">
								<h4><?php echo $title; ?></h4>
							</div>
						<?php endif; ?>
						<?php if('' != $content) : ?>
							<div class="description">
								<?php echo do_shortcode($content); ?>
							</div>
						<?php endif; ?>
					</div>
					
					<?php if('right' == $position) : ?>
						<div class="icon-wrapper <?php echo $icon_classes; ?>">
							<div class="icon-inner">
								<?php echo $icon_markup; ?>
							</div>
						</div>
					<?php endif; ?>

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
			'main_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				//'font-size' => 'h2',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				//'color' => 'h2',
				// Spacing
				'margin-top' => '.ivan-info-box',
				'margin-right' => '.ivan-info-box',
				'margin-bottom' => '.ivan-info-box',
				'margin-left' => '.ivan-info-box',
				'padding-top' => '.ivan-info-box',
				'padding-right' => '.ivan-info-box',
				'padding-bottom' => '.ivan-info-box',
				'padding-left' => '.ivan-info-box',
				// Bg
				'background-color' => '.ivan-info-box',
				// Border Radius
				'border-top-left-radius' => '.ivan-info-box',
				'border-top-right-radius' => '.ivan-info-box',
				'border-bottom-left-radius' => '.ivan-info-box',
				'border-bottom-right-radius' => '.ivan-info-box',
				// Border
				'border-top-width' => '.ivan-info-box',
				'border-right-width' => '.ivan-info-box',
				'border-bottom-width' => '.ivan-info-box',
				'border-left-width' => '.ivan-info-box',
				'border-style' => '.ivan-info-box',
				'border-color' => '.ivan-info-box',
				// Hovers
				//'color-hover' => 'label:hover',
				'border-color-hover' => '.ivan-info-box:hover',
				'background-color-hover' => '.ivan-info-box:hover',
			),	
			'icon_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				'font-size' => '.icon-inner',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				'color' => '.icon-inner',
				// Spacing
				'margin-top' => '.icon-inner',
				'margin-right' => '.icon-inner',
				'margin-bottom' => '.icon-inner',
				'margin-left' => '.icon-inner',
				'padding-top' => '.icon-inner',
				'padding-right' => '.icon-inner',
				'padding-bottom' => '.icon-inner',
				'padding-left' => '.icon-inner',
				// Bg
				'background-color' => '.icon-inner',
				// Border Radius
				'border-top-left-radius' => '.icon-inner',
				'border-top-right-radius' => '.icon-inner',
				'border-bottom-left-radius' => '.icon-inner',
				'border-bottom-right-radius' => '.icon-inner',
				// Border
				'border-top-width' => '.icon-inner',
				'border-right-width' => '.icon-inner',
				'border-bottom-width' => '.icon-inner',
				'border-left-width' => '.icon-inner',
				'border-style' => '.icon-inner',
				'border-color' => '.icon-inner',
				// Hovers
				'color-hover' => '.ivan-info-box:hover .icon-inner',
				'border-color-hover' => '.ivan-info-box:hover .icon-inner',
				'background-color-hover' => '.ivan-info-box:hover .icon-inner',
			),
			'title_css' => array(
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
				//'padding-top' => '.ivan-info-box',
				//'padding-right' => '.ivan-info-box',
				//'padding-bottom' => '.ivan-info-box',
				//'padding-left' => '.ivan-info-box',
				// Bg
				//'background-color' => '.ivan-info-box',
				// Border Radius
				//'border-top-left-radius' => '.ivan-info-box',
				//'border-top-right-radius' => '.ivan-info-box',
				//'border-bottom-left-radius' => '.ivan-info-box',
				//'border-bottom-right-radius' => '.ivan-info-box',
				// Border
				//'border-top-width' => '.ivan-info-box',
				//'border-right-width' => '.ivan-info-box',
				//'border-bottom-width' => '.ivan-info-box',
				//'border-left-width' => '.ivan-info-box',
				//'border-style' => '.ivan-info-box',
				//'border-color' => '.ivan-info-box',
				// Hovers
				'color-hover' => '.ivan-info-box:hover h4',
				//'border-color-hover' => '.ivan-info-box:hover',
				//'background-color-hover' => '.ivan-info-box:hover',
			),
			'content_css' => array(
				// Font
				'font-family' => '.description',
				'font-weight' => '.description',
				'font-size' => '.description',
				'line-height' => '.description',
				'text-transform' => '.description',
				'color' => '.description',
				// Spacing
				'margin-top' => '.description',
				'margin-right' => '.description',
				'margin-bottom' => '.description',
				'margin-left' => '.description',
				//'padding-top' => '.ivan-info-box',
				//'padding-right' => '.ivan-info-box',
				//'padding-bottom' => '.ivan-info-box',
				//'padding-left' => '.ivan-info-box',
				// Bg
				//'background-color' => '.ivan-info-box',
				// Border Radius
				//'border-top-left-radius' => '.ivan-info-box',
				//'border-top-right-radius' => '.ivan-info-box',
				//'border-bottom-left-radius' => '.ivan-info-box',
				//'border-bottom-right-radius' => '.ivan-info-box',
				// Border
				//'border-top-width' => '.ivan-info-box',
				//'border-right-width' => '.ivan-info-box',
				//'border-bottom-width' => '.ivan-info-box',
				//'border-left-width' => '.ivan-info-box',
				//'border-style' => '.ivan-info-box',
				//'border-color' => '.ivan-info-box',
				// Hovers
				'color-hover' => '.ivan-info-box:hover .description',
				//'border-color-hover' => '.ivan-info-box:hover',
				//'background-color-hover' => '.ivan-info-box:hover',
			),		
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_info_box;
	$ivan_vc_info_box = new WPBakeryShortCode_ivan_info_box( array('name' => 'Info Box', 'base' => 'ivan_info_box') );

} // #end class check