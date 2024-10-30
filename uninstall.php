<?php
/**
 * Uninstall WPCYFI
 *
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Delete options
delete_option('wpcyfi_legal_notice_name');
delete_option('wpcyfi_legal_notice_url');
delete_option('wpcyfi_legal_notice_target');
delete_option('wpcyfi_cookies_name');
delete_option('wpcyfi_cookies_url');
delete_option('wpcyfi_cookies_target');
