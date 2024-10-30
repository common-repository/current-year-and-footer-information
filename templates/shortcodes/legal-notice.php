<?php
/**
* WPCYFI Template: Legal-notice Template.
*
* If target on legal notice was enabled, shows the attribute target="_blank", if not shows without this.
*
* @package     wp-cyfooterinfo
* @copyright   Copyright (c) 2017, Inaudit
* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
* @since       1.0.0
*/
?>

<?php do_action( 'wpcyfi_before_legal_notice', $args ); ?>

<?php do_action( 'wpcyfi_top_legal_notice', $args ); ?>

<?php if(!empty($args['LegalnoticeURL']) && !empty($args['LegalnoticeName'])): ?>
  <?php if((!empty($args['LegalnoticeName'])) && ($args['LegalnoticeTarget'])=='1'):?>
    <a href="<?php echo esc_url($args['LegalnoticeURL']) ?>"target="_blank"><?php echo esc_html($args['LegalnoticeName']) ?></a>
  <?php else: ?>
    <a href="<?php echo esc_url($args['LegalnoticeURL']) ?>"><?php echo esc_html($args['LegalnoticeName']) ?></a>
  <?php endif; ?>
<?php endif; ?>

<?php do_action( 'wpcyfi_bottom_legal_notice', $args ); ?>

<?php do_action( 'wpcyfi_after_legal_notice', $args ); ?>
