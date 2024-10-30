<?php
/*
Plugin Name: Current Year and Footer Information
Plugin URI:
Description: Add the current year, the copyright symbol, the Legal Notice and the Cookies Policy with easy shortcodes. Compatible with WordPress Multilanguage.
Version: 1.2.2
Author: Inaudit
Author URI: http://www.inaudit.io
Text Domain: wpcyfi
License: GPL2

Current Year and Footer Information is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Current Year and Footer Information is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Current Year and Footer Information . If not, see <http://www.gnu.org/licenses/>.
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_Cyfooterinfo' ) ) {

  /**
  * Main WP_Cyfooterinfo Class
  *
  * @since 0.1.0
  */
  class WP_Cyfooterinfo {
    private static $instance;

    public static function instance() {
      if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Cyfooterinfo ) ) {
        self::$instance			= new WP_Cyfooterinfo;
        self::$instance->setup_constants();
        self::$instance->includes();

		    add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
      }

      return self::$instance;
    }


    private function setup_constants() {
      // Plugin version
      if ( ! defined( 'WPCYFI_VERSION' ) ) {
        define( 'WPCYFI_VERSION', '1.0.0' );
      }

      // Plugin Folder Path
      if ( ! defined( 'WPCYFI_PLUGIN_DIR' ) ) {
        define( 'WPCYFI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
      }

      // Plugin Folder URL
      if ( ! defined( 'WPCYFI_PLUGIN_URL' ) ) {
        define( 'WPCYFI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
      }

      // Plugin Root File
      if ( ! defined( 'WPCYFI_PLUGIN_FILE' ) ) {
        define( 'WPCYFI_PLUGIN_FILE', __FILE__ );
      }

      // Plugin Slug
      if ( ! defined( 'WPCYFI_SLUG' ) ) {
        define( 'WPCYFI_SLUG', plugin_basename( __FILE__ ) );
      }
    }

    private function includes() {
      require_once WPCYFI_PLUGIN_DIR . 'helpers/helper-wpcyfi-template-loader.php';
      require_once  WPCYFI_PLUGIN_DIR . 'classes/class-wpcyfi-settings.php';
      require_once  WPCYFI_PLUGIN_DIR . 'classes/class-wpcyfi-shortcodes.php';
    }

    public function load_textdomain() {
      // Set filter for plugin's languages directory
      $wpcyfi_lang_dir = dirname(__FILE__) . '/languages/';
      $wpcyfi_lang_dir = apply_filters( 'wpcyfi_languages_directory', $wpcyfi_lang_dir );

      // Traditional WordPress plugin locale filter
      $locale        = apply_filters( 'plugin_locale',  get_locale(), 'wpcyfi' );
      $mofile        = sprintf( '%1$s-%2$s.mo', 'wpcyfi', $locale );

      // Setup paths to current locale file
      $mofile_local  = $wpcyfi_lang_dir . $mofile;
      $mofile_global = WP_LANG_DIR . '/wpsf/' . $mofile;

      if ( file_exists( $mofile_global ) ) {
        // Look in global /wp-content/languages/wpsf folder
        load_textdomain( 'wpcyfi', $mofile_global );
      } elseif ( file_exists( $mofile_local ) ) {
        // Look in local /wp-content/plugins/wp-saifor/languages/ folder
        load_textdomain( 'wpcyfi', $mofile_local );
      } else {
        // Load the default language files
        load_plugin_textdomain( 'wpcyfi', false, $wpcyfi_lang_dir );
      }
    }
  }
}

return WP_Cyfooterinfo::instance();
