<?php

/**
 * IMPORTANT: Place this file code under customizer-settings.php to enable slider settings
 * And call slider.php file where you want to display slider
 */

/*==============================
            SLIDER
  ===============================*/

  $wp_customize->add_panel( 'canis_pannel', array(
      'priority'       => 10,
      'capability'     => 'edit_theme_options',
      'title'          => __( 'Slider Options', 'canis' ),
      'description'    => __( 'Add slider', 'canis' ),
  ) );

  for ( $i=1; $i <= 8; $i++ )
  {
    $wp_customize->add_section( 'canis_section_' . $i, array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'title'          => sprintf( __( 'Slide %s' , 'canis' ), $i ),
        'description'    => __( 'Add slide', 'canis' ),
        'panel'          => 'canis_pannel',
    ) );

    $wp_customize->add_setting( 'canis_slides['.$i.'][title]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'canis_slides['.$i.'][title]', array(
        'priority' => 10,
        'section'  => 'canis_section_' . $i,
        'label'    => __( 'Title', 'canis' ),
        'settings' => 'canis_slides['.$i.'][title]',
    ) );

    $wp_customize->add_setting( 'canis_slides['.$i.'][description]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'canis_slides['.$i.'][description]', array(
        'priority' => 10,
        'section'  => 'canis_section_' . $i,
        'label'    => __('Description', 'canis' ),
        'settings' => 'canis_slides['.$i.'][description]',
    ) );

    $wp_customize->add_setting( 'canis_slides['.$i.'][link]', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_control( 'canis_slides['.$i.'][link]', array(
        'priority' => 10,
        'section'  => 'canis_section_' . $i,
        'label'    => __( 'Link', 'canis' ),
        'settings' => 'canis_slides['.$i.'][link]',
    ) );

    $wp_customize->add_setting( 'canis_slides['.$i.'][image]', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control ( $wp_customize, 'canis_slides['.$i.'][image]', array(
        'priority' => 10,
        'section'  => 'canis_section_' . $i,
        'label'    => __( 'Image', 'canis' ),
        'settings' => 'canis_slides['.$i.'][image]',
    ) ) );

  }
