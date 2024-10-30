<?php
/**
* Shortcodes
*
* @package     wp-cyfooterinfo
* @copyright   Copyright (c) 2017, Inaudit
* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
* @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* WPCYFI_Shortcodes Class
* Registers shortcodes together with a shortcodes editor.
*
* @since 1.0.0
*/
class WPCYFI_Shortcodes {

  /**
  * __construct function.
  *
  */
  public function __construct() {

    add_filter( 'widget_text', 'do_shortcode' );
    //Add the copyright shortcode
    add_shortcode( 'c', array($this, 'wpcyfi_copyright'));
    //Add the year shortcode
    add_shortcode( 'cy', array($this, 'wpcyfi_year'));
    //Add the legal notice shortcode
    add_shortcode( 'legal_notice', array($this, 'wpcyfi_legal_notice'));
    //Add the cookie shortcode
    add_shortcode( 'cookies', array($this, 'wpcyfi_cookies'));
  }

  /**
  * Shortcode Product
  *
  */
  public function wpcyfi_copyright() {
    return "&copy;";
  }

  public function wpcyfi_year() {
    return date("Y");
  }

  public function wpcyfi_legal_notice($atts, $content=null){
    // Check if url have http or someone and if doesn't have any one, it puts http. Recognizes ftp://, ftps://, http:// and https://
    $legal_notice_url = get_option('wpcyfi_legal_notice_url');
    if (!preg_match("~^(?:f|ht)tps?://~i", $legal_notice_url)) {
      $legal_notice_url = "http://" . $legal_notice_url;
    }
    $args = array(
      'LegalnoticeName' => get_option('wpcyfi_legal_notice_name'),
      'LegalnoticeURL' => $legal_notice_url,
      'LegalnoticeTarget' => get_option('wpcyfi_legal_notice_target'),
    );

    ob_start();

    get_wpcyfi_template( 'shortcodes/legal-notice.php',
    array(
      'args' => $args,
      'atts' => $atts,
    )
  );

  $output = ob_get_clean();

  return $output;
}


  public function wpcyfi_cookies($atts, $content=null){
    // Check if url have http or someone and if doesn't have any one, it puts http. Recognizes ftp://, ftps://, http:// and https://
    $cookies_url = get_option('wpcyfi_cookies_url');
    if (!preg_match("~^(?:f|ht)tps?://~i", $cookies_url)) {
      $cookies_url = "http://" . $cookies_url;
    }
    $args = array(
      'CookiesName'=> get_option('wpcyfi_cookies_name'),
      'CookiesURL'=> $cookies_url,
      'CookiesTarget'=> get_option('wpcyfi_cookies_target'),
    );

    ob_start();

    get_wpcyfi_template( 'shortcodes/cookies.php',
      array(
        'args' => $args,
        'atts' => $atts,
      )
    );

    $output = ob_get_clean();

    return $output;
  }
}

new WPCYFI_Shortcodes;
