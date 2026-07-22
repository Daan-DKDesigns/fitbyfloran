<?php
/**
 * Template part: het bewegingsicoon uit het "Fit by Floran" logo.
 * Gebruik: get_template_part( 'template-parts/logo-icon', null, array( 'size' => 30 ) );
 */
$size = isset( $args['size'] ) ? absint( $args['size'] ) : 30;
?>
<svg width="<?php echo esc_attr( $size ); ?>" height="<?php echo esc_attr( $size ); ?>" viewBox="0 0 32 32" aria-hidden="true">
	<circle cx="9.5" cy="6" r="2.4" fill="var(--text)"/>
	<line x1="9.5" y1="8.4" x2="13.5" y2="16.6" stroke="var(--text)" stroke-width="2"/>
	<circle cx="13.5" cy="16.6" r="2.4" fill="var(--mint-text)"/>
	<line x1="13.5" y1="16.6" x2="9.5" y2="25.5" stroke="var(--text)" stroke-width="2"/>
	<circle cx="9.5" cy="25.5" r="2.4" fill="var(--mint-text)"/>
	<line x1="9.5" y1="25.5" x2="25" y2="21" stroke="var(--coral-text)" stroke-width="2.4"/>
	<circle cx="25" cy="21" r="3" fill="var(--coral-text)"/>
</svg>
