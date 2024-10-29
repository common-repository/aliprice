<?php

/**
 * Author: Vitaly Kukin
 * Date: 24.09.2014
 * Time: 12:14
 * Description: Show settings from Admin Class
 */
class czSettings extends czAdminTpl
{

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * list menu
	 * @return array
	 */
	public function listMenu()
	{
		$listMenu = array(
			'czbase' => array(
				'tmp'         => 'tmplGeneral',
				'title'       => __( 'General', 'ssdma' ),
				'description' => __( 'Some basic configuration settings.', 'ssdma' ),
				'icon'        => 'tachometer',
				'submenu'     => array()
			),

			'cztexts'        => array(
				'tmp'         => 'tmplTexts',
				'title'       => __( 'Texts', 'ssdma' ),
				'description' => __( 'Use this section to add and edit texts.', 'ssdma' ),
				'icon'        => 'life-ring',
				'submenu'     => array()
			),
			'czcolors'      => array(
				'tmp'         => 'tmplColors',
				'title'       => __( 'Colors', 'ssdma' ),
				'description' => __( 'Use this section to edit colors.', 'ssdma' ),
				'icon'        => 'cog',
				'submenu'     => array()
			),
			'czsocial'      => array(
				'tmp'         => 'tmplSocial',
				'title'       => __( 'Social Media', 'ssdma' ),
				'description' => __( 'Social media pages integration.', 'ssdma' ),
				'icon'        => 'hand-o-right ',
				'submenu'     => array()
			),
			'czsubcribe'    => array(
				'tmp'         => 'tmplSubcribe',
				'title'       => __( 'Subcribe Form', 'ssdma' ),
				'description' => __( 'Subscription form settings for collecting users’ emails.', 'ssdma' ),
				'icon'        => 'envelope',
				'submenu'     => array()
			),
			'czseo'         => array(
				'tmp'         => 'tmplSeo',
				'title'       => __( 'SEO', 'ssdma' ),
				'description' => __( 'SEO meta data settings.', 'ssdma' ),
				'icon'        => 'line-chart',
				'submenu'     => array()
			),
			'cznav'         => array(
				'tmp'         => 'tmplNav',
				'title'       => __( 'Navigation', 'ssdma' ),
				'description' => __( 'Navigation settings block.', 'ssdma' ),
				'icon'        => 'cloud-download',
				'submenu'     => array()
			)
		);

		return apply_filters( 'cz_list_menu', $listMenu );
	}

	/**
	 * Template Base
	 */
	function tmplGeneral()
	{

		$this->block( 
			array(
			$this->row(array(
				$this->textField( 'ssdma_font_family_global_url', array(
					'label' => __( 'Font URL (Global)', 'ssdma' )
				) ),
				$this->textField( 'ssdma_font_family_global_name', array(
					'label' => __( 'Font name: (Global)', 'ssdma' )
				)))),
			$this->row(array(
				$this->textField( 'ssdma_font_family_header_url', array(
					'label' => __( 'Font URL (Global)', 'ssdma' )
				) ),
				$this->textField( 'ssdma_font_family_header_name', array(
					'label' => __( 'Font name: (Global)', 'ssdma' )
				) )
			))
		)
		);
		$this->block( 
			$this->row(
				$this->textTextArea( 'ssdma_analytics_tid', array(
					'label' => __( 'Analytics Tracking code', 'ssdma' )
				) )
			));
		
		
		$this->block( 
			$this->row(array(
				$this->uploadImgField( 'ssdma_images_logo_header', array(
						'label'  => __( 'Header', 'ssdma' ),
						'width'  => 180,
						'height' => 60,
				) ),
			$this->uploadImgField( 'ssdma_images_logo_footer', array(
						'label'  => __( 'Footer', 'ssdma' ),
						'width'  => 180,
						'height' => 60,
				)),
				))
				);
		$this->block( 
			$this->row(array(
				$this->uploadImgField( 'ssdma_images_logo_favicon', array(
						'label'  => __( 'Favicon', 'ssdma' ),
						'width'  => 16,
						'height' => 16,
				) ),
			$this->uploadImgField( 'ssdma_images_fs', array(
						'label'  => __( 'Free Shipping image', 'ssdma' ),
						'width'  => 180,
						'height' => 42,
				)),
				))
				);
		$this->block( 
			$this->uploadImgField( 'ssdma_slider_image1', array(
						'label'  => __( 'Slider image 1', 'ssdma' ),
				))
				);
		$this->block( 
				$this->uploadImgField( 'ssdma_slider_image2', array(
						'label'  => __( 'Slider image 2', 'ssdma' ),
				) )
				);
		$this->block( 
			$this->uploadImgField( 'ssdma_slider_image3', array(
						'label'  => __( 'Slider image 3', 'ssdma' ),
				))
				);

	}

