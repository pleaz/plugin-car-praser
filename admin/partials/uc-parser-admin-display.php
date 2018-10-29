<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://iha6.com
 * @since      1.0.0
 *
 * @package    Uc_Parser
 * @subpackage Uc_Parser/admin/partials
 */

// delete all users
/*$users = get_users( ['role'  => 'stm_dealer', 'meta_key' => 'stm_dealer_url'] );
foreach ($users as $value) {
   wp_delete_user( $value->ID );
}*/

?>
<style>
    li { margin-bottom: 0; }
    .arrow { margin-left:0; }
    #uc-parser .btn-light { background-color: #4786c5; border-color: #4786c5; }
    #uc-parser .btn-light:hover { background-color: #154c88; border-color: #154c88; }
</style>
<div id="uc-parser" class="wrap">

    <div class="container">
        <h2 class="mb-4"><?php echo esc_html( get_admin_page_title() ); ?></h2>

        <div id="error"></div>

        <div class="container">

            <div class="row">

                <div class="col">

                <form>

                    <div class="form-group">
                        <button id="check_dealers" type="button" class="btn btn-primary">Search Dealers <i data-toggle="tooltip" data-placement="top" title="check all pages UCNI for new dealers" class="fas fa-info-circle"></i></button>
                        <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                    </div>

                    <div class="form-group">
                        <label id="label" style="display: none" for="dealers">Select Dealers for Import</label>
                        <select style="display: none" class="form-control" name="dealers[]" id="dealers" data-live-search="true" data-style="btn-primary" data-actions-box="true" multiple></select>
                    </div>

                    <div class="form-group">
                        <button style="display: none" id="save_dealers" type="button" class="btn btn-primary">Save Dealers <i data-toggle="tooltip" data-placement="top" title="import selected dealers to user group" class="fas fa-info-circle"></i></button>
                        <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                    </div>

                </form>

                </div>


                <div class="col">

                <form>

                    <div class="form-group">
                        <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                        <label id="label2" style="display: none" for="dealer">Select Dealer for Sync Cars <i data-toggle="tooltip" data-placement="top" title="showing after dealers will imported" class="fas fa-info-circle"></i></label>
                        <select style="display: none" class="form-control" name="dealer" id="dealer" data-live-search="true" data-style="btn-primary" data-container="body"></select>
                    </div>

                    <div class="form-group">
                        <button style="display: none" id="sync_cars" type="button" class="btn btn-primary">Sync Cars <i data-toggle="tooltip" data-placement="top" title="parsing cars for selected dealer and import with deleting added before cars from UCNI" class="fas fa-info-circle"></i></button>
                        <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                    </div>

                </form>

                </div>

            </div>
        </div>

    </div>

</div>

<?

