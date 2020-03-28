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
                      <th colspan="10" class="text-center"><?= lang("permissions"); ?></th>
                  </tr>
                  <tr>
                      <th class="text-center"><?= lang("index"); ?></th>
                      <th class="text-center"><?= lang("add"); ?></th>
                      <th class="text-center"><?= lang("edit"); ?></th>
                      <th class="text-center"><?= lang("delete"); ?></th>
                      <th class="text-center"><?= lang("view"); ?></th>
                      <th class="text-center"><?= lang("view_pdf"); ?></th>
                      <th class="text-center"><?= lang("status"); ?></th>
                      <th class="text-center"><?= lang("web_permission"); ?></th>
                      <th class="text-center"><?= lang("index_excel"); ?></th>
                      <th class="text-center"><?= lang("index_pdf"); ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td><?= lang("Register"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="register-index" <?php echo $p->{'register-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="register-view_register" <?php echo $p->{'register-view_register'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="register-pdf_view_register" <?php echo $p->{'register-pdf_view_register'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="register-index_excel" <?php echo $p->{'register-index_excel'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="register-index_pdf" <?php echo $p->{'register-index_pdf'} ? "checked" : ''; ?>>
                      </td>
                  </tr>
                  <tr>
                      <td><?= lang("Safety"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="safety-index" <?php echo $p->{'safety-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="safety-safety_edit" <?php echo $p->{'safety-safety_edit'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
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
                      <td class="text-center"></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-staff_status" <?php echo $p->{'staff-staff_status'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="staff-app_permission_staff" <?php echo $p->{'staff-app_permission_staff'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                  </tr>

                  <tr>
                      <td><?= lang("Outlet"); ?></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="outlet-index" <?php echo $p->{'outlet-index'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="outlet-add_outlet" <?php echo $p->{'outlet-add_outlet'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="outlet-edit_outlet" <?php echo $p->{'outlet-edit_outlet'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="outlet-delete" <?php echo $p->{'outlet-delete'} ? "checked" : ''; ?>>
                      </td>                      
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="outlet-view_outlet" <?php echo $p->{'outlet-view_outlet'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center">
                          <input type="checkbox" value="1" class="checkbox" name="outlet-outlet_status" <?php echo $p->{'outlet-outlet_status'} ? "checked" : ''; ?>>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
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

