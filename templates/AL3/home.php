<?php get_header(); ?>
<?php global $ali3; ?>
    <?php if ( $ali3->ssdma_slider_image1 ) : ?>
<div class="hidden-xs">
    <div class="fotorama" <?php echo (is_rtl()) ? 'data-direction="rtl"': ''?>>
        <span class="fotorama">
            <div class="b-header-img">
                <?php if(display_header_text()): ?>
                <div class="container">
                    <div class="b-header-img__caption">  <?php echo $ali3->ssdma_htext_line; ?><br/><br/>
                        <a class="btn btn-cred" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
            <?php
            $Catalog = $ali3->ssdma_catalogue;

            if ( $Catalog && $Catalog != '' ):
                echo $ali3->ssdma_catalogue;
            else:
                echo _e( 'Go to Catalogue', 'ssdma' );
            endif;
            ?>          </a>
                  </div><?php endif; ?>
            </div>
                </div>
					</span>

    <?php if ( $ali3->ssdma_slider_image2): ?>
        <span class="fotorama">
								<div class="b-header-img" style="background: url('<?php echo $ali3->ssdma_slider_image2; ?>') no-repeat top center;    background-size: 100%;">
                                    <!--<img src="<?php echo $ali3->ssdma_slider_image2; ?>"/>-->
                                    <div class="b-header-img__caption slider2">
                                        <?php echo $ali3->ssdma_htext_line2; ?><br/>
                                        <a class="btn btn-cred slider_btn2" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
                                            <?php

                                            $Catalog2 = $ali3->ssdma_catalogue2;

                                            if ( $Catalog2 && $Catalog2 != '' ):
                                                echo $ali3->ssdma_catalogue2;
                                            else:
                                                echo _e( 'Go to Catalogue', 'ssdma' );
                                            endif;
                                            ?></a>
                                    </div>
                                </div>
        </span>
    <?php endif; ?>

    <?php if ( $ali3->ssdma_slider_image3): ?>
        <span class="fotorama">
								<div class="b-header-img" style="background: url('<?php echo $ali3->ssdma_slider_image3; ?>') no-repeat top center;    background-size: 100%;">
                                   <!-- <img src="<?php echo $ali3->ssdma_slider_image3; ?>"/>-->
                                    <div class="b-header-img__caption slider3">
                                        <?php echo $ali3->ssdma_htext_line3; ?><br/>
                                        <a class="btn btn-cred slider_btn3" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
                                            <?php

                                            $Catalog3 = $ali3->ssdma_catalogue3;

                                            if ( $Catalog3 && $Catalog3 != '' ):
                                                echo $ali3->ssdma_catalogue3;
                                            else:
                                                echo _e( 'Go to Catalogue', 'ssdma' );
                                            endif;
                                            ?></a>
                                    </div>
                                </div></span>
    <?php endif; ?><?php endif; ?>
    </div>
    </div>

<div class="container-fluid b-protection clearfix"><div class="container">
<?php get_template_part( 'templates/protection' ); ?></div></div>
<div class="base-bg-white container-fluid"><div class="container b-margin-base">
<div role="tabpanel"><ul class="b-c-tabs" role="tablist"><li role="presentation" class="active">
<a href="#specials" aria-controls="specials" role="tab" data-toggle="tab"><?php _e('Specials', 'ssdma') ?></a></li>
<li role="presentation" ><a href="#latest" aria-controls="latest" role="tab" data-toggle="tab"><?php _e('Latest', 'ssdma') ?></a></li>
<li role="presentation"><a href="#sellers" aria-controls="sellers" role="tab" data-toggle="tab"><?php _e('Best sellers', 'ssdma') ?></a></li>
</ul><div class="tab-content"><div role="tabpanel" class="tab-pane active" id="specials"><?php get_template_part( 'templates/products-special' ); ?></div>
<div role="tabpanel" class="tab-pane" id="latest"><?php get_template_part( 'templates/products-latest' ); ?></div><div role="tabpanel" class="tab-pane" id="sellers">
<?php get_template_part( 'templates/products-best' ); ?></div></div></div></div></div>
<div class="container b-margin-base b-margin-upper"><?php get_template_part( 'templates/products-cat-5' ); ?></div>
<?php get_template_part( 'templates/text-line' ); ?>	<?php 
	$seo_main  = $ali3->ssdma_seo_main;
	echo $seo_main; ?><?php get_footer(); ?>