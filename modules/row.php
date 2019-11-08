<?php
/*
 * Row Module Customization
 */

if( !class_exists('Ivan_VC_Row') ) {
	class Ivan_VC_Row {

		// Contructor
		function __construct() {

			// Enqueue scripts and styles if necessary
			add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts') );

			// Customization Init
			add_action( 'admin_init', array($this, 'init') );

			// Apply filter to output custom markup
			add_filter( 'ivan_custom_row_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_custom_row_inner_shortcode_before', array($this, 'shortcode_before_inner'), 10, 3 );
			add_filter( 'ivan_custom_row_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

		}

		// Shortcode
		public static function shortcode_before($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'row_custom_id' => '',
				'row_width_style' => 'theme_default',
				'row_parallax_style' => 'parallax-none',
				'row_parallax_ratio' => '0.5',
				'row_bg_color' => '',
				'row_bg_image' => '',
				'row_bg_repeat' => '',
				'row_bg_position' => '',
				'row_bg_size' => '',
				'row_bg_att' => '',
				'row_video_url' => '',
				'row_overlay_color' => '',
				'row_cut_top' => '',
				'row_cut_top_h' => '30',
				'row_cut_top_w' => '40',
				'row_cut_bottom' => '',
				'row_cut_bottom_h' => '30',
				'row_cut_bottom_w' => '40',
				'row_enable_v_center' => '',
				'row_full_height' => '',
				'row_offsets' => '',
				'row_fullpage' => '',
				'el_class' => '',
			), $atts) );

			$style = '';

			if('' != $row_bg_color)
				$style .= vc_get_css_color('background-color', $row_bg_color);

			$url = '';

			if('' != $row_bg_image) {
				// Get image
				$url = wp_get_attachment_image_src($row_bg_image, 'full');

				$style .= 'background-image: url('.$url[0].');';

				$style .= 'background-repeat: ' . $row_bg_repeat . ';';

				$style .= 'background-position: ' . $row_bg_position . ';';

				$style .= 'background-size: ' . $row_bg_size . ';';
				
				$style .= 'background-attachment: ' . $row_bg_att . ';';
			}

			$overlay = '';

			if('' != $row_overlay_color) {
				$overlay = '<div class="row-overlay" style="'. vc_get_css_color('background-color', $row_overlay_color) .'"></div>';
			}

			$video = '
			<div class="ivan-bg-video">
				<div class="ivan-bg-video-inner"></div>
				'.$overlay.'
			</div>';

			if('' != $row_video_url) {

				$row_video_url = str_replace( '.mp4', '', $row_video_url );
				$row_video_url = str_replace( '.webm', '', $row_video_url );

				$video = '
				<div class="ivan-bg-video">
					<div class="ivan-bg-video-inner">
						<video muted loop autoplay="autoplay">
							<source type="video/mp4" src="' . $row_video_url . '.mp4" />
							<source type="video/webm" src="' . $row_video_url . '.webm" />
						</video>
					</div>
					'.$overlay.'
				</div>';

			}

			$ratio = '';
			if('parallax-vertical' == $row_parallax_style)
				$ratio = 'data-stellar-background-ratio="'.$row_parallax_ratio.'"';

			$row_parallax_style = ' ' . $row_parallax_style;

			// Viewport Height
			$offset = '';
			$viewportHeight = '';

			if('yes' == $row_full_height) :
				$viewportHeight = ' iv-full-viewport';

				if('' != $row_offsets)
					$offset = ' data-offset="'.$row_offsets.'"';
			endif;

			// FullPageJS
			if('yes' == $row_fullpage)
				$row_fullpage = ' row-fullpage';
			else
				$row_fullpage = '';

			// Reset V-Center when at Admin
			if(is_admin() && ' v-center' == $row_enable_v_center)
				$row_enable_v_center = ' composer-v-center';

			// Adds white space if there is extra classes added
			if('' != $el_class)
				$el_class = ' ' . $el_class;

			$output = '<div id="'.$row_custom_id.'" class="ivan-custom-wrapper '.$row_width_style . $row_enable_v_center . $row_parallax_style . $viewportHeight . $row_fullpage . $el_class . '" '.$ratio.' style="'.$style.'"'.$offset.'>' . $video;

			// Add page cut effects
			if('top-left' == $row_cut_top) :

				$output .= '
				<div class="ivan-page-cut top-left" style="height: '.$row_cut_top_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M100 100 L0 100 L0 0" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('top-right' == $row_cut_top) :

				$output .= '
				<div class="ivan-page-cut top-right" style="height: '.$row_cut_top_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M100 0 L0 100 L100 100" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('top-triangle' == $row_cut_top) :

				$output .= '
				<div class="ivan-page-cut top-right top-triangle" style="height: '.$row_cut_top_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="'.$row_cut_top_w.'px" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M50 0 L0 100 L100 100" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('inverse-triangle' == $row_cut_top) :

				$output .= '
				<div class="ivan-page-cut top-right inverse-tri-mobile" style="height: '.$row_cut_top_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M0 0 L0 100 L100 100 L100 0 L62 0 L50 100 L38 0" stroke-width="0"></path>
					</svg>
				</div>';

				$output .= '
				<div class="ivan-page-cut top-right inverse-tri" style="height: '.$row_cut_top_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M0 0 L0 100 L100 100 L100 0 L54 0 L50 100 L46 0" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('bottom-left' == $row_cut_bottom) :

				$output .= '
				<div class="ivan-page-cut bottom-left" style="height: '.$row_cut_bottom_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M0 100 L100 0 L0 0" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('bottom-right' == $row_cut_bottom) :

				$output .= '
				<div class="ivan-page-cut bottom-right" style="height: '.$row_cut_bottom_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M100 100 L100 0 L0 0" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('bottom-triangle' == $row_cut_bottom) :

				$output .= '
				<div class="ivan-page-cut bottom-right bottom-triangle" style="height: '.$row_cut_bottom_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="'.$row_cut_bottom_w.'px" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M50 100 L100 0 L0 0" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			if('inverse-triangle' == $row_cut_bottom) :

				$output .= '
				<div class="ivan-page-cut bottom-right inverse-tri-mobile" style="height: '.$row_cut_bottom_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M0 100 L0 100 L38 100 L50 0 L62 100 L100 100 L100 0 L0 0" stroke-width="0"></path>
					</svg>
				</div>';

				$output .= '
				<div class="ivan-page-cut bottom-right inverse-tri" style="height: '.$row_cut_bottom_h.'px;">
					<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $row_bg_color).'">
						<path d="M0 100 L0 100 L46 100 L50 0 L54 100 L100 100 L100 0 L0 0" stroke-width="0"></path>
					</svg>
				</div>';

			endif;

			return $output;
		}

		// Shortcode
		public static function shortcode_before_inner($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'row_custom_id' => '',
				'row_parallax_style' => 'parallax-none',
				'row_parallax_ratio' => '0.5',
				'row_bg_color' => '',
				'row_bg_image' => '',
				'row_bg_repeat' => '',
				'row_bg_position' => '',
				'row_bg_size' => '',
				'row_bg_att' => '',
				'row_video_url' => '',
				'row_overlay_color' => '',
				'row_enable_v_center' => '',
				'row_full_height' => '',
				'row_offsets' => '',
			), $atts) );

			$style = '';

			if('' != $row_bg_color)
				$style .= vc_get_css_color('background-color', $row_bg_color);

			$url = '';

			if('' != $row_bg_image) {
				// Get image
				$url = wp_get_attachment_image_src($row_bg_image, 'full');

				$style .= 'background-image: url('.$url[0].');';

				$style .= 'background-repeat: ' . $row_bg_repeat . ';';

				$style .= 'background-position: ' . $row_bg_position . ';';

				$style .= 'background-size: ' . $row_bg_size . ';';
				
				$style .= 'background-attachment: ' . $row_bg_att . ';';
			}

			$overlay = '';

			if('' != $row_overlay_color) {
				$overlay = '<div class="row-overlay" style="'. vc_get_css_color('background-color', $row_overlay_color) .'"></div>';
			}

			$video = '
			<div class="ivan-bg-video">
				<div class="ivan-bg-video-inner"></div>
				'.$overlay.'
			</div>';

			if('' != $row_video_url) {

				$row_video_url = str_replace( '.mp4', '', $row_video_url );
				$row_video_url = str_replace( '.webm', '', $row_video_url );

				$video = '
				<div class="ivan-bg-video">
					<div class="ivan-bg-video-inner">
						<video muted loop autoplay="autoplay">
							<source type="video/mp4" src="' . $row_video_url . '.mp4" />
							<source type="video/webm" src="' . $row_video_url . '.webm" />
						</video>
					</div>
					'.$overlay.'
				</div>';

			}

			$ratio = '';
			if('parallax-vertical' == $row_parallax_style)
				$ratio = 'data-stellar-background-ratio="'.$row_parallax_ratio.'"';

			$row_parallax_style = ' ' . $row_parallax_style;

			// Viewport Height
			$offset = '';
			$viewportHeight = '';

			if('yes' == $row_full_height) :
				$viewportHeight = ' iv-full-viewport';

				if('' != $row_offsets)
					$offset = ' data-offset="'.$row_offsets.'"';
			endif;

			// Reset V-Center when at Admin
			if(is_admin() && ' v-center' == $row_enable_v_center)
				$row_enable_v_center = ' composer-v-center';

			$output = '<div id="'.$row_custom_id.'" class="ivan-custom-wrapper '. $row_enable_v_center . $row_parallax_style . $viewportHeight .'" '.$ratio.' style="'.$style.'"'.$offset.'>' . $video;

			return $output;
		}

		// Shortcode
		public static function shortcode_after($output, $atts, $content) {
			// Extract shortcode attributes
			/*
			extract( shortcode_atts( array(
				'row_width_style' => 'theme_default',
			), $atts) );
			*/

			// Additional update script
			$js = '';
			if( is_admin() )
				$js = '<script type="text/javascript">jQuery(document).ready(function() {
					ivan_update_bg();
					jQuery(".ivan-projects-mansory").trigger("ivan_updated_width");
				});</script>';

			$output = '</div>'.$js;

			return $output;
		}

		// Init
		function init() {

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Custom ID", 'iv_js_composer'),
					"param_name" => "row_custom_id",
					"admin_label" => true,
					"value" => "",
					"description" => __("Custom Row ID attribute", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Row Width", 'iv_js_composer'),
					"param_name" => "row_width_style",
					"value" => array(
						__("Normal", "ivan_vc_domain") => "theme_default",
						__("Full Width", "ivan_vc_domain") => "full_width",
						__("Full Width No Side Margins", "ivan_vc_domain") => "full_width no_margin",
						__("Full Width No Side Margin + No Columns Margins", "ivan_vc_domain") => "full_width no_margin no_columns_margin",
						),
					"description" => __("Select the width behavior of this row.", "ivan_vc_domain"),
				)
			);

			vc_add_param("vc_row", array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Parallax Style",'iv_js_composer'),
				"param_name" => "row_parallax_style",
				"value" => array(
					__("Default",'iv_js_composer') => "parallax-none",
					__("Using Parallax Ratio",'iv_js_composer') => "parallax-vertical",
					//__("Interactive Parallax On Mouse Hover",'iv_js_composer') => "vcpb-fs-jquery",
					//__("Multilayer Vertical Parallax",'iv_js_composer') => "vcpb-mlvp-jquery",
				),
				"description" => __("To ensure parallax work properly, set 'Background Attachment' as 'fixed'.",'iv_js_composer'),
			));

				vc_add_param('vc_row', array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Parallax Ratio", 'iv_js_composer'),
						"param_name" => "row_parallax_ratio",
						"admin_label" => true,
						"value" => "0.5",
						"description" => __("This defines the parallax velocity scaled based in natural scoll. Use values like 0.5, 0.8, 1.5, 2 and others.", 'iv_js_composer'),
						"dependency" => array("element" => "row_parallax_style","value" => array("parallax-vertical")),
					)
				);

			vc_add_param("vc_row", array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background Color", 'iv_js_composer'),
				"param_name" => "row_bg_color",
				"value" => "",
				"description" => __("Select normal background color.", 'iv_js_composer'),
			));

			vc_add_param('vc_row',array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Background Image", 'iv_js_composer'),
					"param_name" => "row_bg_image",
					"value" => "",
					"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Repeat", 'iv_js_composer'),
					"param_name" => "row_bg_repeat",
					"value" => array(
						'No Repeat' => "no-repeat",
						'Repeat X' => "repeat-x",
						'Repeat Y' => "repeat-y",
						'Repeat' => "repeat",
						),
					"description" => __("Select the way background image will repeat.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Position", 'iv_js_composer'),
					"param_name" => "row_bg_position",
					"value" => array(
						'Center/Center' => "center center",
						'Left/Top' => "left top",
						'Left/Center' => 'left center',
						'Left/Bottom' => 'left bottom',
						'Right/Top' => "right top",
						'Right/Center' => 'right center',
						'Right/Bottom' => 'right bottom',
						'Center/Top' => "center top",
						'Center/Bottom' => 'center bottom',
						),
					"description" => __("Select the way background image will be positioned. Horizontal/Vertical", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Size", 'iv_js_composer'),
					"param_name" => "row_bg_size",
					"value" => array(
						'Cover' => "cover",
						'Contain' => "contain",
						'Default' => "auto",
						),
					"description" => __("Select the way background image will be sized.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Attachment", 'iv_js_composer'),
					"param_name" => "row_bg_att",
					"value" => array(
						'Default' => "scroll",
						'Fixed' => "fixed",
						),
					"description" => __("Select the way background image will be attached to the page.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Video URL", 'iv_js_composer'),
					"param_name" => "row_video_url",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter your video URL. You can upload a video through <a href='".admin_url("media-new.php")."' target='_blank'>WordPress Media Library</a>, if not done already.", 'iv_js_composer'),
				)
			);

			vc_add_param("vc_row", array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Overlay Color", 'iv_js_composer'),
				"param_name" => "row_overlay_color",
				"value" => "",
				"description" => __("Select overlay color.", 'iv_js_composer'),
			));

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Page Cut Top", 'iv_js_composer'),
					"param_name" => "row_cut_top",
					"value" => array(
						'Disabled' => "",
						'Top at Left' => "top-left",
						'Top at Right' => "top-right",
						'Triangle at Center' => "top-triangle",
						'Inverse Triangle at Center' => "inverse-triangle",
						),
					"description" => __("Add a irregular cut effect to this row with same color than background color.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Page Cut Top Height", 'iv_js_composer'),
					"param_name" => "row_cut_top_h",
					"admin_label" => true,
					"value" => "",
					"description" => __("Define the height of the cut, when the value is higher, the cut angle will increase. Default is 60.", 'iv_js_composer'),
					"dependency" => array("element" => "row_cut_top", "value" => array("top-left", "top-right", "top-triangle", "inverse-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Top Triangle Width", 'iv_js_composer'),
					"param_name" => "row_cut_top_w",
					"admin_label" => true,
					"value" => "",
					"description" => __("Define the triangle width. Default is 60.", 'iv_js_composer'),
					"dependency" => array("element" => "row_cut_top", "value" => array("top-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Page Cut Bottom", 'iv_js_composer'),
					"param_name" => "row_cut_bottom",
					"value" => array(
						'Disabled' => "",
						'Bottom at Left' => "bottom-left",
						'Bottom at Right' => "bottom-right",
						'Triangle at Center' => "bottom-triangle",
						'Inverse Triangle at Center' => "inverse-triangle",
						),
					"description" => __("Add a irregular cut effect to this row with same color than background color.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Page Cut Bottom Height", 'iv_js_composer'),
					"param_name" => "row_cut_bottom_h",
					"admin_label" => true,
					"value" => "",
					"description" => __("Define the height of the cut, when the value is higher, the cut angle will increase. Default is 60.", 'iv_js_composer'),
					"dependency" => array("element" => "row_cut_bottom", "value" => array("bottom-left", "bottom-right", "bottom-triangle", "inverse-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Bottom Triangle Width", 'iv_js_composer'),
					"param_name" => "row_cut_bottom_w",
					"admin_label" => true,
					"value" => "",
					"description" => __("Define the triangle width. Default is 60.", 'iv_js_composer'),
					"dependency" => array("element" => "row_cut_bottom", "value" => array("bottom-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Vertical Align?", 'iv_js_composer'),
					"param_name" => "row_enable_v_center",
					"value" => array(
						'No' => "",
						'Yes' => " v-center",
						),
					"description" => __("When enabled, the columns content will be vertically aligned.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Full Viewport Height?", 'iv_js_composer'),
					"param_name" => "row_full_height",
					"value" => array(
						'No' => "no",
						'Yes' => "yes",
						),
					"description" => __("When enabled, row will have same height than viewport/window.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Viewport Offsets", 'iv_js_composer'),
					"param_name" => "row_offsets",
					"admin_label" => true,
					"value" => "",
					"description" => __("Type the selectors to be offset in full viewport height calculation.", 'iv_js_composer'),
					"dependency" => array("element" => "row_full_height", "value" => array("yes")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Full Page Scroll System?", 'iv_js_composer'),
					"param_name" => "row_fullpage",
					"value" => array(
						'No' => "no",
						'Yes' => "yes",
						),
					"description" => __("This option is global, if you activate it, all rows in this page will be used as part of the full page scroll system.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			// VC Inner

			vc_add_param('vc_row_inner', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Custom ID", 'iv_js_composer'),
					"param_name" => "row_custom_id",
					"admin_label" => true,
					"value" => "",
					"description" => __("Custom Row ID attribute", 'iv_js_composer'),
				)
			);

			vc_add_param("vc_row_inner", array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Parallax Style",'iv_js_composer'),
				"param_name" => "row_parallax_style",
				"value" => array(
					__("Default",'iv_js_composer') => "parallax-none",
					__("Using Parallax Ratio",'iv_js_composer') => "parallax-vertical",
					//__("Interactive Parallax On Mouse Hover",'iv_js_composer') => "vcpb-fs-jquery",
					//__("Multilayer Vertical Parallax",'iv_js_composer') => "vcpb-mlvp-jquery",
				),
				"description" => __("To ensure parallax work properly, set 'Background Attachment' as 'fixed'.",'iv_js_composer'),
			));

				vc_add_param('vc_row_inner', array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Parallax Ratio", 'iv_js_composer'),
						"param_name" => "row_parallax_ratio",
						"admin_label" => true,
						"value" => "0.5",
						"description" => __("This defines the parallax velocity scaled based in natural scoll. Use values like 0.5, 0.8, 1.5, 2 and others.", 'iv_js_composer'),
						"dependency" => array("element" => "row_parallax_style","value" => array("parallax-vertical")),
					)
				);

			vc_add_param("vc_row_inner", array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background Color", 'iv_js_composer'),
				"param_name" => "row_bg_color",
				"value" => "",
				"description" => __("Select normal background color.", 'iv_js_composer'),
			));

			vc_add_param('vc_row_inner',array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Background Image", 'iv_js_composer'),
					"param_name" => "row_bg_image",
					"value" => "",
					"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Repeat", 'iv_js_composer'),
					"param_name" => "row_bg_repeat",
					"value" => array(
						'No Repeat' => "no-repeat",
						'Repeat X' => "repeat-x",
						'Repeat Y' => "repeat-y",
						'Repeat' => "repeat",
						),
					"description" => __("Select the way background image will repeat.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Position", 'iv_js_composer'),
					"param_name" => "row_bg_position",
					"value" => array(
						'Center/Center' => "center center",
						'Left/Top' => "left top",
						'Left/Center' => 'left center',
						'Left/Bottom' => 'left bottom',
						'Right/Top' => "right top",
						'Right/Center' => 'right center',
						'Right/Bottom' => 'right bottom',
						'Center/Top' => "center top",
						'Center/Bottom' => 'center bottom',
						),
					"description" => __("Select the way background image will be positioned. Horizontal/Vertical", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Size", 'iv_js_composer'),
					"param_name" => "row_bg_size",
					"value" => array(
						'Cover' => "cover",
						'Contain' => "contain",
						'Default' => "auto",
						),
					"description" => __("Select the way background image will be sized.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Background Attachment", 'iv_js_composer'),
					"param_name" => "row_bg_att",
					"value" => array(
						'Default' => "scroll",
						'Fixed' => "fixed",
						),
					"description" => __("Select the way background image will be attached to the page.", 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Video URL", 'iv_js_composer'),
					"param_name" => "row_video_url",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter your video URL. You can upload a video through <a href='".admin_url("media-new.php")."' target='_blank'>WordPress Media Library</a>, if not done already.", 'iv_js_composer'),
				)
			);

			vc_add_param("vc_row_inner", array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Overlay Color", 'iv_js_composer'),
				"param_name" => "row_overlay_color",
				"value" => "",
				"description" => __("Select overlay color.", 'iv_js_composer'),
			));

			vc_add_param('vc_row_inner',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Vertical Align?", 'iv_js_composer'),
					"param_name" => "row_enable_v_center",
					"value" => array(
						'No' => "",
						'Yes' => " v-center",
						),
					"description" => __("When enabled, the columns content will be vertically aligned.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner',array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Full Viewport Height?", 'iv_js_composer'),
					"param_name" => "row_full_height",
					"value" => array(
						'No' => "no",
						'Yes' => "yes",
						),
					"description" => __("When enabled, row will have same height than viewport/window.", 'iv_js_composer'),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row_inner', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Viewport Offsets", 'iv_js_composer'),
					"param_name" => "row_offsets",
					"admin_label" => true,
					"value" => "",
					"description" => __("Type the selectors to be offset in full viewport height calculation.", 'iv_js_composer'),
					"dependency" => array("element" => "row_full_height", "value" => array("yes")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

		}

		// Admin Scripts
		function admin_scripts() {

		}

		// Front End Scripts
		static function front_scripts() {

		}



	} // #end class

	// Ignition!
	$ivan_vc_row = new Ivan_VC_Row();

	if ( !function_exists( 'vc_theme_before_vc_row' ) ) {
		function vc_theme_before_vc_row($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_row' ) ) {
		function vc_theme_after_vc_row($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_shortcode_after', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_before_vc_row_inner' ) ) {
		function vc_theme_before_vc_row_inner($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_inner_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_row_inner' ) ) {
		function vc_theme_after_vc_row_inner($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check