	/**
	 * Template Texts
	 */
	function tmplTexts()
	{
		$this->block( 
			$this->row(array(
				$this->textField( 'ssdma_buynow', array(
					'label' => __( '"Order now" button text', 'ssdma' )
				) ),
			$this->textField( 'ssdma_buynow_text', array(
					'label' => __( '"from Aliexpress" text', 'ssdma' )
				))))
				);
		$this->block( 
			$this->row(array(
				$this->textField( 'ssdma_text_line', array(
					'label' => __( 'Text inline', 'ssdma' )
				) ),
			$this->textField( 'ssdma_htextphone_line', array(
					'label' => __( 'Text top header', 'ssdma' )
				))))
				);
		$this->block( 
			$this->row(array(
				$this->textField( 'ssdma_htext_line', array(
					'label' => __( 'Text header', 'ssdma' )
				) ),
			$this->textField( 'ssdma_htext_line2', array(
					'label' => __( 'Text header 2', 'ssdma' )
				)),
			$this->textField( 'ssdma_htext_line3', array(
					'label' => __( 'Text header 3', 'ssdma' )
				))
				))
				);
		$this->block( 
			$this->row(array(
				$this->textField( 'ssdma_beforef1_line', array(
					'label' => __( 'Description', 'ssdma' )
				) ),
			$this->textField( 'ssdma_beforef2_line', array(
					'label' => __( 'Description', 'ssdma' )
				))))
				);
		$this->block( 
			$this->row(array(
				$this->textField( 'ssdma_catalogue', array(
					'label' => __( 'Catalogue text', 'ssdma' )
				) ),
			$this->textField( 'ssdma_catalogue2', array(
					'label' => __( 'Catalogue text 2', 'ssdma' )
				)),
			$this->textField( 'ssdma_catalogue3', array(
					'label' => __( 'Catalogue text 3', 'ssdma' )
				))
				))
				);
		$this->block( 
			$this->row(
				$this->textField( 'ssdma_copyright', array(
					'label' => __( '"Powered by" text', 'ssdma' )
				) )));
	}

	/**
	 * Template Colors
	 */
	function tmplColors()
	{
		$this->block( 
			$this->row(array(
				$this->colorField( 'ssdma_colors_links', array(
					'label' => __( 'Color (Search, Catalog, Links, Tabs, Price)', 'ssdma' )
				) ),
			$this->colorField( 'ssdma_colors_links_hover', array(
					'label' => __( 'Color (Search, Catalog, Links, Tabs, Price) Hover', 'ssdma' )
				)),
				))
				);
		$this->block( 
			$this->row(array(
				$this->colorField( 'ssdma_colors_memu', array(
					'label' => __( 'Color (Menu)', 'ssdma' )
				) ),
			$this->colorField( 'ssdma_colors_memu_hover', array(
					'label' => __( 'Color (Menu) Hover', 'ssdma' )
				)),
				))
				);
		$this->block( 
			$this->row(array(
				$this->colorField( 'ssdma_colors_links_border_r', array(
					'label' => __( 'Color (Menu) Border Right', 'ssdma' )
				) ),
			$this->colorField( 'ssdma_colors_links_border_l', array(
					'label' => __( 'Color (Menu) Border Left', 'ssdma' )
				)),
				))
				);
		$this->block( 
			$this->row(array(
				$this->colorField( 'ssdma_colors_htb2', array(
					'label' => __( 'Header(slider) text button 2', 'ssdma' )
				) ),
			$this->colorField( 'ssdma_colors_htb_h2', array(
					'label' => __( 'Header(slider) text button 2 Hover', 'ssdma' )
				)),
				))
				);
		$this->block( 
			$this->row(array(
				$this->colorField( 'ssdma_colors_htb3', array(
					'label' => __( 'Header(slider) text button 3', 'ssdma' )
				) ),
			$this->colorField( 'ssdma_colors_htb_h3', array(
					'label' => __( 'Header(slider) text button 3 Hover', 'ssdma' )
				)),
				))
				);
		$this->block( 
			$this->row(array(
				$this->colorField( 'ssdma_colors_htb', array(
					'label' => __( 'Header text button', 'ssdma' )
				) ),
			$this->colorField( 'ssdma_colors_htb_h', array(
					'label' => __( 'Header text button(hover)', 'ssdma' )
				)),
			$this->colorField( 'ssdma_colors_h_line', array(
					'label' => __( 'Header line', 'ssdma' )
				)),
				))
				);
	}

