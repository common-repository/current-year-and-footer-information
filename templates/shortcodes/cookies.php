<?php
/**
* WPCYFI Template: Cookies Template.
*
* If target on legal notice was enabled, shows the attribute target="_blank", if not shows without this.
*
* @package     wp-cyfooterinfo
* @copyright   Copyright (c) 2017, Inaudit
* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
* @since       1.0.0
*/
?>
<?php do_action( 'wpcyfi_before_cookies', $args ); ?>

<?php do_action( 'wpcyfi_top_cookies', $args ); ?>

<?php if(!empty($args['CookiesName']) && !empty($args['CookiesURL'])): ?>
  <?php if((!empty($args['CookiesName'])) && ($args['CookiesTarget'])=='1'):?>
    <a href="<?php echo esc_url($args['CookiesURL']) ?>"target="_blank"><?php echo esc_html($args['CookiesName']) ?></a>
  <?php else: ?>
    <a href="<?php echo esc_url($args['CookiesURL']) ?>"><?php echo esc_html($args['CookiesName']) ?></a>
  <?php endif; ?>
<?php endif; ?>

<?php do_action( 'wpcyfi_bottom_cookies', $args ); ?>

<?php do_action( 'wpcyfi_after_cookies', $args ); ?>
