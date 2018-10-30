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
    li{margin-bottom:0;}
    .arrow{margin-left:0;}
    #uc-parser .btn-light{background-color:#4786c5;border-color:#4786c5;}
    #uc-parser .btn-light:hover{background-color:#154c88;border-color:#154c88;}
    .btn-primary{background-color:#0085ba;border-color:#0073aa #006799 #006799;}
    .btn-primary:hover{background-color:#008ec2;border-color:#006799;}
    .dropdown-item.active,.dropdown-item:active{background-color:#0085ba;}
    .btn-primary:not(:disabled):not(.disabled).active,.btn-primary:not(:disabled):not(.disabled):active,.show>.btn-primary.dropdown-toggle{background-color:#008ec2;border-color:#006799;}
    a{color:#0073aa;}
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

            <div class="row">

                <div class="col ">

                    <h3 class="mb-4">Multiple dealers parsing</h3>

                    <form>

                        <div class="form-group">
                            <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                            <label id="label3" style="display: none" for="dealer_m">Select Dealers for Sync Cars <i data-toggle="tooltip" data-placement="top" title="showing after dealers will imported" class="fas fa-info-circle"></i></label>
                            <select style="display: none" class="form-control" name="dealer_m" id="dealer_m" data-live-search="true" data-style="btn-primary" data-container="body" multiple></select>
                        </div>

                        <div class="form-group">
                            <button style="display: none" id="save_list" type="button" class="btn btn-primary">Save List <i data-toggle="tooltip" data-placement="top" title="saving list for parsing" class="fas fa-info-circle"></i></button>
                            <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                        </div>

                        <div class="form-group">
                            <button style="display: none" id="sync_cars_m" type="button" class="btn btn-primary">Sync Cars <i data-toggle="tooltip" data-placement="top" title="save list before start" class="fas fa-info-circle"></i></button>
                            <i style="display: none" class="fa fa-sync fa-spin fa-3x fa-fw ml-2"></i>
                        </div>

                    </form>

                </div>


            </div>


        </div>

    </div>

</div>

<?

