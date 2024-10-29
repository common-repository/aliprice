<?php

class AliExpressSettings extends AliExpressAdminTpl {

    /**
     * The title of admin interface
     * @access public
     * @var string
     */
    public $title = "";

    /**
     * The icon of title
     * @access public
     * @var string
     */
    public $icon = "";

    /**
     * Description of admin page
     * @access public
     * @var string
     */
    public $description = "";

    /**
     * The current page of plugin
     * @access private
     * @var string
     */
    public $current = "";

    /**
     * Access Key Id. When you create the App, the AliExpress open platform will generate an appKey.
     * @access private
     * @var string
     */
    private $AppKey	= "";

    /**
     * Api Parameter. Different APIs have different parameters. You need to fill in the parameters when requesting a connector.
     * You Tracking ID
     * @access private
     * @var string
     */
    private $trackingId = "";

    /**
     * Message
     * @access private
     * @var string
     */

    private $message = "";

    private $todaysdeal= "";
    private $alibaba= "";
    private $alibaba_href= "";

    function __construct() {
        //判定当前页面
        $this->current = $this->currentItemMenu();

        if( $this->current == 'dash' ) {
            $this->catch_reset();
        }

        if(
        in_array(
            $this->current,
            array('currency', 'api', 'updates', 'cleanup')
        )
        ) {
            $this->catch_request();
        }

        if( $this->current == 'scheduled' )
            $this->catch_cron();

        if( $this->current == 'review' )
            $this->catch_cron_review();
        //读取wp_option数据
        $this->AppKey 		    = get_site_option('aliprice-app-key');
        $this->trackingId 	    = get_site_option('aliprice-tracking');
        $this->appsignature     = get_site_option('aliprice-appsignature');
        $this->Partner_username = get_site_option('aliprice-partner_username');
        $this->appearance 	    = get_site_option('aliprice-appearance');
        $this->todaysdeal 	    = get_site_option('aliprice-todaysdeal');
        $this->hotdeal 	        = get_site_option('aliprice-hotdeal');
        $this->alibaba  	    = get_site_option('aliprice-alibaba');
        $this->alibaba_href  	= get_site_option('aliprice-alibaba_href');
    }

    /**
     * show current template
     */
    public function getTemplate() {

        $current = $this->current;

        $tmpls 	= $this->templList();
        $args	= $this->listMenu();

        if( !isset( $tmpls[$current] ) ) return false;

        $cancel = false;

        foreach($args as $key => $val) {

            if( $cancel ) continue;

            if( $key == $current ) {
                $this->title 		= $val['title'];
                $this->description 	= $val['description'];
                $this->icon 		= $val['icon'];

                $cancel = true;
            }

            if( isset($val['submenu']) ) {

                foreach( $val['submenu'] as $skey => $sval ) {

                    if( $skey == $current ) {
                        $this->title 		= $sval['title'];
                        $this->description 	= $sval['description'];
                        $this->icon 		= $val['icon'];

                        $cancel = true;
                    }
                }
            }
        }

        $method = $tmpls[$current];

        if( method_exists( $this, $method ) ) {

            ob_start();

            $this->$method();

            $content = ob_get_contents();

            ob_end_clean();

            $this->createTpl( $content );
        }
        else
            return false;
    }

    /**
     *	list template slugs
     */
    public function templList() {

        return array(
            'dash' 			=> 'tmplDashboard',
            'bulkimport' 			=> 'tmplBulk',
            'advancedimport' 		=> 'tmplAdvanced',
            'scheduledimport' 	=> 'tmplScheduled',
            'translate' 	=> 'tmplTranslate',
            'review' 		=> 'tmplReview',
            'currency' 		=> 'tmplCurrency',
            'updates' 		=> 'tmplUpdates',
            'api' 			=> 'tmplAPI',
            'cleanup' 		=> 'tmplCleanup'
        );
    }

    /**
     *	list menu array
     */
    public function listMenu() {

        return array(
            'dash' 	=> array(
                'title' 		=> __('Dashboard', 'aliprice'),
                'description' 	=> __('This displays the current information about your online store', 'aliprice'),
                'icon' 			=> 'tachometer',
                'submenu' 		=> array()
            ),
            'advancedimport' 	=> array(
                'title' 		=> __('Import Products', 'aliprice'),
                'icon' 			=> 'cloud-download',
                'description'	=> __('Using this module you can bulk import multiple products at once on your store', 'aliprice'),
                'submenu' => array(
					'advancedimport' 	=> array(
                        'title' 		=> __('Selective Import', 'aliprice'),
                        'description'	=> __('Find and select particular products to import', 'aliprice')
                    ),
                    'bulkimport' 		=> array(
                        'title' 		=> __('Bulk Import', 'aliprice'),
                        'description' 	=> __('Using this module you can bulk import multiple products at once on your store', 'aliprice')
                    ),
                    'scheduledimport' => array(
                        'title' 		=> __('Scheduled Import', 'aliprice'),
                        'description'	=> __('Using this module the system will automatically import and update products on your site according  to given parameters', 'aliprice')
                    )
                )
            ),
            'review' 	=> array(
                'title' 		=> __('Reviews', 'aliprice'),
                'icon' 			=> 'comment',
                'description'	=> __('Add Reviews to your products.', 'aliprice'),
                'submenu' => array()
            ),
            'api' 	=> array(
                'title' 		=> __('Settings', 'aliprice'),
                'description'	=> 	__('Mandatory fields are APP Key and Tracking ID', 'aliprice'),
                'icon' 			=> 'cog',
                'submenu' 		=> array(
                    'api' 		=> array(
                        'title' 		=> __('General', 'aliprice'),
                        'description' 	=> __('The following fields are required in order to send requests to AliExpress and retrieve data about products.', 'aliprice')
                    ),
                    'currency' 		=> array(
                        'title' 		=> __('Currency', 'aliprice'),
                        'description' 	=> __('Standards and formats are used to calculate such things as product price.', 'aliprice')
                    ),

                    'updates' 		=> array(
                        'title' 		=> __('Updates', 'aliprice'),
                        'description' 	=> ''
                    ),
                    'cleanup' 		=> array(
                        'title' 		=> __('Cleanup', 'aliprice'),
                        'description' 	=> __('All existent products imported in your store will be removed.', 'aliprice')
                    ),
                    'translate' 	=> array(
                        'title' 		=> __('Translation', 'aliprice'),
                        'description'	=> __('Translate Page Titles and Categories', 'aliprice'),
                        'icon' 			=> 'language',
                        'submenu' 		=> array()
                    ),
                ),
            )
        );
    }

