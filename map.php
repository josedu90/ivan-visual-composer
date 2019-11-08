<?php
/***
 * File used to map all our shortcodes attributes to Visual Composer use
 * all attributes and Customizer Params are all placed here as well.
 *
 * This file is called at ivan_vc_extend.php inside init WP filter.
 **/

/***
 * Useful Infos
***/
	$categories = get_terms("ivan_vc_projects_cats");
	$cats = array('All' => '');

	if(0 < count($categories)) {
		foreach ($categories as $cat) {
			$cats[$cat->name] = $cat->slug;
		}
	}

	$portfolios = get_terms("ivan_vc_projects_portfolios");
	$ports = array('All' => '');
	if(0 < count($portfolios)) {
		foreach ($portfolios as $port) {
			$ports[$port->name] = $port->slug;
		}
	}

	$ivan_add_css_animation = array(
		'type' => 'dropdown',
		'heading' => __( 'CSS Animation', 'iv_js_composer' ),
		'param_name' => 'css_animation',
		'admin_label' => true,
		'value' => array(
			__( 'No', 'iv_js_composer' ) => '',
			__( 'Top to bottom', 'iv_js_composer' ) => 'top-to-bottom',
			__( 'Bottom to top', 'iv_js_composer' ) => 'bottom-to-top',
			__( 'Left to right', 'iv_js_composer' ) => 'left-to-right',
			__( 'Right to left', 'iv_js_composer' ) => 'right-to-left',
			__( 'Appear from center', 'iv_js_composer' ) => "appear"
		),
		'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'iv_js_composer' )
	  );

