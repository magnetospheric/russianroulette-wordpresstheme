<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package russianroulette
 */


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_57f010287b133',
	'title' => 'Writer Info',
	'fields' => array (
		array (
			'key' => 'field_57f0103c68d83',
			'label' => 'Short Bio',
			'name' => 'short_bio',
			'type' => 'text',
			'instructions' => 'A short bio to appear in the sidebar.
Examples:
"Editor, Games"
or
"Writer of all things comic book related"',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array (
			'key' => 'field_57f02bb371f23',
			'label' => 'Extended Bio',
			'name' => 'extended_bio',
			'type' => 'wysiwyg',
			'instructions' => 'A longer bio that appears on your Author page. This will appear after your name, and above your social media links.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 0,
		),
		array (
			'key' => 'field_57f0148f68d83',
			'label' => 'Social media links',
			'name' => 'social_media_links',
			'type' => 'flexible_content',
			'instructions' => 'Add links to your social media channels or personal websites here.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => 'Add Row',
			'min' => 1,
			'max' => 10,
			'layouts' => array (
				array (
					'key' => '57f01948d50d3',
					'name' => 'new_link',
					'label' => 'New link',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_57f0194b5dda3',
							'label' => 'Link',
							'name' => 'link',
							'type' => 'url',
							'instructions' => 'Paste the full url of the site you wish to link to here.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
						),
						array (
							'key' => 'field_57f019585dda3',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
							'instructions' => 'A short title describing what sortt of link it is. Example: "My youtube channel:"',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
					'min' => '1',
					'max' => '10',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'all',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_57f0083a1d693',
	'title' => 'Writer Avatars',
	'fields' => array (
		array (
			'key' => 'field_57f0033d91983',
			'label' => 'Author Photo',
			'name' => 'author_photo',
			'type' => 'image',
			'instructions' => 'Upload a square ratio photo of yourself: this will appear alongside your author name in articles and in the author list.
100px by 100px is preferred, and real photos are preferred over illustrations.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'array',
			'min_width' => 0,
			'min_height' => 0,
			'min_size' => 0,
			'max_width' => 0,
			'max_height' => 0,
			'max_size' => 0,
			'mime_types' => '',
		),
		array (
			'key' => 'field_57f008f51c283',
			'label' => 'Extra Author Photos',
			'name' => 'extra_author_photos',
			'type' => 'flexible_content',
			'instructions' => 'These photos will show up on your author information page only. They\'re not mandatory, but are useful if you\'re a cosplayer, LARPer or otherwise and want to showcase some more of what you\'re about, especially if you\'re also writing articles on the subject.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => 'Add Row',
			'min' => 1,
			'max' => 10,
			'layouts' => array (
				array (
					'key' => '57f0184eae823',
					'name' => 'custom_author_photo',
					'label' => 'Custom Author Photo',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_57f018654f013',
							'label' => 'Photo',
							'name' => 'photo',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
							'min_width' => 100,
							'min_height' => 100,
							'min_size' => '',
							'max_width' => 1500,
							'max_height' => 1500,
							'max_size' => 2,
							'mime_types' => '',
						),
						array (
							'key' => 'field_57f0187f4f013',
							'label' => 'Tagline',
							'name' => 'tagline',
							'type' => 'text',
							'instructions' => 'A short tagline. Example: " AUTHOR NAME in cosplay"',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
					'min' => '1',
					'max' => '10',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'all',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
