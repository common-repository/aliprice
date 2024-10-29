<?php global $ali1; ?><?php $text_inline = $ali1->ssdma_text_line; if($text_inline): ?>
<div class="container-fluid b-text-inline b-margin-base"><div class="container">

<?php echo $text_inline; ?>&nbsp; <a class="btn btn-cwhite b-margin-upper" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
								<?php
								$Catalog = $ali1->ssdma_catalogue;

								if ( $Catalog && $Catalog != '' ):
									echo $ali1->ssdma_catalogue;
								else:
									echo _e( 'Go to Catalogue', 'ssdma' );
								endif;
								?></a>
</div></div><?php endif; ?><?php $sf1 = $ali1->ssdma_beforef1_line;
 $sf2 = $ali1->ssdma_beforef2_line; if($sf1 || $sf2): ?><div class="container b-social-widget b-margin-base"><div class="col-lg-12 b-margin-base"><?php echo $sf1; ?></div><div class="col-lg-12 b-margin-base"><?php echo $sf2; ?></div></div><?php endif; ?>