<?php
/**
 * The main Kirki object
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Toolkit' ) ) {
	return;
}

final class Kirki_Toolkit {

	/** @var Kirki The only instance of this class */
	public static $instance = null;

	public static $version = '2.0.5';

	public $font_registry = null;
	public $scripts       = null;
	public $api           = null;
	public $styles        = array();

	/**
	 * Access the single instance of this class
	 * @return Kirki
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new Kirki_Toolkit();
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to get the translation strings
	 */
	public static function i18n() {

		$i18n = array(
			'background-color'      => esc_attr__( 'Background Color', 'canis' ),
			'background-image'      => esc_attr__( 'Background Image', 'canis' ),
			'no-repeat'             => esc_attr__( 'No Repeat', 'canis' ),
			'repeat-all'            => esc_attr__( 'Repeat All', 'canis' ),
			'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'canis' ),
			'repeat-y'              => esc_attr__( 'Repeat Vertically', 'canis' ),
			'inherit'               => esc_attr__( 'Inherit', 'canis' ),
			'background-repeat'     => esc_attr__( 'Background Repeat', 'canis' ),
			'cover'                 => esc_attr__( 'Cover', 'canis' ),
			'contain'               => esc_attr__( 'Contain', 'canis' ),
			'background-size'       => esc_attr__( 'Background Size', 'canis' ),
			'fixed'                 => esc_attr__( 'Fixed', 'canis' ),
			'scroll'                => esc_attr__( 'Scroll', 'canis' ),
			'background-attachment' => esc_attr__( 'Background Attachment', 'canis' ),
			'left-top'              => esc_attr__( 'Left Top', 'canis' ),
			'left-center'           => esc_attr__( 'Left Center', 'canis' ),
			'left-bottom'           => esc_attr__( 'Left Bottom', 'canis' ),
			'right-top'             => esc_attr__( 'Right Top', 'canis' ),
			'right-center'          => esc_attr__( 'Right Center', 'canis' ),
			'right-bottom'          => esc_attr__( 'Right Bottom', 'canis' ),
			'center-top'            => esc_attr__( 'Center Top', 'canis' ),
			'center-center'         => esc_attr__( 'Center Center', 'canis' ),
			'center-bottom'         => esc_attr__( 'Center Bottom', 'canis' ),
			'background-position'   => esc_attr__( 'Background Position', 'canis' ),
			'background-opacity'    => esc_attr__( 'Background Opacity', 'canis' ),
			'on'                    => esc_attr__( 'ON', 'canis' ),
			'off'                   => esc_attr__( 'OFF', 'canis' ),
			'all'                   => esc_attr__( 'All', 'canis' ),
			'cyrillic'              => esc_attr__( 'Cyrillic', 'canis' ),
			'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'canis' ),
			'devanagari'            => esc_attr__( 'Devanagari', 'canis' ),
			'greek'                 => esc_attr__( 'Greek', 'canis' ),
			'greek-ext'             => esc_attr__( 'Greek Extended', 'canis' ),
			'khmer'                 => esc_attr__( 'Khmer', 'canis' ),
			'latin'                 => esc_attr__( 'Latin', 'canis' ),
			'latin-ext'             => esc_attr__( 'Latin Extended', 'canis' ),
			'vietnamese'            => esc_attr__( 'Vietnamese', 'canis' ),
			'hebrew'                => esc_attr__( 'Hebrew', 'canis' ),
			'arabic'                => esc_attr__( 'Arabic', 'canis' ),
			'bengali'               => esc_attr__( 'Bengali', 'canis' ),
			'gujarati'              => esc_attr__( 'Gujarati', 'canis' ),
			'tamil'                 => esc_attr__( 'Tamil', 'canis' ),
			'telugu'                => esc_attr__( 'Telugu', 'canis' ),
			'thai'                  => esc_attr__( 'Thai', 'canis' ),
			'serif'                 => _x( 'Serif', 'font style', 'canis' ),
			'sans-serif'            => _x( 'Sans Serif', 'font style', 'canis' ),
			'monospace'             => _x( 'Monospace', 'font style', 'canis' ),
			'font-family'           => esc_attr__( 'Font Family', 'canis' ),
			'font-size'             => esc_attr__( 'Font Size', 'canis' ),
			'font-weight'           => esc_attr__( 'Font Weight', 'canis' ),
			'line-height'           => esc_attr__( 'Line Height', 'canis' ),
			'letter-spacing'        => esc_attr__( 'Letter Spacing', 'canis' ),
			'top'                   => esc_attr__( 'Top', 'canis' ),
			'bottom'                => esc_attr__( 'Bottom', 'canis' ),
			'left'                  => esc_attr__( 'Left', 'canis' ),
			'right'                 => esc_attr__( 'Right', 'canis' ),
		);

		$config = apply_filters( 'kirki/config', array() );

		if ( isset( $config['i18n'] ) ) {
			$i18n = wp_parse_args( $config['i18n'], $i18n );
		}

		return $i18n;

	}

	/**
	 * Shortcut method to get the font registry.
	 */
	public static function fonts() {
		return self::get_instance()->font_registry;
	}

	/**
	 * Constructor is private, should only be called by get_instance()
	 */
	private function __construct() {
	}

	/**
	 * Return true if we are debugging Kirki.
	 */
	public static function kirki_debug() {
		return (bool) ( defined( 'KIRKI_DEBUG' ) && KIRKI_DEBUG );
	}

    /**
     * Take a path and return it clean
     *
     * @param string $path
	 * @return string
     */
    public static function clean_file_path( $path ) {
        $path = str_replace( '', '', str_replace( array( "\\", "\\\\" ), '/', $path ) );
        if ( '/' === $path[ strlen( $path ) - 1 ] ) {
            $path = rtrim( $path, '/' );
        }
        return $path;
    }

	/**
	 * Determine if we're on a parent theme
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_parent_theme( $file ) {
		$file = self::clean_file_path( $file );
		$dir  = self::clean_file_path( get_template_directory() );
		$file = str_replace( '//', '/', $file );
		$dir  = str_replace( '//', '/', $dir );
		if ( false !== strpos( $file, $dir ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Determine if we're on a child theme.
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_child_theme( $file ) {
		$file = self::clean_file_path( $file );
		$dir  = self::clean_file_path( get_stylesheet_directory() );
		$file = str_replace( '//', '/', $file );
		$dir  = str_replace( '//', '/', $dir );
		if ( false !== strpos( $file, $dir ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Determine if we're running as a plugin
	 */
	private static function is_plugin() {
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_stylesheet_directory() ) ) ) {
			return false;
		}
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_template_directory_uri() ) ) ) {
			return false;
		}
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( WP_CONTENT_DIR . '/themes/' ) ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Determine if we're on a theme
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_theme( $file ) {
		if ( true == self::is_child_theme( $file ) || true == self::is_parent_theme( $file ) ) {
			return true;
		}
		return false;
	}
}