    public function tmplUpdates() {
        ?>
        <div class="content-inner-type ae_loader_action">
            <div class="row height-full width-full">
                <div class="col-sm-8 height-full">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="panel-info" width="50%" valign="top">
                                <h3><?php _e('Update all products', 'aliprice') ?></h3>
                                <p><?php _e('Activate this option if you want to update all the products on your site at once', 'aliprice' ) ?></p>
                                <form action="" class="ae_submit_circle">
                                    <input type="hidden" name="action" value="ae_update_all_products"/>
                                    <input type="hidden" name="step_two" value="ae_update_step_product"/>
                                    <input type="hidden" name="len" value="5"/>
                                    <input type="hidden" name="infoText" value=""/>
                                    <button class="btn">
                                        <span class="fa fa-download"></span> <?php _e("Update products", "aliprice") ?>
                                    </button>
                                </form>
                            </td>
                            <td class="progress-circle" width="50%" valign="top">
                                <h4><?php _e('Overall Progress', 'aliprice') ?></h4>
                                <div class="action-loader"></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4 height-full">
                    <div class="stats">
                        <h4><?php _e('Stats', 'aliprice') ?></h4>
                        <div class="shelf">
                            <span><?php echo aliprice_total_count_products() ?></span>
                            <?php _e('Products', 'aliprice') ?>
                        </div>
                        <div class="shelf">
                            <span class="action-loader-current">0</span>
                            <?php _e('Current position', 'aliprice') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2><?php _e('Automatic Updates', 'aliprice') ?></h2>
        <div class="description"><?php _e('Auto updating system will keep your product info fresh with the latest data from AliExpress.', 'aliprice') ?></div>

        <div class="content-inner">

            <form action="" method="POST">

                <?php wp_nonce_field( 'aliprice_autoupdate_action', 'aliprice_autoupdate' ); ?>
                <?php
                $defaults = array(
                    'inteval' 		=> 'twicedaily',
                    'enabled' 		=> '0',
                    'description'	=> '1',
                    'etitle'		=> '1'
                );

                $args = get_site_option('aliprice-autoupdate');
                $args = ( !$args ) ? array() : unserialize($args);

                $args = wp_parse_args( $args, $defaults );

                $delete = get_site_option('aliprice-delete');
                ?>
                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6 no-top" for="enabled"><?php _e('Status', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="checkbox" name="enabled" id="enabled" value="1" <?php echo ($args['enabled'] == 1) ?
                            'checked="checked"' : '' ?>> <?php _e('Enable auto updating system', 'aliprice')?>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6" for="inteval"><?php _e('Select Interval', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <select name="inteval" class="standart" id="inteval">

                            <?php
                            $int = aliprice_get_cron_intervals();
                            foreach( $int as $key => $str ) {

                                $select = ($key == $args['inteval']) ? 'selected="selected"' : '';

                                echo '<option value="' . $key . '" ' . $select . '>' . $str . '</option>';
                            }
                            ?>
                        </select>
                        <p><em><?php _e('One-time update can refresh only 25 products for one cycle.', 'aliprice') ?></em></p>
                    </div>
                </div>
                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6 no-top" for="delete-product"><?php _e('When a product disappears from AliExpress', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
					<select name="delete" id="delete-product" class="standart" id="inteval">
                            <option value="" <?php echo ($delete == '') ? 'selected="selected"' : '' ?>><?php _e('Do nothing','aliprice')?></option>
							<option value="1" <?php echo ($delete == 1) ? 'selected="selected"' : '' ?>><?php _e('Delete product','aliprice')?></option>
					</select>
                    </div>
                </div>

                <div class="item-group">
                    <button class="btn orange-bg"><span class="fa fa-floppy-o"></span> <?php _e("Save Changes", "aliprice") ?></button>
                </div>

            </form>
        </div>
    <?php
    }