	/**
	 * Template Social
	 */
	function tmplSocial()
	{
		$this->block( 
			array(
			$this->row(array(
				$this->textField( 'ssdma_social_facebook', array(
					'label' => __( 'Facebook (url)', 'ssdma' )
				) ),
				$this->textField( 'ssdma_social_twitter', array(
					'label' => __( 'Twitter (url)', 'ssdma' )
				)))),
			$this->row(array(
				$this->textField( 'ssdma_social_gplus', array(
					'label' => __( 'G+ (url)', 'ssdma' )
				) ),
				$this->textField( 'ssdma_social_youtube', array(
					'label' => __( 'Youtube (url)', 'ssdma' )
				) )
			)),
			$this->row(array(
				$this->textField( 'ssdma_social_pinterest', array(
					'label' => __( 'Pinterest (url)', 'ssdma' )
				) ),
				$this->textField( 'ssdma_social_vk', array(
					'label' => __( 'VK (url)', 'ssdma' )
				) )
			))
		)
		);
	}

	/**
	 * Template Subcribe
	 */
	function tmplSubcribe()
	{
		$this->block( 
			$this->row(
				$this->textTextArea( 'ssdma_subscribe', array(
					'label' => __( 'Subscribe Form', 'ssdma' ),
					'rows'  => 10
				))
				));
	}

	/**
	 * Template SEO
	 */
	function tmplSeo()
	{
		$this->block( 
			$this->row(array(
				$this->textField( 'ssdma_seo_keywords', array(
					'label' => __( 'Keywords', 'ssdma' )
				) ),
			$this->textField( 'ssdma_seo_desc', array(
					'label' => __( 'Description', 'ssdma' )
				)),
				))
				);
		$this->block( 
			$this->row(
				$this->textTextArea( 'ssdma_seo_main', array(
					'label' => __( 'SEO Article on home page (before footer)', 'ssdma' ),
					'rows'  => 10
				))
				));
		$this->block( 
			$this->row(
				$this->textTextArea( 'ssdma_htext_seoh', array(
					'label' => __( 'Seo text header', 'ssdma' ),
					'rows'  => 10
				)),
				$this->textTextArea( 'ssdma_htext_seod', array(
					'label' => __( 'Seo text description', 'ssdma' ),
					'rows'  => 10
				))
				));
	}
		/**
	 * Template Navigation
	 */
	function tmplNav()
	{
						$menus = wp_get_nav_menus();
				$slug_menus = array();
				$current_menus = '';
				foreach($menus as $item) {
					if(!$current_menus) { $current_menus = $item->slug; }
						$slug_menus[$item->slug] = $item->name;
				}
				$this->block( array(
					$this->row( array(
						$this->dropDownField( 'ssdma_nav_header', array(
							'label'=>__( 'Header menu', 'ssdma' ),
							'value'=> $slug_menus,
						)),
						$this->dropDownField( 'ssdma_nav_main', array(
							'label'=> __( 'Main menu', 'ssdma' ),
							'value'=> $slug_menus,
						)),
						$this->dropDownField( 'ssdma_nav_footer', array(
							'label'=> __( 'Footer menu', 'ssdma' ),
							'value'=> $slug_menus,
						))
                    ))
					));
				$terms = get_terms('shopcategory', array('hide_empty' => false));
                    $default = 0;
                    $categories = array();
                    if( count($terms) ) {
                        foreach( $terms as $term ) {
                            if(!$default){
                                $default = $term->term_id;
                            }
                            $categories[$term->term_id] = $term->name . ' (' . $term->count . ')';
                        }
                    }
        $this->block( array(
			$this->row( array(
					$this->dropDownField( 'ssdma_products_cat1', array(
                        'label'=> __('Categories tab 1', 'ssdma'),
                        'value'=> $categories,
						)),
					$this->dropDownField( 'ssdma_products_cat2', array(
                        'label'=> __('Categories tab 2', 'ssdma'),
                        'value'=> $categories,
						)),
                    )),
            $this->row( array(
					$this->dropDownField( 'ssdma_products_cat3', array(
                        'label'=> __('Categories tab 3', 'ssdma'),
                        'value'=> $categories,
                    )),
					$this->dropDownField( 'ssdma_products_cat4', array(
                        'label'=> __('Categories tab 4', 'ssdma'),
                        'value'=> $categories,
                    )),
					))
					));
	}

}
