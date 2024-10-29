<?php
	
/**
* Add menu items to admin_menu
*/
add_action('admin_menu', 'aliprice_admin_menu');

function aliprice_admin_menu( ) {

    if ( function_exists('add_menu_page') ) {
        add_menu_page( __( 'AliPrice', 'aliprice' ), __( 'AliPrice', 'aliprice' ), 'activate_plugins', 'aliprice', 'aliprice_admin_index_form' );

    }
}

function aliprice_admin_index_form( ) {
    $obj = new AliExpressSettings();

    try {
        $obj->getTemplate();
    }
    catch( Exception $e ) { }
}

function aliprice_admin_migrate_ali( ) {

    ?>
        <h2><span class="fa fa-database"></span> <?php _e('AliPrice Migrate', 'aliprice') ?></h2>
        <div class="description"><?php _e('For proper operation of the plugin necessary to make changes to the database.', 'aliprice') ?></div>
        <form action="" method="POST">

            <?php wp_nonce_field( 'aliprice_migrate_action', 'aliprice_migrate' ); ?>
            <div class="item-group">
                <?php _e('Number of necessary changes', 'aliprice') ?>: <?php echo aliprice_check_db_fields() ?>
            </div>
            <div class="item-group">
                <button class="btn orange-bg" name="migrate_submit"><span class="fa fa-database"></span> <?php _e('Amend', 'aliprice')?></button>
            </div>
        </form>
    <?php

}

?>