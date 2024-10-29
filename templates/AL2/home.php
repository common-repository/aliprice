<?php get_header(); ?>
<?php global $ali2;?>
    <div class="container base-mar-t-20">
	    <div class="grid-277 clearfix"><?php get_sidebar(); ?></div>
	    <div class="grid-900 grid-m-23 clearfix">
            <?php if ( $ali2->ssdma_slider_image1 ) : ?>
			    <div class="hidden-xs">
			        <div class="fotorama" <?php echo (is_rtl()) ? 'data-direction="rtl"': ''?>>

					    <span class="fotorama">
						    <div class="b-header-img">
							    <img src="<?php echo $ali2->ssdma_slider_image1 ?>">
						        <?php if ( display_header_text() ): ?>
						<div class="b-header-img__caption"><?php echo $ali2->ssdma_htext_line; ?><br/>
							<a class="btn btn-cred" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
								<?php
								$Catalog = $ali2->ssdma_catalogue;

								if ( $Catalog && $Catalog != '' ):
									echo $ali2->ssdma_catalogue;
								else:
									echo _e( 'Go to Catalogue', 'ssdma' );
								endif;
								?></a>
						</div><?php endif; ?>
						</div>
					</span>

				<?php if ( $ali2->ssdma_slider_image2 ): ?>
							<span class="fotorama">
								<div class="b-header-img">
									<img src="<?php echo $ali2->ssdma_slider_image2; ?>"/>
									<div class="b-header-img__caption">
										<?php echo $ali2->ssdma_htext_line2; ?><br/>
										<a class="btn btn-cred slider_btn2" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
											<?php

											$Catalog2 = $ali2->ssdma_catalogue2;

											if ( $Catalog2 && $Catalog2 != '' ):
												echo $ali2->ssdma_catalogue2;
											else:
												echo _e( 'Go to Catalogue', 'ssdma' );
											endif;
											?></a>
								</div>
								</div></span>
				<?php endif; ?>

				<?php if ( $ali2->ssdma_slider_image3): ?>
					<span class="fotorama">
								<div class="b-header-img">
									<img src="<?php echo $ali2->ssdma_slider_image3; ?>"/>
									<div class="b-header-img__caption">
										<?php echo $ali2->ssdma_htext_line3; ?><br/>
										<a class="btn btn-cred slider_btn3" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
											<?php

											$Catalog3 = $ali2->ssdma_catalogue3;

											if ( $Catalog3 && $Catalog3 != '' ):
												echo $ali2->ssdma_catalogue3;
											else:
												echo _e( 'Go to Catalogue', 'ssdma' );
											endif;
											?></a>
									</div>
								</div></span>
				<?php endif; ?><?php endif; ?>
			</div>
			</div>
		<div
			class="b-protection clearfix base-mar-20">
            <?php get_template_part( 'templates/protection' ); ?></div>
            <?php get_template_part( 'templates/products-special' ); ?>
            <?php get_template_part( 'templates/product-latest' ); ?>
            <?php $ban1 = $ali2->ssdma_banners_1;
		if ( $ali2->ssdma_banners_1 ): ?>
			<div
				class="clearfix text-center base-mar-b-20"><?php echo $ban1; ?></div><?php endif; ?><?php get_template_part( 'templates/product-cat-1' ); ?>
            <?php $ban2 = $ali2->ssdma_banners_2;
		if ( $ali2->ssdma_banners_2 ): ?>
			<div
				class="clearfix text-center base-mar-b-20"><?php echo $ban2; ?></div><?php endif; ?><?php get_template_part( 'templates/product-cat-2' ); ?>
	</div>
	<div class="clearfix"></div></div><?php get_template_part( 'templates/footer-before' ); ?>    <?php
$seo_main = $ali2->ssdma_seo_main;
echo $seo_main; ?><?php get_footer(); ?>