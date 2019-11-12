<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= $page_title ?></h2>
    </div>
    <div class="box-content">
        <div class="row group-permission">
            <div class="col-lg-12"> 

            <?php $attrib = array('data-toggle' => 'validator', 'class' => 'form_settings', 'role' => 'form');
                echo admin_form_open_multipart("system_settings/form_settings/".$id, $attrib); ?>

                <p class="introtext"><?= lang("set_permissions"); ?></p>
                <?php
                    $permission = json_decode($result->permission);
                    ?>
                <input type="hidden" name="form_id" value="<?= $id ?>">
                <table class="table table-bordered table-hover table-striped reports-table">
                   
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center"><?= $form_result->name; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($id == 1){
                        ?>
                        <tr>
                           
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->head_of_family_enable == 1 ? 'checked' : '' ?> name="head_of_family_enable">
                                <?= lang("head_of_family"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->identification_number_enable == 1 ? 'checked' : '' ?> name="identification_number_enable">
                                <?= lang("identification_number"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->phone_number_enable == 1 ? 'checked' : '' ?> name="phone_number_enable">
                                <?= lang("phone_number"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->head_occupation_enable == 1 ? 'checked' : '' ?> name="head_occupation_enable">
                                <?= lang("head_occupation"); ?>
                            </td>
                        <tr>
                        <tr>
                            
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->member_of_family_enable == 1 ? 'checked' : '' ?> name="member_of_family_enable">
                                <?= lang("member_of_family"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->address_enable == 1 ? 'checked' : '' ?> name="address_enable">
                                <?= lang("address"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->number_of_pets_enable == 1 ? 'checked' : '' ?> name="number_of_pets_enable">
                                <?= lang("number_of_pets"); ?>
                            </td>
                            <td class="text-left" colspan="4">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->loan_enable == 1 ? 'checked' : '' ?> name="loan_enable">
                                <?= lang("loan"); ?>
                            </td>
                        <tr>
                       
                        <?php
                        }elseif($id == 2){
                        ?>
                        <tr>
                           
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->head_of_family_enable == 1 ? 'checked' : '' ?> name="head_of_family_enable">
                                <?= lang("head_of_family"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->identification_number_enable == 1 ? 'checked' : '' ?> name="identification_number_enable">
                                <?= lang("identification_number"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->phone_number_enable == 1 ? 'checked' : '' ?> name="phone_number_enable">
                                <?= lang("phone_number"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->head_occupation_enable == 1 ? 'checked' : '' ?> name="head_occupation_enable">
                                <?= lang("head_occupation"); ?>
                            </td>
                        <tr>
                        <tr>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->wife_name_enable == 1 ? 'checked' : '' ?> name="wife_name_enable">
                                <?= lang("wife_name"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->wife_identification_number_enable == 1 ? 'checked' : '' ?> name="wife_identification_number_enable">
                                <?= lang("wife_identification_number"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->wife_occupation_enable == 1 ? 'checked' : '' ?> name="wife_occupation_enable">
                                <?= lang("wife_occupation"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->member_of_family_enable == 1 ? 'checked' : '' ?> name="member_of_family_enable">
                                <?= lang("member_of_family"); ?>
                            </td>
                        <tr>
                        <tr>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->address_enable == 1 ? 'checked' : '' ?> name="address_enable">
                                <?= lang("address"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->number_of_pets_enable == 1 ? 'checked' : '' ?> name="number_of_pets_enable">
                                <?= lang("number_of_pets"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->total_land_size_enable == 1 ? 'checked' : '' ?> name="total_land_size_enable">
                                <?= lang("total_land_size"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->total_land_size_for_building_oven_enable == 1 ? 'checked' : '' ?> name="total_land_size_for_building_oven_enable">
                                <?= lang("total_land_size_for_building_oven"); ?>
                            </td>
                        <tr>
                        <tr>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->underground_water_level_during_dry_season_enable == 1 ? 'checked' : '' ?> name="underground_water_level_during_dry_season_enable">
                                <?= lang("underground_water_level_during_dry_season"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->raining_season_enable == 1 ? 'checked' : '' ?> name="raining_season_enable">
                                <?= lang("raining_season"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->hygine_enable == 1 ? 'checked' : '' ?> name="hygine_enable">
                                <?= lang("hygine"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->general_hygine_enable == 1 ? 'checked' : '' ?> name="general_hygine_enable">
                                <?= lang("general_hygine"); ?>
                            </td>
                        <tr>
                        <tr>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->source_of_water_enable == 1 ? 'checked' : '' ?> name="source_of_water_enable">
                                <?= lang("source_of_water"); ?>
                            </td>
                            <td class="text-left">
                                <input type="checkbox" value="1" class="checkbox" <?= $permission->budget_source_enable == 1 ? 'checked' : '' ?> name="budget_source_enable">
                                <?= lang("budget_source"); ?>
                            </td>
                            
                        <tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?=lang('update')?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

</div>
<style>
    .group-permission ul{
	list-style: none;
	
    }
    .reports ul{
    -moz-column-count: 4 !important;
    -moz-column-gap: 23px;
    -webkit-column-count: 4 !important;
    -webkit-column-gap: 23px;
    column-count: 4 !important;
    column-gap: 0px;/*23px;*/
    }
    .orders-settings ul,.billing-settings ul,.group-permission ul{
    -moz-column-count: 3;
    -moz-column-gap: 23px;
    -webkit-column-count: 3;
    -webkit-column-gap: 23px;
    column-count: 3;
    column-gap: 0px;/*23px;*/
    }
    .restaurants-group-permission ul li{
	 /*-moz-column-count: 1 !important;
    -moz-column-gap: 23px;
    -webkit-column-count: 1 !important;
    -webkit-column-gap: 23px;
    column-count: 1 !important;
    column-gap: 0px;*//*23px;*/
     display: block;
    float: left;
    width:45%
    }
</style>
