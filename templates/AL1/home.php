<?php get_header(); ?>

<?php global $ali1; ?>
<?php if ( $ali1->ssdma_slider_image1 ) : ?>

	<div class="container">
    <div class="hidden-xs">
    <div class="fotorama" <?php echo (is_rtl()) ? 'data-direction="rtl"': ''?>>

    <span class="fotorama">
	<div class="b-header-img"><img class="img-responsive" src="<?php echo $ali1->ssdma_slider_image1 ?>"
	                               alt="<?php echo get_option( 'blogdescription' ); ?>">
        <?php if ( display_header_text() ): ?>
			<div class="b-header-img__caption"><?php echo $ali1->ssdma_htext_line; ?><br/><br/>
			<a class="btn btn-cred" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
								<?php
								$Catalog = $ali1->ssdma_catalogue;

								if ( $Catalog && $Catalog != '' ):
									echo $ali1->ssdma_catalogue;
								else:
									echo _e( 'Go to Catalogue', 'ssdma' );
                                endif;
                                ?></a>
            </div><?php endif; ?>
    </div>
					</span>

    <?php if ( $ali1->ssdma_slider_image2 ): ?>
        <span class="fotorama">
								<div class="b-header-img">
                                    <img src="<?php echo $ali1->ssdma_slider_image2; ?>"/>
                                    <div class="b-header-img__caption">
                                        <?php echo $ali1->ssdma_htext_line2; ?><br/>
                                        <a class="btn btn-cred slider_btn2" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
                                            <?php

                                            $Catalog2 = $ali1->ssdma_catalogue2;

                                            if ( $Catalog2 && $Catalog2 != '' ):
                                                echo $ali1->ssdma_catalogue2;
                                            else:
                                                echo _e( 'Go to Catalogue', 'ssdma' );
                                            endif;
                                            ?></a>
                                    </div>
                                </div></span>
    <?php endif; ?>

    <?php if ( $ali1->ssdma_slider_image3 ): ?>
        <span class="fotorama">
								<div class="b-header-img">
                                    <img src="<?php echo $ali1->ssdma_slider_image3; ?>"/>
                                    <div class="b-header-img__caption">
                                        <?php echo $ali1->ssdma_htext_line3; ?><br/>
                                        <a class="btn btn-cred slider_btn3" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
                                            <?php

                                            $Catalog3 = $ali1->ssdma_catalogue3;

                                            if ( $Catalog3 && $Catalog3 != '' ):
                                                echo $ali1->ssdma_catalogue3;
                                            else:
                                                echo _e( 'Go to Catalogue', 'ssdma' );
                                            endif;
                                            ?></a>
                                    </div>
                                </div></span>
    <?php endif; ?><?php endif; ?>
    </div>
    </div>
	</div>
	<div class="container">
		<div
			class="b-protection clearfix b-margin-base b-margin-upper"><?php get_template_part( 'templates/protection' ); ?></div>
	</div>
	<div class="container b-margin-base">
	<div role="tabpanel">
		<ul class="b-c-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#specials" aria-controls="specials" role="tab"
			                                          data-toggle="tab"><?php _e( 'Specials', 'ssdma' ) ?><span
						class="b-social-icon-sort"></span></a></li>
			<li role="presentation"><a href="#latest" aria-controls="latest" role="tab"
			                           data-toggle="tab"><?php _e( 'Latest', 'ssdma' ) ?><span
						class="b-social-icon-sort"></span></a></li>
			<li role="presentation"><a href="#sellers" aria-controls="sellers" role="tab"
			                           data-toggle="tab"><?php _e( 'Best sellers', 'ssdma' ) ?><span
						class="b-social-icon-sort"></span></a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active"
			     id="specials"><?php get_template_part( 'templates/products-special' ); ?></div>
			<div role="tabpanel" class="tab-pane"
			     id="latest"><?php get_template_part( 'templates/products-latest' ); ?></div>
			<div role="tabpanel" class="tab-pane"
			     id="sellers"><?php get_template_part( 'templates/products-best' ); ?></div>
		</div>
	</div></div><?php $text_inline = $ali1->ssdma_text_line;
if ( $text_inline ): ?>
	<div class="container-fluid b-text-inline b-margin-base">
	<div class="container"><?php echo $text_inline; ?> &nbsp;<a class="btn btn-cwhite"
	                                                            href="<?php echo esc_url( home_url( '/products' ) ); ?>"><?php _e( $ali1->ssdma_catalogue, 'ssdma' ); ?></a>
	</div></div><?php endif; ?>
	<div class="container">
		<div
			class="col-lg-6 col-md-12 col-sm-12 col-xs-24 mobilecat"><?php get_template_part( 'templates/products-cat-1' ); ?></div>
		<div
			class="col-lg-6 col-md-12 col-sm-12 col-xs-24 mobilecat"><?php get_template_part( 'templates/products-cat-2' ); ?></div>
		<div
			class="col-lg-6 col-md-12 col-sm-12 col-xs-24 mobilecat"><?php get_template_part( 'templates/products-cat-3' ); ?></div>
		<div
			class="col-lg-6 col-md-12 col-sm-12 col-xs-24 mobilecat"><?php get_template_part( 'templates/products-cat-4' ); ?></div>
	</div>

<?php
$seo_main = $ali1->ssdma_seo_main;
echo $seo_main; ?>
<?php $sf1 = $ali1->ssdma_beforef1_line;
$sf2       = $ali1->ssdma_beforef2_line;
if ( $sf1 || $sf2 ): ?>
	<div class="container b-social-widget b-margin-base">
	<div class="col-lg-12 b-margin-base"><?php echo $sf1; ?></div>
	<div class="col-lg-12 b-margin-base"><?php echo $sf2; ?></div></div><?php endif; ?>

<?php get_footer(); ?>