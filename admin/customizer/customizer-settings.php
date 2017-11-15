<?php

/* ==============================
  Site title & Tagline
  =============================== */

//Hide tagline
$wp_customize->add_setting( 'canis_hide_tagline', array(
	'default'           => 0,
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'canis_sanitize_checkboxes',
) );

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize, 'canis_hide_tagline', array(
			'label'    => esc_html__( 'Hide Tagline', 'canis' ),
			'section'  => 'title_tagline',
			'settings' => 'canis_hide_tagline',
			'type'     => 'checkbox',
		)
	)
);

/* * ************************ GENERAL ************************** */

$wp_customize->add_panel( 'canis_general_panel', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => esc_html__( 'General', 'canis' ),
) );

/* ==============================
  SIDEBAR POSITIONS
  =============================== */

$wp_customize->add_section( 'canis_sidebar_position_section', array(
	'title'       => esc_html__( 'Sidebar Position', 'canis' ),
	'capability'  => 'edit_theme_options',
	'description' => '', //Descriptive tooltip
	'panel'       => 'canis_general_panel',
) );

$wp_customize->add_setting( 'canis_sidebar_position', array(
	'default'           => 'right',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'canis_sanitize_choices',
) );

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize, 'canis_sidebar_position', array(
			'label'    => esc_html__( 'Sidebar Position', 'canis' ),
			'section'  => 'canis_sidebar_position_section',
			'settings' => 'canis_sidebar_position',
			'type'     => 'radio',
			'choices'  => array(
				'left'       => esc_html__( 'Left', 'canis' ),
				'right'      => esc_html__( 'Right', 'canis' ),
				'no_sidebar' => esc_html__( 'No Sidebar', 'canis' ),
			)
		)
	)
);

/* ==============================
  Footer Copyright Text
  =============================== */

$wp_customize->add_section( 'canis_copyright_text_section', array(
	'title'       => esc_html__( 'Copyright Text', 'canis' ),
	'capability'  => 'edit_theme_options',
	'description' => esc_html__( 'Will override the footer copyright text', 'canis' ), //Descriptive tooltip
	'panel'       => 'canis_general_panel',
) );


//SPECIAL FONTS
$wp_customize->add_setting( 'canis_copyright_text', array(
	'default'           => '',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control(
	'canis_copyright_text', array(
		'label'    => esc_html__( 'Copyright Text', 'canis' ),
		'section'  => 'canis_copyright_text_section',
		'settings' => 'canis_copyright_text',
		'type'     => 'text',
	)
);

//4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
$wp_customize->remove_control( 'header_image' );
// $wp_customize->remove_control('header_textcolor');
