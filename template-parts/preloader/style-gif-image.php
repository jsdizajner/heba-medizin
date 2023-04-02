<?php
$image = Medizin::setting( 'pre_loader_image' );
?>
<div>
	<?php if ( $image !== '' ): ?>
		<img src="<?php echo esc_url( $image ); ?>"
		     alt="<?php esc_attr_e( 'Medizin Preloader', 'medizin' ); ?>">
	<?php endif; ?>
</div>
