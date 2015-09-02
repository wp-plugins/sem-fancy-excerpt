<?php
/*
Plugin Name: Fancy Excerpt
Plugin URI: http://www.semiologic.com/software/fancy-excerpt/
Description: RETIRED - Enhances WordPress' default excerpt generator by generating paragraph aware excerpts followed by more... links.
Version: 3.5.1
Author: Denis de Bernardy & Mike Koepke
Author URI: https://www.semiologic.com
Text Domain: fancy-excerpt
Domain Path: /lang
License: Dual licensed under the MIT and GPLv2 licenses
*/

/*
Terms of use
------------

This software is copyright Denis de Bernardy & Mike Koepke, and is distributed under the terms of the MIT and GPLv2 licenses.
**/

/*
 * This plugin has been retired.  No further development will occur on it.
 * */


/**
 * fancy_excerpt
 *
 * @package Fancy Excerpt
 **/

class fancy_excerpt {
	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 * @type object
	 */
	protected static $instance = NULL;

	/**
	 * URL to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_url = '';

	/**
	 * Path to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_path = '';

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 */
	public static function get_instance()
	{
		NULL === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 * @param   string $domain
	 * @return  void
	 */
	public function load_language( $domain )
	{
		load_plugin_textdomain(
			$domain,
			FALSE,
			dirname(plugin_basename(__FILE__)) . '/lang'
		);
	}

	/**
	 * Constructor.
	 *
	 *
	 */

    public function __construct() {
	    $this->plugin_url    = plugins_url( '/', __FILE__ );
        $this->plugin_path   = plugin_dir_path( __FILE__ );
        $this->load_language( 'fancy-excerpt' );

	    add_action( 'plugins_loaded', array ( $this, 'init' ) );
    }


	/**
	 * init()
	 *
	 * @return void
	 **/

	function init() {
		// more stuff: register actions and filters
		remove_filter('get_the_excerpt', 'wp_trim_excerpt');
        add_filter('get_the_excerpt', array($this, 'trim_excerpt'), 1);
	}

    /**
	 * trim_excerpt()
	 *
	 * @param string $text
	 * @return string $text
	 **/

	function trim_excerpt($text) {
		$text = trim($text);

		if ( $text || !in_the_loop() )
			return wp_trim_excerpt($text);

		$more = sprintf(__('Read more on %s...', 'fancy-excerpt'), get_the_title());

		$text = get_the_content($more);
		$text = str_replace(array("\r\n", "\r"), "\n", $text);
		#dump(esc_html($text));

		if ( !preg_match("|" . preg_quote($more, '|') . "</a>$|", $text)
			&& count(preg_split("~\s+~", trim(strip_tags($text)))) > 30
		) {
			global $escape_fancy_excerpt;
			$escape_fancy_excerpt = array();
			
			$text = fancy_excerpt::escape($text);
			
			$bits = preg_split("/(<(?:h[1-6]|p|ul|ol|li|dl|dd|table|tr|pre|blockquote)\b[^>]*>|\n{2,})/i", $text, null, PREG_SPLIT_DELIM_CAPTURE);
			$text = '';
			$count = 0;

			foreach ( $bits as $bit ) {
				$text .= $bit;
				$bit_count = trim(strip_tags($bit));
				if ( $bit_count === '' )
					continue;
				$count += count(preg_split("~\s+~", $bit_count));
				
				if ( $count > 30 )
					break;
			}
			
			$text = fancy_excerpt::unescape($text);
			
			$text = force_balance_tags($text);
			
			$text .= "\n\n"
				. '<p>'
				. apply_filters( 'the_content_more_link',
					'<a href="'. esc_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" class="more-link">'
					. $more
					. '</a>',
					$more )
				. '</p>' . "\n";
		}

        // add hack for ShareThis.  It hooks both excerpt and context hooks and generates double row entries.  There is
        // its own hack to fix this but it's code gets called after our filter.  They should have an option to exclude
        // from exceprts like Digg Digg.
        if ( function_exists('st_add_widget'))
       	    remove_action('the_content', 'st_add_widget');

		$text = apply_filters('the_content', $text);

		return apply_filters('wp_trim_excerpt', $text, '');
	} # trim_excerpt()
	
	
	/**
	 * escape()
	 *
	 * @param string $text
	 * @return string $text
	 **/

	function escape($text) {
		global $escape_fancy_excerpt;
		
		if ( !isset($escape_fancy_excerpt) )
			$escape_fancy_excerpt = array();
		
		foreach ( array(
			'blocks' => "/
				<\s*(script|style|object|textarea)(?:\s.*?)?>
				.*?
				<\s*\/\s*\\1\s*>
				/isx",
			) as $regex ) {
			$text = preg_replace_callback($regex, array($this, 'escape_callback'), $text);
		}
		
		return $text;
	} # escape()
	
	
	/**
	 * escape_callback()
	 *
	 * @param array $match
	 * @return string $text
	 **/

	function escape_callback($match) {
		global $escape_fancy_excerpt;
		
		$tag_id = "----escape_fancy_excerpt:" . md5($match[0]) . "----";
		$escape_fancy_excerpt[$tag_id] = $match[0];
		
		return $tag_id;
	} # escape_callback()
	
	
	/**
	 * unescape()
	 *
	 * @param string $text
	 * @return string $text
	 **/

	function unescape($text) {
		global $escape_fancy_excerpt;
		
		if ( !$escape_fancy_excerpt )
			return $text;
		
		$unescape = array_reverse($escape_fancy_excerpt);
		
		return str_replace(array_keys($unescape), array_values($unescape), $text);
	} # unescape()
} # fancy_excerpt

$fancy_excerpt = fancy_excerpt::get_instance();