/***
 * Projects
***/

	// Call global var to use selectors array
	global $ivan_vc_projects;

	vc_map(
		array(
			'name' => __('Projects', '_sdomain'),
			'base' => 'ivan_projects',
			'icon' => 'vc_info_box',
			'class' => 'ivan_projects',
			'category' => 'VC Customizer',
			'description' => 'Display a grid or carousel of your projects',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Posts", 'iv_js_composer'),
					"param_name" => "ivan_posts_per_page",
					"value" => '10',
					"description" => __("Number of entries to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Specific Category", 'iv_js_composer'),
					"param_name" => "ivan_category",
					"value" => $cats,
					"description" => __("Select a specific category to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Specific Portfolio", 'iv_js_composer'),
					"param_name" => "ivan_portfolio",
					"value" => $ports,
					"description" => __("Select a specific portfolio to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"heading" => __("Image Size", 'iv_js_composer'),
					"param_name" => "ivan_img_size",
					"value" => ivan_vc_img_sizes(),
					"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Columns", 'iv_js_composer'),
					"param_name" => "ivan_columns",
					"value" => array(
						'Four' => '4',
						'Three' => '3',
						'Two' => '2',
						'One' => '1',
					),
					"description" => __("Select the columns layout to be applied.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'iv_js_composer'),
					"param_name" => "ivan_type",
					"value" => array(
						'Mansory' => 'mansory',
						'Grid' => 'grid',
						'Carousel' => 'carousel'
					),
					"description" => __("Select the style to display the items.", 'iv_js_composer'),
				),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable special sizes?", 'iv_js_composer'),
						"param_name" => "ivan_enable_sizes",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						"description" => __("Display special sizes defined by tags 'full', 'double-width', 'double-height' and 'half-height' in the projects.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'mansory'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable sortable filters?", 'iv_js_composer'),
						"param_name" => "ivan_sortable_filters",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						"description" => __("Display filters above the items.", 'iv_js_composer'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Navigation?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_nav",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						"description" => __("Display directional arrows in carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Bullets?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_bullets",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						"description" => __("Display bullets bellow carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Margin", 'iv_js_composer'),
					"param_name" => "ivan_margin",
					"value" => array(
						'Default Margin' => '',
						'No Margin' => ' no-margin',
					),
					"description" => __("Select if items will have margins in items or not.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover Type", 'iv_js_composer'),
					"param_name" => "ivan_cover",
					"value" => array(
						'Default' => '',
						'Inside Bottom' => ' hide-entry',
						'Inside Full' => ' cover-entry',
					),
					"description" => __("Define how the infos will be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover appear only at hover?", 'iv_js_composer'),
					"param_name" => "ivan_cover_hover",
					"value" => array(
						'Yes' => ' appear-hover',
						'No' => ' no-appear-hover',
					),
					"description" => __("Only display cover at hover.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_cover', 'value' => ' cover-entry'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Opacity", 'iv_js_composer'),
					"param_name" => "ivan_opacity",
					"value" => array(
						'No' => ' no-opacity-hover',
						'Yes' => ' opacity-hover',
					),
					"description" => __("Apply opacity to item when not hovered.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Zoom", 'iv_js_composer'),
					"param_name" => "ivan_zoom",
					"value" => array(
						'Yes' => ' zoom-hover',
						'No' => ' no-zoom',
					),
					"description" => __("Apply zoom when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Grayscale", 'iv_js_composer'),
					"param_name" => "ivan_grayscale",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Apply grayscale effect in image and back to normal when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Item Height", 'iv_js_composer'),
					"param_name" => "ivan_custom_height",
					"description" => __("Enter a custom height to the items like '300' or '250'", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Entry Infos?", 'iv_js_composer'),
					"param_name" => "ivan_enable_cover",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("Define if infos like title, read more and excerpt will be displayed or not.", 'iv_js_composer'),
				),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Family", 'iv_js_composer'),
						"param_name" => "ico_family",
						"value" => array(
							'Font Awesome' => 'fa fa-',
							'Elegant Icons' => 'el el-',
							'Custom' => 'custom',
						),
						"description" => __("Select the icon family.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Custom Icon Class", 'iv_js_composer'),
						"param_name" => "ico_custom",
						"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Icon Name", 'iv_js_composer'),
						"param_name" => "ico",
						"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable title?", 'iv_js_composer'),
						"param_name" => "ivan_enable_title",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable filters/categories?", 'iv_js_composer'),
						"param_name" => "ivan_enable_categories",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable excerpt?", 'iv_js_composer'),
						"param_name" => "ivan_enable_excerpt",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), /////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable read more button?", 'iv_js_composer'),
						"param_name" => "ivan_enable_read_more",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Read More Button Text", 'iv_js_composer'),
						"param_name" => "ivan_enable_read_more_txt",
						"value" => 'READ MORE',
						'dependency' => array('element' => 'ivan_enable_read_more', 'value' => 'yes'),
					), ////
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("When click in project:", 'iv_js_composer'),
					"param_name" => "ivan_open",
					"value" => array(
						'Default' => '',
						'Lightbox' => 'lightbox',
						//'AJAX Box' => 'ajax',
					),
					"description" => __("What do when user clicks in a project? Default is follow the link normally.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Thumbnail", 'iv_js_composer'),
					"param_name" => "thumb_css",
					"customize" => $ivan_vc_projects->selectors['thumb_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Entry Infos", 'iv_js_composer'),
					"param_name" => "entry_css",
					"customize" => $ivan_vc_projects->selectors['entry_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_projects->selectors['title_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Categories/Filters", 'iv_js_composer'),
					"param_name" => "cats_css",
					"customize" => $ivan_vc_projects->selectors['cats_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Excerpt", 'iv_js_composer'),
					"param_name" => "excerpt_css",
					"customize" => $ivan_vc_projects->selectors['excerpt_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Read More Button", 'iv_js_composer'),
					"param_name" => "read_more_css",
					"customize" => $ivan_vc_projects->selectors['read_more_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_projects->selectors['icon_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Filters", 'iv_js_composer'),
					"param_name" => "filter_css",
					"customize" => $ivan_vc_projects->selectors['filter_css'],
					"value" => "",
					"group" => __('Filters', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Bullets Navigation", 'iv_js_composer'),
					"param_name" => "bullets_css",
					"customize" => $ivan_vc_projects->selectors['bullets_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Arrows Navigation", 'iv_js_composer'),
					"param_name" => "navigation_css",
					"customize" => $ivan_vc_projects->selectors['navigation_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
			),
		)
	);

/***
 * Posts
***/
	// Call global var to use selectors array
	global $ivan_vc_posts;

	vc_map(
		array(
			'name' => __('Posts', '_sdomain'),
			'base' => 'ivan_posts',
			'icon' => 'vc_info_box',
			'class' => 'ivan_posts',
			'category' => 'VC Customizer',
			'description' => 'Display a grid or carousel of your posts',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
				    "type" => "loop",
				    "heading" => __("Content", 'iv_js_composer'),
				    "param_name" => "loop",
				    'settings' => array(
				        'size' => array('hidden' => false, 'value' => 10),
				        'order_by' => array('value' => 'date'),
				    ),
				    "description" => __("Create WordPress loop, to populate content from your site.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"heading" => __("Image Size", 'iv_js_composer'),
					"param_name" => "ivan_img_size",
					"value" => ivan_vc_img_sizes(),
					"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Columns", 'iv_js_composer'),
					"param_name" => "ivan_columns",
					"value" => array(
						'Four' => '4',
						'Three' => '3',
						'Two' => '2',
						'One' => '1',
					),
					"description" => __("Select the columns layout to be applied.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'iv_js_composer'),
					"param_name" => "ivan_type",
					"value" => array(
						'Mansory' => 'mansory',
						'Grid' => 'grid',
						'Carousel' => 'carousel'
					),
					"description" => __("Select the style to display the items.", 'iv_js_composer'),
				),
					/*
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable special sizes?", 'iv_js_composer'),
						"param_name" => "ivan_enable_sizes",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						"description" => __("Display special sizes defined by tags 'full', 'double' and 'half-height' in the projects.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'mansory'),
					),
					*/
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Navigation?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_nav",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						"description" => __("Display directional arrows in carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Bullets?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_bullets",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						"description" => __("Display bullets bellow carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Margin", 'iv_js_composer'),
					"param_name" => "ivan_margin",
					"value" => array(
						'Default Margin' => '',
						'No Margin' => ' no-margin',
					),
					"description" => __("Select if items will have margins in items or not.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover Type", 'iv_js_composer'),
					"param_name" => "ivan_cover",
					"value" => array(
						'Default' => '',
						'Inside Bottom' => ' hide-entry',
						'Inside Full' => ' cover-entry',
					),
					"description" => __("Define how the infos will be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover appear only at hover?", 'iv_js_composer'),
					"param_name" => "ivan_cover_hover",
					"value" => array(
						'Yes' => ' appear-hover',
						'No' => ' no-appear-hover',
					),
					"description" => __("Only display cover at hover.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_cover', 'value' => ' cover-entry'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Opacity", 'iv_js_composer'),
					"param_name" => "ivan_opacity",
					"value" => array(
						'No' => ' no-opacity-hover',
						'Yes' => ' opacity-hover',
					),
					"description" => __("Apply opacity to item when not hovered.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Zoom", 'iv_js_composer'),
					"param_name" => "ivan_zoom",
					"value" => array(
						'Yes' => ' zoom-hover',
						'No' => ' no-zoom',
					),
					"description" => __("Apply zoom when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Grayscale", 'iv_js_composer'),
					"param_name" => "ivan_grayscale",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Apply grayscale effect in image and back to normal when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Item Height", 'iv_js_composer'),
					"param_name" => "ivan_custom_height",
					"description" => __("Enter a custom height to the items like '300' or '250'", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Thumbnail?", 'iv_js_composer'),
					"param_name" => "ivan_enable_thumb",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("Define if thumbnail will be displayed or not.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Entry Infos?", 'iv_js_composer'),
					"param_name" => "ivan_enable_cover",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("Define if infos like title, read more and excerpt will be displayed or not.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable title?", 'iv_js_composer'),
					"param_name" => "ivan_enable_title",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
				), ////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Date?", 'iv_js_composer'),
						"param_name" => "ivan_enable_categories",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable excerpt?", 'iv_js_composer'),
						"param_name" => "ivan_enable_excerpt",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), /////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable read more button?", 'iv_js_composer'),
						"param_name" => "ivan_enable_read_more",
						"value" => array(
							'No' => 'no',
							'Yes' => 'yes',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Read More Button Text", 'iv_js_composer'),
						"param_name" => "ivan_enable_read_more_txt",
						"value" => 'READ MORE',
						'dependency' => array('element' => 'ivan_enable_read_more', 'value' => 'yes'),
					), ////
					array(
						"type" => "textfield",
						"heading" => __("Extra class name", 'iv_js_composer'),
						"param_name" => "el_class",
						"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
					),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Thumbnail", 'iv_js_composer'),
					"param_name" => "thumb_css",
					"customize" => $ivan_vc_posts->selectors['thumb_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Entry Infos", 'iv_js_composer'),
					"param_name" => "entry_css",
					"customize" => $ivan_vc_posts->selectors['entry_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_posts->selectors['title_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Date", 'iv_js_composer'),
					"param_name" => "cats_css",
					"customize" => $ivan_vc_posts->selectors['cats_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Excerpt", 'iv_js_composer'),
					"param_name" => "excerpt_css",
					"customize" => $ivan_vc_posts->selectors['excerpt_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Read More Button", 'iv_js_composer'),
					"param_name" => "read_more_css",
					"customize" => $ivan_vc_posts->selectors['read_more_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Bullets Navigation", 'iv_js_composer'),
					"param_name" => "bullets_css",
					"customize" => $ivan_vc_posts->selectors['bullets_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Arrows Navigation", 'iv_js_composer'),
					"param_name" => "navigation_css",
					"customize" => $ivan_vc_posts->selectors['navigation_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
			),
		)
	);

/***
 * Image Block
***/
	// Call global var to use selectors array
	global $ivan_vc_image_block;

	vc_map(
		array(
			'name' => __('Image Block', '_sdomain'),
			'base' => 'ivan_image_block',
			'icon' => 'vc_info_box',
			'class' => 'ivan_image_block',
			'category' => 'VC Customizer',
			'description' => 'Display a block with image as background and an editable cover.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Background Image", 'iv_js_composer'),
					"param_name" => "ivan_bg_img",
					"value" => "",
					"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"heading" => __("Image Size", 'iv_js_composer'),
					"param_name" => "ivan_img_size",
					"value" => ivan_vc_img_sizes(),
					"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover appear only at hover?", 'iv_js_composer'),
					"param_name" => "ivan_cover_hover",
					"value" => array(
						'Yes' => ' appear-hover',
						'No' => ' no-appear-hover',
					),
					"description" => __("Only display cover at hover.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_cover', 'value' => ' cover-entry'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Item Height", 'iv_js_composer'),
					"param_name" => "ivan_custom_height",
					"description" => __("Enter a custom height to the items like '300' or '250'", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Entry Infos?", 'iv_js_composer'),
					"param_name" => "ivan_enable_cover",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("Define if infos like title, read more and excerpt will be displayed or not.", 'iv_js_composer'),
				),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Link URL", 'iv_js_composer'),
						"param_name" => "ivan_cover_link",
						"value" => '',
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Title", 'iv_js_composer'),
						"param_name" => "ivan_cover_title",
						"value" => '',
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "textarea",
						"class" => "",
						"heading" => __("Excerpt", 'iv_js_composer'),
						"param_name" => "ivan_cover_excerpt",
						"value" => '',
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Read More Button Text", 'iv_js_composer'),
						"param_name" => "ivan_cover_read_more",
						"value" => 'READ MORE',
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => 'yes'),
					), ////
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				////
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "block_css",
					"customize" => $ivan_vc_image_block->selectors['block_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Thumbnail", 'iv_js_composer'),
					"param_name" => "thumb_css",
					"customize" => $ivan_vc_image_block->selectors['thumb_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Entry Infos", 'iv_js_composer'),
					"param_name" => "entry_css",
					"customize" => $ivan_vc_image_block->selectors['entry_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_image_block->selectors['title_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Excerpt", 'iv_js_composer'),
					"param_name" => "excerpt_css",
					"customize" => $ivan_vc_image_block->selectors['excerpt_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Read More Button", 'iv_js_composer'),
					"param_name" => "read_more_css",
					"customize" => $ivan_vc_image_block->selectors['read_more_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
			),
		)
	);

/***
 * Carousel
***/
	// Call global var to use selectors array
	global $ivan_vc_carousel;

	vc_map( array(
		"name" => __("Content Carousel", 'iv_js_composer'),
		"base" => "ivan_carousel",
		'icon' => 'vc_info_box',
		//"as_parent" => array('only' => 'vc_column'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		"is_container" => true,
		"content_element" => true,
		"show_settings_on_create" => false,
		'category' => 'VC Customizer',
		'description' => 'Use to display other modules inside a carousel.',
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Number of Columns", 'iv_js_composer'),
				"param_name" => "ivan_columns",
				"value" => '1',
				"description" => __("Number of items the carousel will display.", 'iv_js_composer'),
			),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Normal Desktop)", 'iv_js_composer'),
					"param_name" => "ivan_columns_desktop",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <1199px - 4 items.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Small Desktop)", 'iv_js_composer'),
					"param_name" => "ivan_columns_desktop_small",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <980px - 3 items.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Tablet)", 'iv_js_composer'),
					"param_name" => "ivan_columns_tablet",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <768px - 2 items.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Mobile)", 'iv_js_composer'),
					"param_name" => "ivan_columns_mobile",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <479px - 1 item.", 'iv_js_composer'),
				),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Navigation?", 'iv_js_composer'),
				"param_name" => "ivan_carousel_nav",
				"value" => array(
					'No' => 'no',
					'Yes' => 'yes',
				),
				"description" => __("Display directional arrows in carousel when activated.", 'iv_js_composer'),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Bullets?", 'iv_js_composer'),
				"param_name" => "ivan_carousel_bullets",
				"value" => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				"description" => __("Display bullets bellow carousel when activated.", 'iv_js_composer'),
			),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Horizontal Bullets Position", 'iv_js_composer'),
					"param_name" => "ivan_bullets_h",
					"value" => array(
						'Default' => '',
						'Center' => 'h-center',
						'Left' => 'h-left',
						'Right' => 'h-right',
					),
					"description" => __("Align properly the carousel bullets.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_carousel_bullets', 'value' => 'yes'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Vertical Bullets Position", 'iv_js_composer'),
					"param_name" => "ivan_bullets_v",
					"value" => array(
						'Default' => '',
						'Inside Bottom' => 'v-bottom',
						'Inside Top' => 'v-top',
					),
					"description" => __("Align properly the carousel bullets.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_carousel_bullets', 'value' => 'yes'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Only show arrows at hover?", 'iv_js_composer'),
					"param_name" => "arrows_hover",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("If enabled, arrows will be displayed only when user hover the carousel.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable mouse drag?", 'iv_js_composer'),
					"param_name" => "mouse_drag",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("If enabled, user will be able to drag in order to slide the carousel.", 'iv_js_composer'),
				),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Bullets Navigation", 'iv_js_composer'),
				"param_name" => "bullets_css",
				"customize" => $ivan_vc_carousel->selectors['bullets_css'],
				"value" => "",
				"group" => __('Carousel', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Arrows Navigation", 'iv_js_composer'),
				"param_name" => "navigation_css",
				"customize" => $ivan_vc_carousel->selectors['navigation_css'],
				"value" => "",
				"group" => __('Carousel', 'iv_js_composer'),
			),
		),
		"js_view" => 'VcColumnView'
	) );

/***
 * Pricing Table
***/
	// Call global var to use selectors array
	global $ivan_vc_pricing_table;

	vc_map(
		array(
			'name' => __('Pricing Table', '_sdomain'),
			'base' => 'ivan_pricing',
			'icon' => 'vc_info_box',
			'class' => 'ivan_pricing_table',
			'category' => 'VC Customizer',
			'description' => 'Display a styled pricing table.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Style", 'iv_js_composer'),
					"param_name" => "template",
					"value" => array(
						'Default' => 'default',
						'Big Price' => 'big-price',
						'Simple with Image' => 'simple-image',
						'Big Button' => 'big-button',
						'Description' => 'description-support',
						'Sub Title' => 'subtitle',
					),
					"description" => __("Select the style to be applied in the pricing table.", 'iv_js_composer'),
				),
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Items", 'iv_js_composer'),
					"param_name" => "content",
					"value" => '<ul><li>Item</li><li>Item</li><li>Item</li></ul>',
					"description" => __("Insert here an unordered list/ul to display the items.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Image?", 'iv_js_composer'),
					"param_name" => "image_support",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("If enabled, you can upload an image to appear at top.", 'iv_js_composer'),
				),
					array(
						"type" => "attach_image",
						"class" => "",
						"heading" => __("Background Image", 'iv_js_composer'),
						"param_name" => "image_id",
						"value" => "",
						"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
						'dependency' => array('element' => 'image_support', 'value' => 'yes'),
					),
				array(
					"type" => "textfield",
					"heading" => __("Plan Title", 'iv_js_composer'),
					"param_name" => "title",
					"value" => "Starter",
					"description" => __("The main plan title displayed at top.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "subtitle",
					"value" => "Unlimited support and updates",
					"description" => __("Displayed below title when supported by the template.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Price Value ", 'iv_js_composer'),
					"param_name" => "price",
					"value" => "19",
					"description" => __("Price without currency.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Currency", 'iv_js_composer'),
					"param_name" => "currency",
					"value" => "$",
					"description" => __("The currency displayed aside price.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Period", 'iv_js_composer'),
					"param_name" => "period",
					"value" => "/month",
					"description" => __("The plan period that is displayed when supported by template.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Button Link", 'iv_js_composer'),
					"param_name" => "link",
					"value" => "#",
					"description" => __("Button link. Leave blank and the button won't be displayed.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Button Text", 'iv_js_composer'),
					"param_name" => "button_text",
					"value" => "Get this now",
					"description" => __("Button text to be displayed.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				// Customizer
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Table", 'iv_js_composer'),
					"param_name" => "table_css",
					"customize" => $ivan_vc_pricing_table->selectors['table_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Top Section", 'iv_js_composer'),
					"param_name" => "top_section_css",
					"customize" => $ivan_vc_pricing_table->selectors['top_section_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Content Section", 'iv_js_composer'),
					"param_name" => "content_section_css",
					"customize" => $ivan_vc_pricing_table->selectors['content_section_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Bottom Section", 'iv_js_composer'),
					"param_name" => "bottom_section_css",
					"customize" => $ivan_vc_pricing_table->selectors['bottom_section_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				// -- Inner Elements
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Plan Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_pricing_table->selectors['title_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Plan Subtitle", 'iv_js_composer'),
					"param_name" => "subtitle_css",
					"customize" => $ivan_vc_pricing_table->selectors['subtitle_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Currency", 'iv_js_composer'),
					"param_name" => "currency_css",
					"customize" => $ivan_vc_pricing_table->selectors['currency_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Price", 'iv_js_composer'),
					"param_name" => "price_css",
					"customize" => $ivan_vc_pricing_table->selectors['price_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Period", 'iv_js_composer'),
					"param_name" => "period_css",
					"customize" => $ivan_vc_pricing_table->selectors['period_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Items", 'iv_js_composer'),
					"param_name" => "items_css",
					"customize" => $ivan_vc_pricing_table->selectors['items_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Strong", 'iv_js_composer'),
					"param_name" => "strong_css",
					"customize" => $ivan_vc_pricing_table->selectors['strong_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Signup Button", 'iv_js_composer'),
					"param_name" => "signup_css",
					"customize" => $ivan_vc_pricing_table->selectors['signup_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),

			),// #params end
		)// #setting array end
	);// #map end

/***
 * Contact Form
***/
	// Call global var to use selectors array
	global $ivan_vc_contact_form;

	vc_map(
		array(
			'name' => __('Contact Form', '_sdomain'),
			'base' => 'ivan_contact',
			'icon' => 'vc_info_box',
			'class' => 'ivan_contact_form',
			'category' => 'VC Customizer',
			'description' => 'Display a contact form with customization support.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Contact Form Shortcode", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Insert here your contact form shortcode to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Label", 'iv_js_composer'),
					"param_name" => "label_css",
					"customize" => $ivan_vc_contact_form->selectors['label_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Inputs", 'iv_js_composer'),
					"param_name" => "input_css",
					"customize" => $ivan_vc_contact_form->selectors['input_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Submit", 'iv_js_composer'),
					"param_name" => "submit_css",
					"customize" => $ivan_vc_contact_form->selectors['submit_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Error Message", 'iv_js_composer'),
					"param_name" => "error_css",
					"customize" => $ivan_vc_contact_form->selectors['error_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Title Wrapper
***/
	// Call global var to use selectors array
	global $ivan_vc_title_wrapper;

	vc_map(
		array(
			'name' => __('Title Wrapper', '_sdomain'),
			'base' => 'ivan_title',
			'icon' => 'vc_info_box',
			'class' => 'ivan_title_wrapper',
			'category' => 'VC Customizer',
			'description' => 'Display a styled title wrapper great to create different titles types.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Define the text and icons to be displayed. Use strong tag to display the text highlighted. Shortcodes and HTML tags accepted.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Family", 'iv_js_composer'),
					"param_name" => "ico_family",
					"value" => array(
						'Font Awesome' => 'fa fa-',
						'Elegant Icons' => 'el el-',
						'Custom' => 'custom',
					),
					"description" => __("Select the icon family.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Icon Class", 'iv_js_composer'),
					"param_name" => "ico_custom",
					"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
					'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Icon Name", 'iv_js_composer'),
					"param_name" => "ico",
					"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Above Icon?", 'iv_js_composer'),
					"param_name" => "above_icon",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Display icon above title.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Default' => ' default-align',
						'Center' => ' to-center',
						'Left' => ' to-left',
						'Right' => ' to-right',
					),
					"description" => __("Select main alignment of title.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display", 'iv_js_composer'),
					"param_name" => "display",
					"value" => array(
						'Default' => ' default-display',
						'Inline' => ' inline-block',
					),
					"description" => __("Select the display type of title.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Mark", 'iv_js_composer'),
					"param_name" => "mark",
					"value" => array(
						'Default' => ' default-mark',
						'Center' => ' mark mark-center',
						'Left' => ' mark mark-left',
						'Right' => ' mark mark-right',
					),
					"description" => __("Select the alignment of the mark below the title.", 'iv_js_composer'),
				),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "sub",
					"description" => __("Define the text to be displayed below main title. Use strong tag to display the text highlighted. Shortcodes and HTML tags accepted.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_title_wrapper->selectors['title_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Highlight/Link", 'iv_js_composer'),
					"param_name" => "highlight_css",
					"customize" => $ivan_vc_title_wrapper->selectors['highlight_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "subtitle_css",
					"customize" => $ivan_vc_title_wrapper->selectors['subtitle_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Mark", 'iv_js_composer'),
					"param_name" => "mark_css",
					"customize" => $ivan_vc_title_wrapper->selectors['mark_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_title_wrapper->selectors['icon_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Testimonial
***/
	// Call global var to use selectors array
	global $ivan_vc_testimonial;

	vc_map(
		array(
			'name' => __('Testimonial', '_sdomain'),
			'base' => 'ivan_testimonial',
			'icon' => 'vc_info_box',
			'class' => 'ivan_testimonial',
			'category' => 'VC Customizer',
			'description' => 'Display a styled title wrapper great to create different titles types.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Testimonial", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("What did the customer said, here you define what will be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Quote Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Default' => ' default-align',
						'Center' => ' to-center',
						'Left' => ' to-left',
						'Right' => ' to-right',
					),
					"description" => __("Select main alignment of quote.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Meta Align", 'iv_js_composer'),
					"param_name" => "meta_align",
					"value" => array(
						'Default' => ' default-align',
						'Center' => ' to-center',
						'Left' => ' to-left',
						'Right' => ' to-right',
					),
					"description" => __("Select main alignment of meta.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Author", 'iv_js_composer'),
					"param_name" => "author",
					"description" => __("The author name, e.g. Carl James via Twitter.", 'iv_js_composer')
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Author Image", 'iv_js_composer'),
					"param_name" => "image_id",
					"value" => "",
					"description" => __("Upload or select background image from media gallery. Use a size like 100x100 for example.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Author Image Position", 'iv_js_composer'),
					"param_name" => "image_position",
					"value" => array(
						'Default' => 'default',
						'Left' => 'left',
						'Right' => 'right',
					),
					"description" => __("Select the optional position of author image.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "main_css",
					"customize" => $ivan_vc_testimonial->selectors['main_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Quote", 'iv_js_composer'),
					"param_name" => "quote_css",
					"customize" => $ivan_vc_testimonial->selectors['quote_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Author", 'iv_js_composer'),
					"param_name" => "meta_css",
					"customize" => $ivan_vc_testimonial->selectors['meta_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Image", 'iv_js_composer'),
					"param_name" => "img_css",
					"customize" => $ivan_vc_testimonial->selectors['img_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Staff
***/
	// Call global var to use selectors array
	global $ivan_vc_staff;

	// Social Icon List
	$ivan_icon_array = ivan_vc_staff_icons();

	$staff_icons_fields = array();

	foreach ($ivan_icon_array as $key => $value) {

		$staff_icons_fields[] = array(
			"type" => "textfield",
			"heading" => $value,
			"param_name" => $key,
			"description" => __("Type your social address with http:// prefix or other.", 'iv_js_composer'),
			"group" => __('Social Icons', 'iv_js_composer'),
		);
	}

	vc_map(
		array(
			'name' => __('Staff Member', '_sdomain'),
			'base' => 'ivan_staff',
			'icon' => 'vc_info_box',
			'class' => 'ivan_staff',
			'category' => 'VC Customizer',
			'description' => 'Display a staff member with support to effects and social icons.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array_merge( array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Optional description to this staff member.", 'iv_js_composer'),
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Staff Image", 'iv_js_composer'),
					"param_name" => "image_id",
					"value" => "",
					"description" => __("Upload or select a photo from media gallery.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Name", 'iv_js_composer'),
					"param_name" => "name",
					"description" => __("Type your staff member name.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Job Title", 'iv_js_composer'),
					"param_name" => "job_title",
					"description" => __("Type your staff member job title, e.g. Manager.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Infos Position", 'iv_js_composer'),
					"param_name" => "infos_inside",
					"value" => array(
						'Outside' => 'no',
						'Inside Thumbnail' => 'yes',
					),
					"description" => __("Select the name and job title position.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Social Icons Position", 'iv_js_composer'),
					"param_name" => "social_inside",
					"value" => array(
						'Outside' => 'no',
						'Inside Thumbnail' => 'yes',
					),
					"description" => __("Select the social icons position.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Overlay", 'iv_js_composer'),
					"param_name" => "overlay",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Enable the effect on this modules.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Opacity", 'iv_js_composer'),
					"param_name" => "opacity",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Enable the effect on this modules.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Grayscale", 'iv_js_composer'),
					"param_name" => "grayscale",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Enable the effect on this modules.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Default' => ' to-default',
						'Center' => ' to-center',
					),
					"description" => __("Define alignment of infos.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "main_css",
					"customize" => $ivan_vc_staff->selectors['main_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Image", 'iv_js_composer'),
					"param_name" => "image_css",
					"customize" => $ivan_vc_staff->selectors['image_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Name", 'iv_js_composer'),
					"param_name" => "name_css",
					"customize" => $ivan_vc_staff->selectors['name_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Job Title", 'iv_js_composer'),
					"param_name" => "job_title_css",
					"customize" => $ivan_vc_staff->selectors['job_title_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Content", 'iv_js_composer'),
					"param_name" => "content_css",
					"customize" => $ivan_vc_staff->selectors['content_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Social Icons", 'iv_js_composer'),
					"param_name" => "social_css",
					"customize" => $ivan_vc_staff->selectors['social_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			), $staff_icons_fields) ,// #params end
		)// #setting array end
	);// #map end

/***
 * Info Box
***/
	// Call global var to use selectors array
	global $ivan_vc_info_box;

	vc_map(
		array(
			'name' => __('Info Box', '_sdomain'),
			'base' => 'ivan_info_box',
			'icon' => 'vc_info_box',
			'class' => 'ivan_info_box',
			'category' => 'VC Customizer',
			'description' => 'Display a styled box with support to icons.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Insert here the description to be inserted in the info box.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Family", 'iv_js_composer'),
					"param_name" => "ico_family",
					"value" => array(
						'Font Awesome' => 'fa fa-',
						'Elegant Icons' => 'el el-',
						'Custom' => 'custom',
					),
					"description" => __("Select the icon family.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Icon Class", 'iv_js_composer'),
					"param_name" => "ico_custom",
					"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
					'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Custom Icon Image", 'iv_js_composer'),
					"param_name" => "ico_img",
					"value" => "",
					"description" => __("Upload a image to be used as icon.", 'iv_js_composer'),
					'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Icon Name", 'iv_js_composer'),
					"param_name" => "ico",
					"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title",
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Position", 'iv_js_composer'),
					"param_name" => "position",
					"value" => array(
						'Left' => 'left',
						'Right' => 'right',
						'Above/Top' => 'top',
					),
					"description" => __("Defines icon position in the box.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable V-Align?", 'iv_js_composer'),
					"param_name" => "vertical",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("When enabled, the icon will be vertically aligned.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Text Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Default' => ' default-align',
						'Center' => ' to-center',
						'Left' => ' to-left',
						'Right' => ' to-right',
					),
					"description" => __("Select main alignment of title and description.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Style", 'iv_js_composer'),
					"param_name" => "style",
					"value" => array(
						'None' => 'none',
						'Boxed' => 'boxed',
						'Circle' => 'circle',
					),
					"description" => __("Define icon style.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Size", 'iv_js_composer'),
					"param_name" => "size",
					"value" => array(
						'32x32' => '32',
						'64x64' => '64',
						'96x96' => '96',
						'128x128' => '128',
						'256x256' => '256',
					),
					"description" => __("Define icon wrapper size. You can customize the icon size in Customizer tab.", 'iv_js_composer'),
					'dependency' => array('element' => 'style', 'value' => array('boxed', 'circle') ),
				),
				$ivan_add_css_animation,
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "main_css",
					"customize" => $ivan_vc_info_box->selectors['main_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_info_box->selectors['icon_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_info_box->selectors['title_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "content_css",
					"customize" => $ivan_vc_info_box->selectors['content_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Button
***/
	// Call global var to use selectors array
	global $ivan_vc_button;

	vc_map(
		array(
			'name' => __('Styled Button', '_sdomain'),
			'base' => 'ivan_button',
			'icon' => 'vc_info_box',
			'class' => 'ivan_button',
			'category' => 'VC Customizer',
			'description' => 'Display a fully featured button with customizer support.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"heading" => __("Button Text", 'iv_js_composer'),
					"param_name" => "text",
					"description" => __("Optional text to be displayed in the button.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Link", 'iv_js_composer'),
					"param_name" => "link",
					"description" => __("Defines the link URL or anchor.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Target", 'iv_js_composer'),
					"param_name" => "target",
					"value" => array(
						'Same Page' => 'no',
						'Blank Page' => 'yes',
					),
					"description" => __("Define link target.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Size", 'iv_js_composer'),
					"param_name" => "size",
					"value" => array(
						'Default' => ' btn-default',
						'Large' => ' btn-lg',
						'Small' => ' btn-sm',
						'Extra Small' => ' btn-xs',
					),
					"description" => __("Define button size.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display", 'iv_js_composer'),
					"param_name" => "display",
					"value" => array(
						'Normal Width' => ' btn-inline',
						'Full Width' => ' btn-block',
					),
					"description" => __("Define button width.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Family", 'iv_js_composer'),
					"param_name" => "ico_family",
					"value" => array(
						'Font Awesome' => 'fa fa-',
						'Elegant Icons' => 'el el-',
						'Custom' => 'custom',
					),
					"description" => __("Select the icon family.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Icon Class", 'iv_js_composer'),
					"param_name" => "ico_custom",
					"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
					'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Icon Name", 'iv_js_composer'),
					"param_name" => "ico",
					"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Default' => ' default-align',
						'Center' => ' to-center',
						'Left' => ' to-left',
						'Right' => ' to-right',
					),
					"description" => __("Select main alignment of title.", 'iv_js_composer'),
				),
				$ivan_add_css_animation,
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Button", 'iv_js_composer'),
					"param_name" => "btn_css",
					"customize" => $ivan_vc_button->selectors['btn_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Table
***/
	// Call global var to use selectors array
	global $ivan_vc_table;

	vc_map(
		array(
			'name' => __('Styled Table', '_sdomain'),
			'base' => 'ivan_table',
			'icon' => 'vc_info_box',
			'class' => 'ivan_table',
			'category' => 'VC Customizer',
			'description' => 'Display an interface to customize tables.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Table", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Insert here the table to be displayed as content.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
			),// #params end
		)// #setting array end
	);// #map end


/***
 * WooCommerce
***/
	// Call global var to use selectors array
	global $ivan_vc_woo;

	vc_map(
		array(
			'name' => __('WooCommerce', '_sdomain'),
			'base' => 'ivan_woo',
			'icon' => 'vc_info_box',
			'class' => 'ivan_woo',
			'category' => 'VC Customizer',
			'description' => 'Display WooCommerce products easily.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display", 'iv_js_composer'),
					"param_name" => "code",
					"value" => array(
						'Recent' => 'recent_products',
						'Featured' => 'featured_products',
						'On Sale' => 'sale_products',
						'Best Selling' => 'best_selling_products',
						'Top Rated' => 'top_rated_products',
						'Products by ID' => 'products',
					),
					"description" => __("Define button size.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Per Page", 'iv_js_composer'),
					"param_name" => "per_page",
					"value" => "4",
					"description" => __("Defines the number of products to be displayed.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Columns", 'iv_js_composer'),
					"param_name" => "columns",
					"value" => array(
						"Four" => "4",
						"Three" => "3",
						"Two" => "2",
						"One" => "1",
					),
					"description" => __("Define columns numbers to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("IDs", 'iv_js_composer'),
					"param_name" => "ids",
					"description" => __("Comma separated products IDs to be displayed.", 'iv_js_composer'),
					'dependency' => array('element' => 'code', 'value' => 'products'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Tweet
***/
	// Call global var to use selectors array
	global $ivan_vc_tweet;

	vc_map(
		array(
			'name' => __('Latest Tweet', '_sdomain'),
			'base' => 'ivan_tweet',
			'icon' => 'vc_info_box',
			'class' => 'ivan_tweet',
			'category' => 'VC Customizer',
			'description' => 'Display your latest tweet.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Tweet", 'iv_js_composer'),
					"param_name" => "tweet_css",
					"customize" => $ivan_vc_tweet->selectors['tweet_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Tweet Date", 'iv_js_composer'),
					"param_name" => "meta_css",
					"customize" => $ivan_vc_tweet->selectors['meta_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end
		)// #setting array end
	);// #map end

/***
 * Separator
***/
	// Call global var to use selectors array
	global $ivan_vc_separator;

	vc_add_param('vc_text_separator',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Separator Text", 'iv_js_composer'),
			"param_name" => "separator_css",
			"customize" => $ivan_vc_separator->selectors['separator_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Toggle
***/
	// Call global var to use selectors array
	global $ivan_vc_toggle;

	vc_add_param('vc_toggle',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Toggle", 'iv_js_composer'),
			"param_name" => "toggle_css",
			"customize" => $ivan_vc_toggle->selectors['toggle_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_toggle',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_toggle->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Tabs
***/
	// Call global var to use selectors array
	global $ivan_vc_tabs;

	vc_add_param('vc_tabs',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Tabs", 'iv_js_composer'),
			"param_name" => "tabs_css",
			"customize" => $ivan_vc_tabs->selectors['tabs_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_tabs',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_tabs->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Tour
***/
	// Call global var to use selectors array
	global $ivan_vc_tour;

	vc_add_param('vc_tour',array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Disable Prev/Next Links?", 'iv_js_composer'),
			"param_name" => "disable_nav",
			"value" => array(
				__("No",'iv_js_composer') => " no-disable",
				__("Yes",'iv_js_composer') => " no-controls",
				),
		)
	);

	vc_add_param('vc_tour',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Tabs", 'iv_js_composer'),
			"param_name" => "tabs_css",
			"customize" => $ivan_vc_tour->selectors['tabs_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_tour',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_tour->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_tour',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Prev/Next Slide", 'iv_js_composer'),
			"param_name" => "prev_next_css",
			"customize" => $ivan_vc_tour->selectors['prev_next_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Accordion
***/
	// Call global var to use selectors array
	global $ivan_vc_accordion;

	vc_add_param('vc_accordion',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Toggle", 'iv_js_composer'),
			"param_name" => "toggle_css",
			"customize" => $ivan_vc_accordion->selectors['toggle_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_accordion',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_accordion->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Call to Action
***/
	// Call global var to use selectors array
	global $ivan_vc_calltoaction;

	vc_add_param('vc_cta_button2',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Main", 'iv_js_composer'),
			"param_name" => "main_css",
			"customize" => $ivan_vc_calltoaction->selectors['main_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_cta_button2',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Title", 'iv_js_composer'),
			"param_name" => "title_css",
			"customize" => $ivan_vc_calltoaction->selectors['title_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_cta_button2',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Sub Title", 'iv_js_composer'),
			"param_name" => "subtitle_css",
			"customize" => $ivan_vc_calltoaction->selectors['subtitle_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_cta_button2',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_calltoaction->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_cta_button2',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Button", 'iv_js_composer'),
			"param_name" => "btn_css",
			"customize" => $ivan_vc_calltoaction->selectors['btn_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);