<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package russianroulette
 */


if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_57f0083a03bd3',
		'title' => 'Introduction',
		'fields' => array (
			array (
				'key' => 'field_5293bb92d056e',
				'label' => 'Introduction',
				'name' => 'introduction',
				'type' => 'wysiwyg',
				'instructions' => 'Enter your post intro here. Try to keep to approx. 2 lines / 30 words or it may affect the layout!',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 0,
				'tabs' => 'all',
			),
			array (
				'key' => 'field_5293bb92d056e',
				'label' => 'Introduction',
				'name' => 'introduction',
				'type' => 'wysiwyg',
				'instructions' => 'Enter your post intro here. Try to keep to approx. 2 lines / 30 words or it may affect the layout!',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 0,
				'tabs' => 'all',
			),
			array (
				'key' => 'field_5293bb92d056e',
				'label' => 'Introduction',
				'name' => 'introduction',
				'type' => 'wysiwyg',
				'instructions' => 'Enter your post intro here. Try to keep to approx. 2 lines / 30 words or it may affect the layout!',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 0,
				'tabs' => 'all',
			),
			array (
				'key' => 'field_5293bb92d056e',
				'label' => 'Introduction',
				'name' => 'introduction',
				'type' => 'wysiwyg',
				'instructions' => 'Enter your post intro here. Try to keep to approx. 2 lines / 30 words or it may affect the layout!',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 0,
				'tabs' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array (
		),
		'active' => 1,
		'description' => '',
		'old_ID' => 34,
	));





	acf_add_local_field_group(array (
		'key' => 'group_57f0083a15432',
		'title' => 'Post Type',
		'fields' => array (
			array (
				'key' => 'field_52b75069a90e6',
				'label' => 'Post Type',
				'name' => 'posttype',
				'type' => 'select',
				'instructions' => 'Please select a post type to allow the site to filter posts correctly',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array (
					'review' => 'Review',
					'report' => 'Report',
					'news' => 'News',
					'longform' => 'Longform',
					'interview' => 'Interview',
					'gallery' => 'Gallery',
				),
				'default_value' => array (
					0 => 'Review',
					1 => 'Report',
					2 => 'News',
					3 => 'Longform',
					4 => 'Interview',
					5 => 'Gallery',
				),
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'placeholder' => '',
				'return_format' => 'value',
			),
			array (
				'key' => 'field_',
				'label' => '',
				'name' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array (
		),
		'active' => 1,
		'description' => '',
		'old_ID' => 154,
	));

 endif;
