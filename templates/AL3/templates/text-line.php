<?php global $ali3; ?><?php $text_inline = $ali3->ssdma_text_line; if($text_inline): ?>
<div class="container-fluid b-text-inline hidden-xs">
<div class="container text-center b-text-inline_inner">
<?php echo $text_inline; ?><br/>
<a class="btn btn-cwhite b-margin-upper" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
								<?php
								$Catalog = $ali3->ssdma_catalogue;

								if ( $Catalog && $Catalog != '' ):
									echo $ali3->ssdma_catalogue;
								else:
									echo _e( 'Go to Catalogue', 'ssdma' );
								endif;
								?></a>
</div></div><?php endif; ?><div class="container-fluid base-bg-white b-pad-t-30 b-pad-b-30"><div class="container"><div class="col-lg-6 col-md-12 col-sm-12 col-xs-24"><?php get_template_part( 'templates/products-cat-1' ); ?></div><div class="col-lg-6 col-md-12 col-sm-12 col-xs-24"><?php get_template_part( 'templates/products-cat-2' ); ?></div><div class="col-lg-6 col-md-12 col-sm-12 col-xs-24"><?php get_template_part( 'templates/products-cat-3' ); ?></div><div class="col-lg-6 col-md-12 col-sm-12 col-xs-24"><?php get_template_part( 'templates/products-cat-4' ); ?></div></div><?php $sf1 = $ali3->ssdma_beforef1_line; $sf2 = $ali3->ssdma_beforef2_line; if($sf1 || $sf2): ?><div class="container b-social-widget b-margin-base"><div class="col-lg-12 b-margin-base"><?php echo $sf1; ?></div><div class="col-lg-12 b-margin-base"><?php echo $sf2; ?></div></div><?php endif; ?></div>