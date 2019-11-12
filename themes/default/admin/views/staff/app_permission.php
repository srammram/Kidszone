<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("staff/app_permission_staff/".$id, $attrib);
                ?>
        <div class="row">
        	
            <input type="hidden" name="user_id" id="user_id" value="<?= $id ?>">
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("App Permission", "App Permission"); ?></legend>
					<div class="col-md-12">
						<div class="form-group budget_source_checkbox">
                        	<label class="col-sm-3"><input type="checkbox" name="formone_enable" <?= $app_permission->formone_enable == 1 ? 'checked' : '' ?> value="1"> Form 1</label>
                          <label class="col-sm-3"><input type="checkbox" name="formone_edit_enable" <?= $app_permission->formone_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 1 Edit</label>

                            <label class="col-sm-3"><input type="checkbox" name="formtwo_enable" <?= $app_permission->formtwo_enable == 1 ? 'checked' : '' ?> value="1"> Form 2</label>
                            <label class="col-sm-3"><input type="checkbox" name="formtwo_edit_enable" <?= $app_permission->formtwo_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 2 Edit</label>
                            
                            <label class="col-sm-3"><input type="checkbox" name="formthree_enable" <?= $app_permission->formthree_enable == 1 ? 'checked' : '' ?> value="1"> Form 3</label>
                            <label class="col-sm-3"><input type="checkbox" name="formthree_edit_enable" <?= $app_permission->formthree_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 3 Edit</label>

                            <label class="col-sm-3"><input type="checkbox" name="formfour_enable" <?= $app_permission->formfour_enable == 1 ? 'checked' : '' ?> value="1"> Form 4</label>
                            <label class="col-sm-3"><input type="checkbox" name="formfour_edit_enable" <?= $app_permission->formfour_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 4 Edit</label>
                            <label class="col-sm-3"><input type="checkbox" name="formfive_enable" <?= $app_permission->formfive_enable == 1 ? 'checked' : '' ?> value="1"> Form 5</label>
                            <label class="col-sm-3"><input type="checkbox" name="formfive_edit_enable" <?= $app_permission->formfive_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 5 Edit</label>
                            <label class="col-sm-3"><input type="checkbox" name="formsix_enable" <?= $app_permission->formsix_enable == 1 ? 'checked' : '' ?> value="1"> Form 6</label>
                            <label class="col-sm-3"><input type="checkbox" name="formsix_edit_enable" <?= $app_permission->formsix_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 6 Edit</label>
                            <label class="col-sm-3"><input type="checkbox" name="formseven_enable" <?= $app_permission->formseven_enable == 1 ? 'checked' : '' ?> value="1"> Form 7</label>
                            <label class="col-sm-3"><input type="checkbox" name="formseven_edit_enable" <?= $app_permission->formseven_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 7 Edit</label>
                            <label class="col-sm-3"><input type="checkbox" name="formeight_enable" <?= $app_permission->formeight_enable == 1 ? 'checked' : '' ?> value="1"> Form 8</label>
                            <label class="col-sm-3"><input type="checkbox" name="formeight_edit_enable" <?= $app_permission->formeight_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 8 Edit</label>
                            <label class="col-sm-3"><input type="checkbox" name="formnine_enable" <?= $app_permission->formnine_enable == 1 ? 'checked' : '' ?> value="1"> Form 9</label>
                            <label class="col-sm-3"><input type="checkbox" name="formnine_edit_enable" <?= $app_permission->formnine_edit_enable == 1 ? 'checked' : '' ?> value="1"> Form 9 Edit</label>
                        </div>
					</div>
				</fieldset>
            


        <fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("Web Permission", "Web Permission"); ?></legend>
					<div class="col-md-12">
						<div class="form-group budget_source_checkbox">
            <div class="table-responsive">

              <table class="table table-bordered table-hover table-striped reports-table">
                  <thead>
                  <tr>
                      <!--<th colspan="6" class="text-center"><?php //echo $group->description . ' ( ' . $group->name . ' ) ' . $page_title; ?></th>-->
                  </tr>
                  <tr>
                      <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                      </th>
                      <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                  </tr>
                  <tr>
                      <th class="text-center"><?= lang("index"); ?></th>
                      <th class="text-center"><?= lang("add"); ?></th>
                      <th class="text-center"><?= lang("edit"); ?></th>
                      <th class="text-center"><?= lang("delete"); ?></th>
                      <th class="text-center"><?= lang("view"); ?></th>
                      <th class="text-center"><?= lang("status"); ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td><?= lang("Form One"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formone-index" <?php echo $p->{'formone-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formone-add_formone" <?php echo $p->{'formone-add_formone'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formone-edit_formone" <?php echo $p->{'formone-edit_formone'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formone-delete" <?php echo $p->{'formone-delete'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formone-view_formone" <?php echo $p->{'formone-view_formone'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formone-formone_status" <?php echo $p->{'formone-formone_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Form Two"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formtwo-index" <?php echo $p->{'formtwo-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formtwo-add_formtwo" <?php echo $p->{'formtwo-add_formtwo'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formtwo-edit_formtwo" <?php echo $p->{'formtwo-edit_formtwo'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formtwo-delete" <?php echo $p->{'formtwo-delete'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formtwo-view_formtwo" <?php echo $p->{'formtwo-view_formtwo'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formtwo-formtwo_status" <?php echo $p->{'formtwo-formtwo_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Form Three"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formthree-index" <?php echo $p->{'formthree-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formthree-add_formthree" <?php echo $p->{'formthree-add_formthree'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formthree-edit_formthree" <?php echo $p->{'formthree-edit_formthree'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formthree-delete" <?php echo $p->{'formthree-delete'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formthree-view_formthree" <?php echo $p->{'formthree-view_formthree'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="formthree-formthree_status" <?php echo $p->{'formthree-formthree_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Farmer"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="farmer-index" <?php echo $p->{'farmer-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="farmer-add_farmer" <?php echo $p->{'farmer-add_farmer'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="farmer-edit_farmer" <?php echo $p->{'farmer-edit_farmer'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="farmer-delete" <?php echo $p->{'farmer-delete'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="farmer-view_farmer" <?php echo $p->{'farmer-view_farmer'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="farmer-farmer_status" <?php echo $p->{'farmer-farmer_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Vendor"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="vendor-index" <?php echo $p->{'vendor-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="vendor-add_vendor" <?php echo $p->{'vendor-add_vendor'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="vendor-edit_vendor" <?php echo $p->{'vendor-edit_vendor'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="vendor-delete" <?php echo $p->{'vendor-delete'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="vendor-view_vendor" <?php echo $p->{'vendor-view_vendor'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="vendor-vendor_status" <?php echo $p->{'vendor-vendor_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Staff"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-index" <?php echo $p->{'staff-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-add_staff" <?php echo $p->{'staff-add_staff'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-edit_staff" <?php echo $p->{'staff-edit_staff'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-delete" <?php echo $p->{'staff-delete'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-view_staff" <?php echo $p->{'staff-view_staff'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-staff_status" <?php echo $p->{'staff-staff_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <!--<tr>
                      <td><?//= lang("Site Configuration"); ?></td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-index" <?php //echo $p->{'system_settings-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td>
                  </tr>
                  <tr>
                      <td><?//= lang("Form Settings"); ?></td>
                      <td class="text-center">
                      <input type="checkbox" value="1" class="checkbox" name="system_settings-form" <?php //echo $p->{'system_settings-form'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-form_settings" <?php //echo $p->{'system_settings-form_settings'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td>
                  </tr>-->
                  <tr>
                      <td><?= lang("Province"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-province" <?php echo $p->{'system_settings-province'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_province" <?php echo $p->{'system_settings-add_province'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_province" <?php echo $p->{'system_settings-edit_province'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_province" <?php echo $p->{'system_settings-delete_province'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-province_status" <?php echo $p->{'system_settings-province_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("District"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-district" <?php echo $p->{'system_settings-district'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_district" <?php echo $p->{'system_settings-add_district'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_district" <?php echo $p->{'system_settings-edit_district'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_district" <?php echo $p->{'system_settings-delete_district'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-district_status" <?php echo $p->{'system_settings-district_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Commune"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-commune" <?php echo $p->{'system_settings-commune'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_commune" <?php echo $p->{'system_settings-add_commune'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_commune" <?php echo $p->{'system_settings-edit_commune'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_commune" <?php echo $p->{'system_settings-delete_commune'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-commune_status" <?php echo $p->{'system_settings-commune_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Village"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-village" <?php echo $p->{'system_settings-village'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_village" <?php echo $p->{'system_settings-add_village'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_village" <?php echo $p->{'system_settings-edit_village'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_village" <?php echo $p->{'system_settings-delete_village'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-village_status" <?php echo $p->{'system_settings-village_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Pets"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-pets" <?php echo $p->{'system_settings-pets'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_pets" <?php echo $p->{'system_settings-add_pets'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_pets" <?php echo $p->{'system_settings-edit_pets'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_pets" <?php echo $p->{'system_settings-delete_pets'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-pets_status" <?php echo $p->{'system_settings-pets_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Pets Type"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-pets_type" <?php echo $p->{'system_settings-pets_type'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_pets_type" <?php echo $p->{'system_settings-add_pets_type'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_pets_type" <?php echo $p->{'system_settings-edit_pets_type'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_pets_type" <?php echo $p->{'system_settings-delete_pets_type'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-pets_type_status" <?php echo $p->{'system_settings-pets_type_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Hygine"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-hygine" <?php echo $p->{'system_settings-hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_hygine" <?php echo $p->{'system_settings-add_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_hygine" <?php echo $p->{'system_settings-edit_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_hygine" <?php echo $p->{'system_settings-delete_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-hygine_status" <?php echo $p->{'system_settings-hygine_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("General Hygine"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-general_hygine" <?php echo $p->{'system_settings-general_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_general_hygine" <?php echo $p->{'system_settings-add_general_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_general_hygine" <?php echo $p->{'system_settings-edit_general_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_general_hygine" <?php echo $p->{'system_settings-delete_general_hygine'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-general_hygine_status" <?php echo $p->{'system_settings-general_hygine_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Source Of Water"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-source_of_water" <?php echo $p->{'system_settings-source_of_water'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_source_of_water" <?php echo $p->{'system_settings-add_source_of_water'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_source_of_water" <?php echo $p->{'system_settings-edit_source_of_water'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_source_of_water" <?php echo $p->{'system_settings-delete_source_of_water'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-source_of_water_status" <?php echo $p->{'system_settings-source_of_water_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Currency"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-currency" <?php echo $p->{'system_settings-currency'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_currency" <?php echo $p->{'system_settings-add_currency'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_currency" <?php echo $p->{'system_settings-edit_currency'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_currency" <?php echo $p->{'system_settings-delete_currency'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-currency_status" <?php echo $p->{'system_settings-currency_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Equipment"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-equipment" <?php echo $p->{'system_settings-equipment'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_equipment" <?php echo $p->{'system_settings-add_equipment'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_equipment" <?php echo $p->{'system_settings-edit_equipment'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_equipment" <?php echo $p->{'system_settings-delete_equipment'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-equipment_status" <?php echo $p->{'system_settings-equipment_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Expanse"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-expanse" <?php echo $p->{'system_settings-expanse'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_expanse" <?php echo $p->{'system_settings-add_expanse'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_expanse" <?php echo $p->{'system_settings-edit_expanse'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_expanse" <?php echo $p->{'system_settings-delete_expanse'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-expanse_status" <?php echo $p->{'system_settings-expanse_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Occupations"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-occupations" <?php echo $p->{'system_settings-occupations'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_occupations" <?php echo $p->{'system_settings-add_occupations'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_occupations" <?php echo $p->{'system_settings-edit_occupations'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_occupations" <?php echo $p->{'system_settings-delete_occupations'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-occupations_status" <?php echo $p->{'system_settings-occupations_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Department"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-department" <?php echo $p->{'system_settings-department'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_department" <?php echo $p->{'system_settings-add_department'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-edit_department" <?php echo $p->{'system_settings-edit_department'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_department" <?php echo $p->{'system_settings-delete_department'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-department_status" <?php echo $p->{'system_settings-department_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Role"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-role" <?php echo $p->{'system_settings-role'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-add_role" <?php echo $p->{'system_settings-add_role'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-delete_role" <?php echo $p->{'system_settings-delete_role'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">&nbsp;</td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="system_settings-role_status" <?php echo $p->{'system_settings-role_status'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  </tbody>
              </table>

              </div>
            </div>
					</div>
				</fieldset>

            
        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('app_permission_staff', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