    public function tmplAPI() {
        ?>
        <div class="row">

            <div class="col-sm-12">
                <div class="content-inner">

                    <form action="" method="POST">

                        <?php wp_nonce_field( 'aliprice_setting_action', 'aliprice_setting' ); ?>

                        <div class="item-group">
                            <?php _e('Select affiliate program to use with AliPrice', 'aliprice')?>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label class="col-sm-6" for="program"><?php _e('Current Program', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <span class="standart"><?php echo $program = get_site_option('aliprice-program') ?></span>
                            </div>
                        </div>

                        <input type="hidden" class="standart" id="AppKey" name="AppKey" placeholder="" value="<?php echo $this->AppKey ?>">
                        <input type="hidden" class="standart" id="trackingId" name="trackingId" placeholder="" value="<?php echo $this->trackingId ?>">
                        <div class="item-group control-group clearfix">
                            <label for="Partner_username" class="col-sm-6"><?php _e('AliPrice Username', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <input type="text" class="standart" id="Partner_username" name="Partner_username" placeholder="" value="<?php echo sanitize_user($this->Partner_username) ?>">
                                <button class="btn green-bg" name="test_connection"><span class="fa fa-bell-o"></span> <?php _e("Test Connection", "aliprice") ?></button>
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="Partner_password" class="col-sm-6"><?php _e('AliPrice Password', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <input type="password" class="standart" id="Partner_password" name="Partner_password" placeholder="" value="<?php echo $this->Partner_password ?>">
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="Appkey" class="col-sm-6"><?php _e('AppKey', 'aliprice') ?></label>
                            <div class="col-sm-18">

                                <input type="text" class="standart" id="AppKey" name="AppKey" placeholder="" value="<?php echo $this->AppKey ?>">
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="trackingId" class="col-sm-6"><?php _e('trackingId', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <input type="text" class="standart" id="trackingId" name="trackingId" placeholder="" value="<?php echo $this->trackingId ?>">
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label class="col-sm-6" for="method"><?php _e('Select Method', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <select name="method" id="method" class="standart">
                                    <?php
                                    $method = get_site_option( 'aliprice-method' );

                                    $int = array('file' => 'Standard', 'curl' => 'cURL');

                                    foreach( $int as $key => $str ) {

                                        $select = ($key == $method) ? 'selected="selected"' : '';

                                        echo '<option value="' . $key . '" ' . $select . '>' . $str . '</option>';
                                    }
                                    ?>
                                </select>
                                <p><em><?php _e('Select method used to request data from AliExpress and test connection', 'aliprice') ?></em></p>
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label class="col-sm-6" for="language"><?php _e('Language', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <select name="language" id="language" class="standart">
                                    <?php
                                    $langs = aliprice_list_lang();
                                    foreach( $langs as $key => $val ) {

                                        $select = ($key == ALIPRICE_LANG) ? 'selected="selected"' : '';

                                        echo '<option value="' . $key . '" ' . $select . '>' . $val . '</option>';
                                    }
                                    ?>
                                </select>
                                <p><em><?php _e("Select language used for importing products data", 'aliprice') ?></em></p>
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="todays" class="col-sm-6"><?php _e('Today&lsquo;s Deal', 'aliprice') ?></label>
                            <div class="col-sm-18 col-md-9">
                                <input type="checkbox" name="todaysdeal" id="todays" value="1" <?php  echo ($this->todaysdeal == 1) ? 'checked="checked"' : '' ?>>
                                <p><em><?php _e('Enable day timer for the products with exclusive discount price', 'aliprice')?></p></em>
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="hotdeal" class="col-sm-6"><?php _e('Hot Deal Timer', 'aliprice') ?></label>
                            <div class="col-sm-18 col-md-9">
                                <input type="checkbox" name="hotdeal" id="hotdeal" value="1" <?php  echo ($this->hotdeal == 1) ? 'checked="checked"' : '' ?>>
                                <p><em><?php _e('Enable hour timer for the products with exclusive discount price', 'aliprice')?></p></em>
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="alibaba" class="col-sm-6"><?php _e('Alibaba', 'aliprice') ?></label>
                            <div class="col-sm-18 col-md-9">
                                <input type="checkbox" name="alibaba" id="alibaba" value="1" <?php  echo ($this->alibaba == 1) ? 'checked="checked"' : '' ?>>
                                <p><em><?php _e('Enable pop-up window with alibaba.com affiliate link', 'aliprice')?></em></p>
                            </div>
                        </div>
                        <div class="item-group control-group clearfix">
                            <label for="alibaba_href" class="col-sm-6"><?php _e('Alibaba link', 'aliprice') ?></label>
                            <div class="col-sm-18">
                                <input type="text" class="standart" id="alibaba_href" name="alibaba_href" placeholder="" value="<?php echo $this->alibaba_href ?>">
                            </div>
                        </div>
                        <div class="item-group">
                            <button class="btn orange-bg" name="setting_submit"><span class="fa fa-floppy-o"></span> <?php _e("Save Changes", "aliprice") ?></button>
                            <button class="btn grey-bg" name="update_products"><span class="fa fa-refresh"></span> <?php _e("Update Links", "aliprice") ?></button>
                        </div>
                        <div class="item-group">
                            <p><em><?php _e("Update all Tracking IDs and product affiliate links.", "aliprice")?></em></p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12">
                <div id="testConnection"></div>
                <div id="update" style="display:none">
                    <label class="descript"><?php _e("Overall Progress", 'aliprice') ?> <span class="loader" style="display:none"></label>
                    <div class="progress" id="total-progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div>
                    </div>
                </div>
                <div class="info-programm" id="program-portals">
                    <div class="item">
                        <p class="text-center"><img src="<?php echo plugins_url( 'aliprice/img/portals.png') ?>" alt="Portals"></p>
                        <h3 class="text-center">Portals AliExpress</h3>
                        <p class="up">AliExpress offers its own platform for affiliate marketing, also known as the Portals Affiliate Program.</p>
                        <p>Main features:</p>
                        <ul>
                            <li>8% commission on all paid and delivered orders</li>
                            <li>Approval Time Frames – 7-15 days</li>
                            <li>Payouts rate – once a month</li>
                            <li>Payment methods – wire transfer</li>
                        </ul>
                        <p class="text-center">
                            <a href="http://portals.aliexpress.com/join.htm?refer=aliprice" target="_blank" class="btn orange-bg"><?php _e("Register Now", "aliprice") ?></a>
                            <a href="http://partner.aliprice.com/" target="_blank" class="btn green-bg"><?php _e("Instructions", "aliprice") ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public function tmplCleanup() {

        ?>

        <div class="content-inner" id="remove">
            <label class="descript"><?php _e("Overall Progress", 'aliprice') ?> <span class="loader" style="display:none"></span></label>
            <div class="progress" id="total-progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div>
            </div>
            <div class="item-group">
                <button class="btn grey-bg" name="remove"><span class="fa fa-remove"></span> <?php _e("Remove", "aliprice") ?></button>
            </div>
        </div>
    <?php
    }


    /**
     *
     */
    public function tmplCurrency() {

        $defaults = array(
            'inteval'	=> 'daily',
            'enabled'	=> '0',
            'currency'	=> '',
            'value'		=> '',
            'round'		=> '0'
        );

        $args = get_site_option('aliprice-currency');
        $args = ( !$args ) ? array() : unserialize($args);

        $args = wp_parse_args( $args, $defaults );

        ?>
        <div class="content-inner">

            <form action="" method="POST">

                <?php wp_nonce_field( 'aliprice_currency_action', 'aliprice_currency' ); ?>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6" for="currency"><?php _e('Select Currency', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <select name="currency" id="currency" class="standart">
                            <?php $cur_arr = aliprice_currency_codes();

                            foreach( $cur_arr as $key => $str ) {
                                $select = ($key == $args['currency']) ? 'selected="selected"' : '';
                                echo '<option value="' . $key . '" ' . $select . '>' . $str . '</option>';
                            } ?>
                        </select>
                        <p><em><?php _e('Convert U.S. Dollars to foreign currencies', 'aliprice') ?></em></p>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6 no-top" for="enabled"><?php _e('Status', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="checkbox" name="enabled" id="enabled" value="1" <?php echo ($args['enabled'] == 1) ?
                            'checked="checked"' : '' ?>> <?php _e('Enable currency converter', 'aliprice')?>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6 no-top" for="round"><?php _e('Rounding', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="checkbox" name="round" id="round" value="1" <?php echo ($args['round'] == 1) ?
                            'checked="checked"' : '' ?>>
                        <?php _e('The Prices will be rounded off to an integer', 'aliprice')?>
                    </div>
                </div>

                <div class="item-group">
                    <button class="btn orange-bg"><span class="fa fa-floppy-o"></span> <?php _e("Save Changes", "aliprice") ?></button>
                </div>
            </form>
        </div>
    <?php
    }

    /**
     * Template Dashboard
     */
    public function tmplDashboard() {

        ?>
        <div class="dash-header">
            <div class="row">
                <div class="col-sm-8 text-center">
                    <div class="content-inner plate-orange-bg">
                        <div class="count"><?php echo wp_count_posts('products')->publish; ?></div>
                        <h3 class="stat"><?php _e('Total Number of Products', 'aliprice') ?></h3>
                    </div>
                </div>
                <div class="col-sm-8 text-center">
                    <div class="content-inner plate-red-bg">
                        <div class="count"><?php echo aliprice_total_count_views() ?></div>
                        <h3 class="stat"><?php _e('Total Products Views', 'aliprice') ?></h3>
                    </div>
                </div>
                <div class="col-sm-8 text-center">
                    <div class="content-inner plate-blue-bg">
                        <div class="count"><?php echo aliprice_total_count_redirects() ?></div>
                        <h3 class="stat"><?php _e('Total Redirected to AliExpress', 'aliprice') ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="white-bg full-width">
            <div class="row">
                <div class="col-sm-24 text-center">
                    <a href="http://partner.aliprice.com/" target="_blank" class="btn orange-bg"><?php _e('How It Works', 'aliprice') ?></a> &nbsp;
                    <a href="http://www.aliprice.com/static.php?page=contact" target="_blank" class="btn grey-bg"><?php _e('Contact Us', 'aliprice') ?></a>
                    <form class="inline_form" action="" method="POST">
                        <?php wp_nonce_field( 'aliprice_reset_action', 'aliprice_reset' ); ?>
                        <input type="hidden" name="page" value="aliprice">
                        <input type="submit" name="reset" value="<?php _e('Reset Counter', 'aliprice') ?>" class="btn orange-bg">
                    </form>
                    <form method="POST" class="inline_form">
                        <input type="hidden" name="menu_reset" value="1"/>
                        <button type="submit"  class="btn orange-bg">Reset Menu</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        $total = array( 20, 30, 50 );
        $current_total = isset($_POST['count_total']) ? intval($_POST['count_total']) : 20;
        ?>

        <div class="content-inner nobg">
            <div class="row">
                <div class="col-md-24">
                    <div class="item-panel">
                        <form action="<?php echo admin_url( 'admin.php?page=aliprice' ) ?>" method="GET">
                            <label for="count_total"><?php _e('Top', 'aliprice') ?></label>
                            <select name="count_total" id="count_total">
                                <?php
                                foreach( $total as $t ) {
                                    $selected = ($current_total == $t) ? 'selected="selected"' : '' ;
                                    echo '<option value="' . $t . '" ' . $selected . '>' . $t . '</option>';
                                }
                                ?>
                            </select>
                            <?php _e('Products Performances', 'aliprice') ?>
                            <input type="hidden" name="page" value="aliprice">
                            <input type="submit" name="submit" value="<?php _e('Apply Filter', 'aliprice') ?>" class="btn orange-bg">
                        </form>
                    </div>
                </div>
            </div>

            <?php $this->catch_dashboard() ?>

        </div>

    <?php
    }

    /**
     *	Dropdown categories to import form
     */
    public function tmplDropDownCat() {

        ?>
        <div class="item-group item-control clearfix">
            <label for="alicategories" class="col-sm-6" for="dropcat"><?php _e("Categories", 'aliprice') ?></label>
            <div class="col-sm-14">
                <select name="dropcat" id="dropcat" class="w100">
                    <option value="0"> ---- </option>
                    <?php $this->taxonomy_options( 'shopcategory', 0, 0, null ); ?>
                </select>
                <p><em><?php _e("Select the category if you want to upload products in your own categories. Leave this field blank to make the Plugin create categories and upload products automatically. Necessary when selected All Categories", 'aliprice') ?></em><br />
                    <a href="<?php echo admin_url('edit-tags.php?taxonomy=shopcategory&post_type=products') ?>"
                       target="_blank">+ <?php _e("Add new Category", 'aliprice') ?></a></p>
            </div>
        </div>
        <div class="item-group control-group clearfix">
            <label for="alistatus" class="col-sm-6"><?php _e('Status', 'aliprice') ?></label>
            <div class="col-sm-14">
                <select id="alistatus" name="publishstatus" class="standart">
                    <?php
                    $status = ad_constant_status();
                    foreach( $status as $key => $val )
                        printf(
                            '<option value="%1$s">%2$s</option>',
                            $key,
                            $val
                        );
                    ?>
                </select>
                <p><em><?php _e("Use Publish option if you want to publish products instantly. Use Draft option if you need to edit products before they appear on your site.", 'aliprice') ?></em></p>
            </div>
        </div>
    <?php
    }

    /**
     *	Template Bulk Import
     */
    public function tmplBulk() {

        $this->tmplFormImport();
    }

    /**
     *	Template Bulk Import
     */
    public function tmplAdvanced() {

        ?>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close', 'aliprice') ?></span></button>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="link active">
                                <a href="#link" role="tab" data-toggle="tab"><?php _e('Promoted by link', 'aliprice') ?></a>
                            </li>
                            <li role="presentation" class="banner">
                                <a href="#banner" role="tab" data-toggle="tab"><?php _e('Promoted by banner', 'aliprice') ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="link">
                                <div class="item title clearfix">
                                    <label><?php _e('Promote with Link', 'aliprice') ?>:</label>
                                    <span></span>
                                </div>
                                <div class="item code clearfix">
                                    <label for="promo-text"><?php _e('HTML Code', 'aliprice') ?>:</label>
										<span>
											<textarea id="promo-text" readonly></textarea>
										</span>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="banner">
                                <div class="item thumb clearfix">
                                    <label><?php _e('Banner Preview', 'aliprice') ?>:</label>
                                    <span></span>
                                </div>
                                <div class="item title clearfix">
                                    <label><?php _e('Promote with Link', 'aliprice') ?>:</label>
                                    <span></span>
                                </div>
                                <div class="item code clearfix">
                                    <label for="promote-bann"><?php _e('HTML Code', 'aliprice') ?>:</label>
										<span>
											<textarea id="promote-bann" readonly></textarea>
										</span>
                                </div>
                            </div>
                        </div>
                        <div id="spinner-load" style="display:none">
                            <div class="content-inner noborder">
                                <div class="load text-center">
                                    <span class="fa fa-cog fa-spin fa-4x"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tablist">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab"><?php _e("General Search", "aliprice")?></a></li>
                <li role="presentation"><a href="#byid" aria-controls="byid" role="tab" data-toggle="tab"><?php _e("Search by Product ID", "aliprice") ?></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="general">
                    <?php $this->tmplFormImport('advanced'); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="byid">
                    <?php $this->tmplFormById() ?>
                </div>
            </div>
        </div>
    <?php
    }

    /**
     *	Template for Bulk and Advanced forms
     */
    public function tmplFormImport( $class = 'bulk' ) {

        ?>
        <form action="" method="POST" class="<?php echo $class ?> import-step-one">
            <div class="load text-center" style="display:none">
                <span class="fa fa-lock fa-4x"></span>
            </div>
            <div class="content-inner">

                <div class="item-group control-group clearfix">
                    <label for="alicategories" class="col-md-3 col-sm-6"><?php _e('Select Category', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <?php echo aliprice_dropdown_categories( 'categories', 'standart' ) ?>
                    </div>
                </div>

                <div class="item-group control-group clearfix" id="subcategory-form-item-wrap" style="display: none;">
                    <label for="subcategories" class="col-md-3 col-sm-6"><?php _e('Select Subcategory', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <?php echo aliprice_dropdown_subcategories( 'subcategories', 'standart' ) ?>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label for="keywords" class="col-md-3 col-sm-6"><?php _e('Enter Keywords', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="" id="keywords" name="keywords" maxlength="50" placeholder="">
                        <p><em><?php _e("Leave the field blank to import ALL products from selected category", 'aliprice')?></em></p>
                    </div>
                </div>
					<?php    $program = get_site_option( 'aliprice-program' ); $commis = ($program && $program != 'admitad') ? '8%' : '8,5%'; ?>
                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6" for="amount"><?php _e('Commission Rate', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" id="amount" class="standart" value="<?php echo $commis;?>" readonly>
                        <p><em><?php _e("Fixed commission for all categories", 'aliprice') ?></em></p>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Purchase Volume', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="standart" name="promotionfrom"> -
                        <input type="text" class="standart" name="promotionto">
                        <p><em><?php _e("The amount of purchases of the product over the last 30-day period", 'aliprice') ?></em></p>
                    </div>
                    <div class="col-md-12 col-sm-24">
                        <div id="slider-promotion" class="slider-range"></div>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Feedback Score', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="standart" name="creditScoreFrom"> -
                        <input type="text" class="standart" name="creditScoreTo">
                        <p><em><?php _e("The total number of positive feedback received by a seller", 'aliprice') ?></em></p>
                    </div>
                    <div class="col-md-12 col-sm-24">
                        <div id="slider-credit" class="slider-range"></div>
                    </div>
                </div>

                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Unit Price', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="standart" name="pricefrom"> -
                        <input type="text" class="standart" name="priceto"> USD
                    </div>
                </div>


                <div class="item-group">
                    <input type="hidden" name="sort" value="validTimeDown">
                    <button type="button" name="search-submit" class="btn green-bg"><span class="fa fa-search"></span> <?php _e("Apply Filter", 'aliprice') ?></button>
                </div>
            </div>
        </form>

        <div id="request-data" style="display:none">
            <div class="content-inner">
                <div class="load text-center">
                    <span class="fa fa-cog fa-spin fa-4x"></span>
                </div>
                <div id="request-content" class="bulk-settings"></div>
            </div>
        </div>
    <?php
    }

    /**
     * Template Advanced Import Review
     */
    public function tmplReview() {

        ?>
        <div class="content-inner-type">
            <div class="row height-full width-full">
                <div class="col-sm-12 height-full">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td class="panel-info" width="50%" valign="top">
                                <h3><?php _e('Review Uploading Tool', 'aliprice') ?></h3>
                                <p><?php _e('The process works in 4 steps. 10 reviews are added to each product on your store during every step.', 'aliprice' ) ?></p>
                                <p><?php _e('After completion of all 4 steps you will get up to 40 reviews for each item.', 'aliprice') ?></p>
                                <p><?php _e('You can update reviews anytime without getting duplicated ones.', 'aliprice') ?></p>

                                <div class="item-group control-group clearfix">
                                    <label class="col-sm-6"><?php _e('Select Rating', 'aliprice') ?></label>
                                    <div class="col-sm-18">
                                        <select name="rating" class="standart" style="color:#000">
                                            <?php
                                            for($i = 1; $i <= 5; $i++) {
                                                $select = ($i == 5) ? 'selected="selected"' : '';
                                                printf(
                                                    '<option value="%1$d" %2$s>%3$s %1$d</option>',
                                                    $i, $select, __('Star','aliprice')
                                                );
                                            }
                                            ?>
                                        </select>
                                        <p><em><?php _e('Do not import the reviews with a rating less than selected', 'aliprice') ?></em></p>
                                    </div>
                                </div>

                                <p class="submit">
                                    <button class="btn" id="load">
                                        <span class="fa fa-download"></span> <?php _e("Import Reviews", "aliprice") ?>
                                    </button>
                                </p>
                            </td>
                            <td class="progress-circle" width="50%" valign="top">
                                <h4><?php _e('Overall Progress', 'aliprice') ?></h4>
                                <div id="loader-one" class="action-loader"></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-12 height-full">
                    <input type="hidden" name="pages" value="4">
                    <div class="row width-full height-full">
                        <div class="col-sm-6">
                            <div class="stats">
                                <h4><?php _e('Stats', 'aliprice') ?></h4>
                                <div class="shelf"><span><?php echo aliprice_total_count_products() ?></span> <?php _e('Products', 'aliprice') ?></div>
                                <div class="shelf"><span id="reviews"><?php echo aliprice_total_count_reviews() ?></span> <?php _e('Reviews', 'aliprice') ?></div>
                                <div class="shelf"><span id="current">0</span> <?php _e('Current position', 'aliprice') ?></div>
                            </div>
                        </div>
                        <div class="col-sm-13 height-full">
                            <div id="listing"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="" method="POST" class="import-step-one sheduled">

            <?php

            $defaults = array(
                'inteval' 			=> 'daily',
                'enabled' 			=> 0,
                'position' 			=> 1,
                'count_settings'	=> 40,
                'star'              => 1
            );

            $args = get_site_option('aliprice-scheduled-review');
            $args = ( !$args ) ? array() : unserialize($args);
            $args = wp_parse_args( $args, $defaults );
            ?>

            <?php wp_nonce_field( 'aliprice_cron_submit_review', 'cron_submit_review' ); ?>

            <div class="content-inner">
                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6" for="inteval"><?php _e('Select Interval', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <select name="inteval" id="inteval" class="standart">
                            <?php
                            $int = aliprice_get_cron_intervals();

                            foreach( $int as $key => $str ) {

                                $select = ($key == $args['inteval']) ? 'selected="selected"' : '';

                                echo '<option value="' . $key . '" ' . $select . '>' . $str . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="item-group control-group clearfix">
                    <label class="col-md-3 col-sm-6" for="star"><?php _e('Select Rating', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <select name="star" id="star" class="standart">
                            <?php
                            for($i = 1; $i <= 5; $i++) {
                                $select = ($i == $args['star']) ? 'selected="selected"' : '';
                                printf(
                                    '<option value="%1$d" %2$s>%3$s %1$d</option>',
                                    $i, $select, __('Star')
                                );
                            }
                            ?>
                        </select>
                        <p><em><?php _e('Do not import the reviews with a rating less than selected', 'aliprice') ?></em></p>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6" for="enabled"><?php _e('Status', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="checkbox" name="enabled" id="enabled" value="1" <?php echo ($args['enabled'] == 1) ? 'checked="checked"' : '' ?>> <?php _e('Enabled Scheduled Import', 'aliprice')?>

                        <input type="hidden" name="position" value="<?php echo $args['position']; ?>">
                    </div>
                </div>
                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6" for="count_settings"><?php _e('Count of reviews', 'aliprice')?></label>
                    <div class="col-md-2 col-sm-5">
                        <input type="text" name="count_settings" id="count_settings" class="" value="<?php echo $args['count_settings']; ?>" >
                    </div>
                </div>
                <div class="item-group item-control clearfix">
                    <button class="btn orange-bg"><span class="fa fa-floppy-o"></span> <?php _e("Start Import Review", "aliprice") ?></button>
                </div>
            </div>
        </form>
    <?php
    }

    /**
     *	Template for Search by ID
     */
    public function tmplFormById() {

        ?>
        <form action="" method="POST" class="byproducts import-step-one">
            <div class="load text-center" style="display:none">
                <span class="fa fa-lock fa-4x"></span>
            </div>
            <div class="content-inner">
                <div class="item-group control-group clearfix">
                    <p class="description"><?php _e("Search for products by using the product ID", "aliprice") ?>. <a href="http://alipartnership.com/codex/how-to-find-and-use-product-id/" target="_blank"><?php _e("Where can I find product ID?", "aliprice")?></a></p>
                </div>
                <div class="item-group control-group clearfix">
                    <div class="col-md-12 col-sm-24">
                        <input type="text" class="" id="productId" name="productId" placeholder="">
                        <p><em><?php _e("Enter Product ID or a list of Product IDs separated by commas", 'aliprice')?></em></p>
                    </div>
                </div>

                <div class="item-group">
                    <input type="hidden" name="sort" value="">
                    <button type="button" name="search-id-submit" class="btn green-bg"><span class="fa fa-search"></span> <?php _e("Search", 'aliprice') ?></button>
                </div>
            </div>
        </form>

        <div id="request-data-by-id" style="display:none">
            <div class="content-inner">
                <div class="load text-center">
                    <span class="fa fa-cog fa-spin fa-4x"></span>
                </div>
                <div id="request-content-id" class="search-id-settings"></div>
            </div>
        </div>
    <?php
    }

    /**
     *	Template Scheduled Import
     */
    public function tmplScheduled() {

        ?>

        <form action="" method="POST" class="import-step-one sheduled">

            <?php

            $defaults = array(
                'categories' 		=> '',
                'keywords' 			=> '',
                'promotionfrom' 	=> '10',
                'promotionto' 		=> '5000',
                'pricefrom' 		=> '',
                'priceto' 			=> '',
                'inteval' 			=> 'daily',
                'enabled' 			=> '0',
                'all_match'			=> '10',
                'creditScoreFrom'	=> '0',
                'creditScoreTo'		=> '1000',
                'fs'                => '0',
                'unitType'          => '',
            );

            $args = get_site_option('aliprice-scheduled');

            $args = ( !$args ) ? array() : unserialize($args);

            $args = wp_parse_args( $args, $defaults );

            ?>

            <?php wp_nonce_field( 'aliprice_cron_submit', 'cron_submit' ); ?>

            <div class="content-inner">

                <div class="item-group control-group clearfix">
                    <label for="alicategories" class="col-md-3 col-sm-6"><?php _e('Select Category', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <?php echo aliprice_dropdown_categories( 'categories', 'standart', $args['categories'] ) ?>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label for="keywords" class="col-md-3 col-sm-6"><?php _e('Enter Keywords', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" id="keywords" name="keywords" placeholder=""  maxlength="50" value="<?php echo $args['keywords'] ?>">
                        <p><em><?php _e("Leave the field blank to import ALL products from selected category", 'aliprice')?></em></p>

                    </div>
                </div>
                <div class="item-group item-control clearfix">
                    <label for="alicategories" class="col-sm-3"><?php _e("Categories", 'aliprice') ?></label>
                    <div class="col-sm-8">
                        <select name="dropcat" id="dropcat" class="w100">
                            <option value="0"> ---- </option>
                            <?php $this->taxonomy_options( 'shopcategory', 0, 0, $args['dropcat'] ); ?>
                        </select>
                        <p><em><?php _e("Select the category if you want to upload products in your own categories. Leave this field blank to make the Plugin create categories and upload products automatically. Necessary when selected All Categories", 'aliprice') ?></em><br />
                            <a href="<?php echo admin_url('edit-tags.php?taxonomy=shopcategory&post_type=products') ?>"
                               target="_blank">+ <?php _e("Add new Category", 'aliprice') ?></a></p>
                    </div></div>
					<?php   $program = get_site_option( 'aliprice-program' );$commis = ($program && $program != 'admitad') ? '8%' : '8,5%'; ?>
                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Commission Rate', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" id="amount" class="standart" value="<?php echo $commis;?>" readonly>
                        <p><em><?php _e("Fixed commission for all categories", 'aliprice') ?></em></p>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Purchase Volume', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="standart" name="promotionfrom" value="<?php echo $args['promotionfrom'] ?>"> -
                        <input type="text" class="standart" name="promotionto" value="<?php echo $args['promotionto'] ?>">
                        <p><em><?php _e("The amount of purchases of the product over the last 30-day period", 'aliprice') ?></em></p>
                    </div>
                    <div class="col-md-12 col-sm-24">
                        <div id="slider-promotion" class="slider-range"></div>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Feedback Score', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="standart" name="creditScoreFrom" value="<?php echo $args['creditScoreFrom'] ?>"> -
                        <input type="text" class="standart" name="creditScoreTo" value="<?php echo $args['creditScoreTo'] ?>">
                        <p><em><?php _e("The total number of positive feedback received by a seller", 'aliprice') ?></em></p>
                    </div>
                    <div class="col-md-12 col-sm-24">
                        <div id="slider-credit" class="slider-range"></div>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Unit Price', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" class="standart" name="pricefrom" value="<?php echo $args['pricefrom'] ?>"> -
                        <input type="text" class="standart" name="priceto" value="<?php echo $args['priceto'] ?>"> USD
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Select Interval', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <select name="inteval" class="standart">
                            <?php
                            $int = aliprice_get_cron_intervals();

                            foreach( $int as $key => $str ) {

                                $select = ($key == $args['inteval']) ? 'selected="selected"' : '';

                                echo '<option value="' . $key . '" ' . $select . '>' . $str . '</option>';
                            }
                            ?>
                        </select>
                        <p><em><?php _e('One-time update can refresh only 10 products for one cycle.', 'aliprice') ?></em></p>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Status', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="checkbox" name="enabled" value="1" <?php echo ($args['enabled'] == 1) ?
                            'checked="checked"' : '' ?>> <?php _e('Enabled Scheduled Import', 'aliprice')?>
                    </div>
                </div>
                <div class="item-group item-control clearfix">
                    <label class="col-md-3 col-sm-6"><?php _e('Shipping', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="checkbox" id="fs" name="fs" value="1" <?php echo ($args['fs'] == 1) ?
                            'checked="checked"' : '' ?>>
                        <?php _e('Import products with free shipping option only', 'aliprice')?>
                    </div>
                </div>
                <div class="item-group item-control clearfix">
                    <label class="col-sm-3" for="unitType">
                        <?php _e("Unit Type", 'aliprice') ?>
                    </label>
                    <div class="col-sm-8">
                        <?php
                        $unitTypes = array(
                            ''      => '---',
                            'piece' => __('Piece', 'aliprice'),
                            'lot'   => __('Lot', 'aliprice')
                        )
                        ?>
                        <select id="unitType" name="unitType" class="w100">
                            <?php
                            foreach($unitTypes as $key => $val) {
                                $select = $key == $args['unitType'] ? 'selected="selected"' : '';
                                echo '<option value="' . $key . '" ' . $select . '>' . $val . '</option>';
                            }
                            ?>
                        </select>
                        <p><em><?php _e('Import products with checked unit type', 'aliprice')?></em></p>
                    </div>
                </div>
                <div class="item-group control-group clearfix">
                    <label for="alistatus" class="col-sm-3"><?php _e('Publish Status', 'aliprice') ?></label>
                    <div class="col-sm-8">
                        <select id="alistatus" name="publishstatus" class="standart">
                            <?php
                            $statuss = ad_constant_status();
                            foreach( $statuss as $key => $val ) {
                                $selects = ($key == $args['publishstatus']) ? 'selected="selected"' : '';
                                printf(
                                    '<option value="%1$s" %3$s>%2$s</option>',
                                    $key,
                                    $val,
                                    $selects
                                );
                            };
                            ?>

                        </select>
                        <p><em><?php _e("Use Publish option if you want to publish products instantly. Use Draft option if you need to edit products before they appear on your site.", 'aliprice') ?></em></p>
                    </div>
                </div>

                <div class="item-group item-control clearfix">
                    <button class="btn green-bg" id="sheduled-filter"><span class="fa fa-exclamation-circle"></span> <?php _e("Apply Filter", "aliprice") ?></button>
                </div>

                <div id="result-apply" style="display:none">

                    <div class="item-group item-control clearfix">
                        <?php _e("Total number of Products available for importing:", 'aliprice') ?> <span id="filter-result"></span>
                        <p><em><?php _e("You can not upload more than 10,000 Products at once.", 'aliprice') ?></em></p>
                    </div>

                    <div class="item-group item-control clearfix">
                        <label for="all_match"><?php _e("Choose the number of products to import", 'aliprice') ?></label>
                        <input type="text" id="all_match" class="standart" name="all_match" placeholder="" value="<?php echo $args['all_match'] ?>">
                    </div>

                    <div class="item-group item-control clearfix">
                        <button class="btn orange-bg"><span class="fa fa-floppy-o"></span> <?php _e("Start Import", "aliprice") ?></button>
                    </div>
                </div>

            </div>
        </form>
    <?php
    }

    /**
     *	Template Scheduled Import
     */
    public function tmplTranslate() {

        $langs = aliprice_list_lang();
        ?>
        <div class="content-inner">
            <form id="setting-translate">
                <div class="item-group control-group clearfix">
                    <label for="translate_to" class="col-md-3 col-sm-6"><?php _e('Translate from', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <select name="translate_to" id="translate_to" class="standart">
                            <?php
                            foreach( $langs as $key => $val ) {
                                $selected = ( $key == 'en' ) ? 'selected="selected"' : '';
                                echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="item-group control-group clearfix">
                    <label for="current_lang" class="col-md-3 col-sm-6"><?php _e('Translate to', 'aliprice') ?></label>
                    <div class="col-md-9 col-sm-18">
                        <input type="text" id="current_lang" class="standart"
                               value="<?php echo $langs[ALIPRICE_LANG] ?>" readonly>
                        <p>
                            <em><?php _e("This parameter can be changed in", 'aliprice') ?>
                                <a href="<?php echo admin_url('admin.php?page=aliprice&aepage=api') ?>">
                                    <?php _e('Configuration', 'aliprice')?>
                                </a>
                            </em>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        <div class="content-inner">

            <?php
            $data = get_posts( array('post_type' => 'page', 'orderby' => 'post_title', 'order' => 'ASC', 'posts_per_page' => '-1') );
            $this->translate_table( __('Pages', 'aliprice'), 'page', $data );

            $terms = get_terms('shopcategory');
            $this->translate_table( __('Product Categories', 'aliprice'), 'taxonomy', $terms );
            ?>
        </div>
    <?php
    }

    public function translate_table( $h2_title, $type, $data ) {
        ?>
        <div class="inner-block import-settings">
            <form action="" method="POST" id="translate-<?php echo $type ?>">

                <h2 class="inner-single">
                    <?php echo $h2_title ?>
                    <button class="btn orange-bg" name="do-translate">
                        <span class="fa fa-file-text-o"></span> <?php _e("Translate Now", 'aliprice') ?>
                        <span class="count-import">(0)</span>
                    </button>
                </h2>

                <div class="row">
                    <div class="col-md-24">
                        <label class="descript"><?php _e("Overall Progress", 'aliprice') ?> <span class="loader" style="display:none"></label>
                        <div class="progress" id="total-progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div>
                        </div>
                    </div>
                </div>
            </form>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover advanced-result">
                <thead>
                <tr>
                    <th><span class="fa fa-1 fa-square-o mass-checked"></span></th>
                    <th><?php _e('Title', 'aliprice') ?></th>
                    <th><?php _e('Original Title', 'aliprice') ?></th>
                    <th><?php _e('Action', 'aliprice') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php

                if( !$data || empty($data) )
                    echo '<tr><td colspan="4"><h3>' . __('Not Found', 'aliprice') . '</h3></td></tr>';

                else foreach( $data as $item ){

                    if( $type == 'page' ) {
                        $title 		= $item->post_title;
                        $id 		= $item->ID;
                        $original 	= get_post_meta($id, 'aliprice_original_title', true);
                    }
                    elseif( $type == 'taxonomy' ) {
                        $title 		= $item->name;
                        $id 		= $item->term_id;
                        $original 	= get_site_option('aliprice_original_title_' . $id, '');
                    }
                    ?>
                    <tr>
                        <td class="cb"><input type="checkbox" name="cb" data-type="<?php echo $type ?>" value="<?php echo $id ?>"></td>
                        <td class="title can_edited"><span class="item-inner-info"><?php echo $title ?></span> <span class="this-edit fa fa-pencil-square-o"></span></td>
                        <td class="original"><span class="item-inner-info"><?php echo $original ?></span></td>
                        <td class="action">
                            <a href="#" data-do="repair" data-type="<?php echo $type ?>" class="ae-action" title="<?php _e('Repair Original', 'aliprice')?>"><span class="fa fa-2x fa-undo"></span></a> &nbsp;
                            <a href="#" data-do="translate" data-type="<?php echo $type ?>" class="ae-action" title="<?php _e('Translate', 'aliprice')?>"><span class="fa fa-2x fa-file-text-o"></span></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    <?php
    }

    /**
     *	Catch request from form dashboard
     */
    public function catch_reset() {

        if ( isset( $_POST['aliprice_reset'] ) && wp_verify_nonce( $_POST['aliprice_reset'], 'aliprice_reset_action' ) ) :

            reset_counts();

        endif;
    }

    /**
     *	Catch request from form
     */
    public function catch_request() {

        if ( isset( $_POST['aliprice_setting'] ) && wp_verify_nonce( $_POST['aliprice_setting'], 'aliprice_setting_action' ) ) :

            update_site_option( 'aliprice-partner_username', sanitize_user($_POST['Partner_username']) );
            update_site_option( 'aliprice-partner_password', md5($_POST['Partner_password']));
            update_site_option( 'aliprice-partner_pwd', $_POST['Partner_password']);
            update_site_option( 'aliprice-app-key', $_POST['AppKey']);
            update_site_option( 'aliprice-tracking', $_POST['trackingId']);
            update_site_option( 'aliprice-method', $_POST['method'] );
            update_site_option( 'aliprice-language', $_POST['language'] );
            update_site_option( 'aliprice-todaysdeal', (isset($_POST['todaysdeal']) ? intval($_POST['todaysdeal']) : 0));
            update_site_option( 'aliprice-hotdeal', (isset($_POST['hotdeal']) ? intval($_POST['hotdeal']) : 0));
            update_site_option( 'aliprice-alibaba', (isset($_POST['alibaba']) ? intval($_POST['alibaba']) : '' ));
            update_site_option( 'aliprice-alibaba_href', trim($_POST['alibaba_href']) );

            ?>
            <div id="message" class="updated"><p>Setting <strong>saved</strong>.</p></div>
        <?php

        elseif( isset( $_POST['aliprice_autoupdate'] ) && wp_verify_nonce( $_POST['aliprice_autoupdate'], 'aliprice_autoupdate_action' ) ) :

            $defaults = array(
                'inteval' 		=> 'daily',
                'enabled' 		=> '0',
                'description'	=> '0',
                'etitle'		=> '0',
            );

            $args = wp_parse_args( $_POST, $defaults );

            update_site_option( 'aliprice-autoupdate', serialize( $args ) );

            $delete = $_POST['delete'];
            update_site_option( 'aliprice-delete', $delete );

            wp_clear_scheduled_hook( 'aliprice_cron_event' );

            ?>
            <div id="message" class="updated"><p><?php _e('Automatic Updates', 'aliprice')?> <strong><?php _e('saved', 'aliprice') ?></strong>.</p></div>
        <?php

        elseif( isset( $_POST['aliprice_currency'] ) && wp_verify_nonce( $_POST['aliprice_currency'], 'aliprice_currency_action' ) ) :

            $defaults = array(
                'inteval' 	=> 'daily',
                'enabled' 	=> '0',
                'currency' 	=> '',
                'value'		=> '',
                'round'		=> '0'
            );

            $args = get_site_option('aliprice-currency');
            $args = ( !$args ) ? array() : unserialize($args);

            $args = wp_parse_args( $args, $defaults );

            $currency = strip_tags($_POST['currency']);

            $value = aliprice_convertCurrency( 1, 'USD', $currency );

            if( !$value ) {
                ?>
                <div id="message" class="updated"><p><?php _e('Currency converter settings will not be saved', 'aliprice')?>.</p></div>
                <?php
                return;
            }

            $foo = array(
                'inteval'	=> $args['inteval'],
                'enabled'	=> isset( $_POST['enabled'] ) ? 1 : 0,
                'currency'	=> $currency,
                'value'		=> $value,
                'round'		=> isset( $_POST['round'] ) ? 1 : 0
            );

            update_site_option( 'aliprice-currency', serialize($foo) );

            wp_clear_scheduled_hook( 'aliprice_cron_currency' );
            ?>
            <div id="message" class="updated"><p><?php _e('Currency converter settings', 'aliprice')?> <strong><?php _e('saved', 'aliprice') ?></strong>.</p></div>
        <?php

        endif;
    }

    /**
     *	Catch request from form
     */
    public function catch_cron( ) {

        if ( !isset( $_POST['cron_submit'] ) || !wp_verify_nonce( $_POST['cron_submit'], 'aliprice_cron_submit' ) ) return;

        $defaults = array(
            'categories' 		=> '',
            'keywords' 			=> '',
            'promotionfrom' 	=> '10',
            'promotionto' 		=> '5000',
            'pricefrom' 		=> '',
            'priceto' 			=> '',
            'creditScoreFrom'	=> '',
            'creditScoreTo'		=> '',
            'inteval' 			=> 'daily',
            'enabled' 			=> '0',
            'all_match'			=> '20',
            'page_no'			=> '1',
            'dropcat'           => '',
            'publishstatus'    => 'publish'
        );

        $args = wp_parse_args( $_POST, $defaults );

        update_site_option( 'aliprice-scheduled', serialize( $args ) );

        wp_clear_scheduled_hook( 'aliprice_cron_import' );

        ?>
        <div id="message" class="updated"><p><?php _e('Setting', 'aliprice')?> <strong><?php _e('saved', 'aliprice') ?></strong>.</p></div>
    <?php
    }
    public function catch_cron_review( ) {

        if ( !isset( $_POST['cron_submit_review'] ) || !wp_verify_nonce( $_POST['cron_submit_review'], 'aliprice_cron_submit_review' ) ) return;

        $defaults = array(
            'inteval' 			=> 'daily',
            'enabled' 			=> 0,
            'count_settings'	=> 40,
            'position' 			=> 1,
            'star'              => 1
        );

        $args = wp_parse_args( $_POST, $defaults );

        update_site_option( 'aliprice-scheduled-review', serialize( $args ) );

        wp_clear_scheduled_hook( 'aliprice_cron_review' );

        ?>
        <div id="message" class="updated"><p><?php _e('Setting', 'aliprice')?> <strong><?php _e('saved', 'aliprice') ?></strong>.</p></div>
    <?php
    }

    /**
     *	Catch request from dashboard
     */
    public function catch_dashboard( ) {

        $total = isset( $_GET['count_total'] ) ? intval( $_GET['count_total'] ) : 10;

        $foo = array( 20, 30, 50 );

        $per = in_array($total, $foo) ? $total : $foo[0];

        $posts = aliprice_sort_total_admin( $per );

        if( !$posts ) {
            ?>
            <h2><?php _e('Not found', 'aliprice') ?></h2>
            <?php

            return;
        }

        $i = 0;

        foreach( $posts as $post ) {

            $i++;

            $id = $post->ID;

            $views 		= get_post_meta($id, 'views', true);
            $redirects 	= get_post_meta($id, 'redirects', true);

            $views		= intval( $views );
            $redirects	= intval( $redirects );

            $info = new AEProducts( );
            $info->set( $id );

            $img = $info->getThumb( 'medium' );

            $img = ( $img ) ? '<img src="' . $img . '" class="img-responsive">' : '';

            if( $i == 1 ) echo '<div class="row">';

            ?>
            <div class="col-sm-12 col-md-8 col-lg-4">
                <div class="product-item">
                    <div class="thumbnail">
                        <a href="<?php echo get_permalink( $id ) ?>" title="<?php echo $post->post_title ?>" target="_blank">
                            <?php echo $img ?>
                        </a>
                    </div>
                    <div class="item-info">
                        <h3><?php echo $post->post_title ?></h3>
                        <p>
                            <?php _e('Views', 'aliprice') ?>: <?php echo $views ?><br />
                            <?php _e('Redirects', 'aliprice') ?>: <?php echo $redirects ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php

            if( $i == 6 ) { echo '</div>'; $i = 0; }
        }

        if( $i != 0 ) echo '</div>';
    }

    /**
     *	Generate Hierarhical to dropdown menu
     */
    public function taxonomy_options( $tax_slug, $parent = '', $level = 0, $selected = null ) {

        $args = array('hide_empty' => false);

        if( !is_null($parent) )
            $args['parent'] = $parent;

        $terms = get_terms( $tax_slug, $args );

        $tab = '';

        for( $i = 0; $i < $level; $i++ ) {
            $tab .= '--';
        }

        foreach ( $terms as $term ) {

            echo '<option value="' . $term->slug, $selected == $term->slug ? '" selected="selected"' : '"', '>' . $tab . $term->name . ' (' . $term->count . ')</option>';
            $this->taxonomy_options( $tax_slug, $term->term_id, $level+1, $selected );
        }
    }
}

?>