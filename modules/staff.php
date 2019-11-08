<?php
/***
 * Module > Staff
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_staff extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'infos_inside' => 'no',
				'social_inside' => 'no',
				'overlay' => 'no',
				'opacity' => 'no',
				'grayscale' => 'no',
				'align' => '',
				'image_id' => '',
				'name' => '',
				'job_title' => '',
				'el_class' => '',
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

			$infos_inside = $infos_inside;
			$social_inside = $social_inside;

			// Effects
			if('yes' == $overlay)
				$classes .= ' overlay-enabled';
			if('yes' == $opacity)
				$classes .= ' opacity-enabled';
			if('yes' == $grayscale)
				$classes .= ' gray-enabled';

			$classes .= $align;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Social Markup
			$social_markup = '';

			// Social Icon List
			$ivan_icon_array = ivan_vc_staff_icons();

			foreach ($ivan_icon_array as $key => $value) {

				if(isset($atts[$key])) {
					$social_markup .= '<a href="'.$atts[$key].'" target="_blank"><i class="fa fa-'.str_replace('_', '-', $key).'"></i></a>';
				}
			}

			// Output Form
			ob_start();
			?>
			<div class="ivan-staff-main <?php echo str_replace('.', '', $this->prefix); ?>">
				<div class="ivan-staff-wrapper taphover <?php echo $classes; ?>">
					<?php if('' != $image_id) : ?>
						<div class="thumbnail">
							<?php
							$url = wp_get_attachment_image_src($image_id, 'full');
							echo '<img src="'. $url['0'].'" alt="">';
							?>
							<span class="overlay"></span>
							<?php if('yes' == $infos_inside) : ?>
								<div class="name"><?php echo $name; ?></div>
								<?php if('' != $job_title) : ?>
									<div class="job-title"><?php echo $job_title; ?></div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if('yes' == $social_inside && '' != $social_markup) : ?>
								<div class="social-icons-inside">
									<div class="social-icons-inner">
										<div class="centered">
											<?php echo $social_markup; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if('yes' != $infos_inside OR '' != $content OR 'yes' != $social_inside) : ?>
						<div class="infos">
							<?php if('yes' != $infos_inside) : ?>
								<div class="name"><?php echo $name; ?></div>
								<?php if('' != $job_title) : ?>
									<div class="job-title"><?php echo $job_title; ?></div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if('' != $content) : ?>
								<div class="description">
									<?php echo do_shortcode($content); ?>
								</div>
							<?php endif; ?>
							<?php if('yes' != $social_inside && '' != $social_markup) : ?>
								<div class="social-icons">
										<?php echo $social_markup; ?>
								</div>
							<?php endif; ?>
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
				'margin-top' => '.ivan-staff-wrapper',
				'margin-right' => '.ivan-staff-wrapper',
				'margin-bottom' => '.ivan-staff-wrapper',
				'margin-left' => '.ivan-staff-wrapper',
				'padding-top' => '.ivan-staff-wrapper',
				'padding-right' => '.ivan-staff-wrapper',
				'padding-bottom' => '.ivan-staff-wrapper',
				'padding-left' => '.ivan-staff-wrapper',
				// Bg
				'background-color' => '.ivan-staff-wrapper',
				// Border Radius
				'border-top-left-radius' => '.ivan-staff-wrapper',
				'border-top-right-radius' => '.ivan-staff-wrapper',
				'border-bottom-left-radius' => '.ivan-staff-wrapper',
				'border-bottom-right-radius' => '.ivan-staff-wrapper',
				// Border
				'border-top-width' => '.ivan-staff-wrapper',
				'border-right-width' => '.ivan-staff-wrapper',
				'border-bottom-width' => '.ivan-staff-wrapper',
				'border-left-width' => '.ivan-staff-wrapper',
				'border-style' => '.ivan-staff-wrapper',
				'border-color' => '.ivan-staff-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'image_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				//'font-size' => 'h2',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				//'color' => 'h2',
				// Spacing
				'margin-top' => '.thumbnail',
				'margin-right' => '.thumbnail',
				'margin-bottom' => '.thumbnail',
				'margin-left' => '.thumbnail',
				//'padding-top' => '.thumbnail',
				//'padding-right' => '.thumbnail',
				//'padding-bottom' => '.thumbnail',
				//'padding-left' => '.thumbnail',
				// Bg
				//'background-color' => '.thumbnail',
				// Border Radius
				'border-top-left-radius' => '.thumbnail, img, .overlay',
				'border-top-right-radius' => '.thumbnail, img, .overlay',
				'border-bottom-left-radius' => '.thumbnail, img, .overlay',
				'border-bottom-right-radius' => '.thumbnail, img, .overlay',
				// Border
				'border-top-width' => '.thumbnail',
				'border-right-width' => '.thumbnail',
				'border-bottom-width' => '.thumbnail',
				'border-left-width' => '.thumbnail',
				'border-style' => '.thumbnail',
				'border-color' => '.thumbnail',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'name_css' => array(
				// Font
				'font-family' => '.name',
				'font-weight' => '.name',
				'font-size' => '.name',
				'line-height' => '.name',
				'text-transform' => '.name',
				'color' => '.name',
				// Spacing
				'margin-top' => '.name',
				'margin-right' => '.name',
				'margin-bottom' => '.name',
				'margin-left' => '.name',
				//'padding-top' => '.ivan-staff-wrapper',
				//'padding-right' => '.ivan-staff-wrapper',
				//'padding-bottom' => '.ivan-staff-wrapper',
				//'padding-left' => '.ivan-staff-wrapper',
				// Bg
				//'background-color' => '.ivan-staff-wrapper',
				// Border Radius
				//'border-top-left-radius' => '.ivan-staff-wrapper',
				//'border-top-right-radius' => '.ivan-staff-wrapper',
				//'border-bottom-left-radius' => '.ivan-staff-wrapper',
				//'border-bottom-right-radius' => '.ivan-staff-wrapper',
				// Border
				//'border-top-width' => '.ivan-staff-wrapper',
				//'border-right-width' => '.ivan-staff-wrapper',
				//'border-bottom-width' => '.ivan-staff-wrapper',
				//'border-left-width' => '.ivan-staff-wrapper',
				//'border-style' => '.ivan-staff-wrapper',
				//'border-color' => '.ivan-staff-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'job_title_css' => array(
				// Font
				'font-family' => '.job-title',
				'font-weight' => '.job-title',
				'font-size' => '.job-title',
				'line-height' => '.job-title',
				'text-transform' => '.job-title',
				'color' => '.job-title',
				// Spacing
				'margin-top' => '.job-title',
				'margin-right' => '.job-title',
				'margin-bottom' => '.job-title',
				'margin-left' => '.job-title',
				//'padding-top' => '.ivan-staff-wrapper',
				//'padding-right' => '.ivan-staff-wrapper',
				//'padding-bottom' => '.ivan-staff-wrapper',
				//'padding-left' => '.ivan-staff-wrapper',
				// Bg
				//'background-color' => '.ivan-staff-wrapper',
				// Border Radius
				//'border-top-left-radius' => '.ivan-staff-wrapper',
				//'border-top-right-radius' => '.ivan-staff-wrapper',
				//'border-bottom-left-radius' => '.ivan-staff-wrapper',
				//'border-bottom-right-radius' => '.ivan-staff-wrapper',
				// Border
				//'border-top-width' => '.ivan-staff-wrapper',
				//'border-right-width' => '.ivan-staff-wrapper',
				//'border-bottom-width' => '.ivan-staff-wrapper',
				//'border-left-width' => '.ivan-staff-wrapper',
				//'border-style' => '.ivan-staff-wrapper',
				//'border-color' => '.ivan-staff-wrapper',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
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
				//'padding-top' => '.ivan-staff-wrapper',
				//'padding-right' => '.ivan-staff-wrapper',
				//'padding-bottom' => '.ivan-staff-wrapper',
				//'padding-left' => '.ivan-staff-wrapper',
				// Bg
				//'background-color' => '.ivan-staff-wrapper',
				// Border Radius
				//'border-top-left-radius' => '.ivan-staff-wrapper',
				//'border-top-right-radius' => '.ivan-staff-wrapper',
				//'border-bottom-left-radius' => '.ivan-staff-wrapper',
				//'border-bottom-right-radius' => '.ivan-staff-wrapper',
				// Border
				//'border-top-width' => '.description hr',
				//'border-right-width' => '.description hr',
				//'border-bottom-width' => '.description hr',
				//'border-left-width' => '.description hr',
				'border-style' => '.description hr',
				'border-color' => '.description hr',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'social_css' => array(
				// Font
				//'font-family' => '.signup',
				//'font-weight' => '.signup',
				'font-size' => '.social-icons a, .social-icons-inner a',
				//'line-height' => '.social-icons a',
				//'text-transform' => '.social-icons a',
				'color' => '.social-icons a, .social-icons-inner a',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.social-icons a',
				//'padding-right' => '.social-icons a',
				//'padding-bottom' => '.social-icons a',
				//'padding-left' => '.social-icons a',
				// Bg
				//'background-color' => '.social-icons a',
				// Border Radius
				//'border-top-left-radius' => '.social-icons a',
				//'border-top-right-radius' => '.social-icons a',
				//'border-bottom-left-radius' => '.social-icons a',
				//'border-bottom-right-radius' => '.social-icons a',
				// Border
				//'border-top-width' => '.social-icons a',
				//'border-right-width' => '.social-icons a',
				//'border-bottom-width' => '.social-icons a',
				//'border-left-width' => '.social-icons a',
				//'border-style' => '.social-icons a',
				//'border-color' => '.social-icons a',
				// Hovers
				'color-hover' => '.social-icons a:hover, .social-icons-inner a:hover',
				//'border-color-hover' => '.social-icons a:hover',
				//'background-color-hover' => '.social-icons a:hover',
			),
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_staff;
	$ivan_vc_staff = new WPBakeryShortCode_ivan_staff( array('name' => 'Staff', 'base' => 'ivan_staff') );

} // #end class check