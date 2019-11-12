<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("staff/edit_staff/".$id, $attrib);
                ?>
        <div class="row">
        	
                
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("General information", "General information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green" >First Name </label>
								<input type="text" class="form-control" name="first_name" id="first_name" value="<?= $result->first_name ?>" required readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Last Name</label>
								<input type="text" class="form-control" name="last_name" id="last_name"  value="<?= $result->last_name ?>" readonly>
							</div>
							
							<div class="form-group">
								<label for="sale_type" class="col-md-12 label_green" style="padding-left: 0px;">Gender</label>		
								<label><input type="radio" name="gender" value="male" <?= $result->gender == 'male' ? 'checked' : '' ?> disabled> Male </label> &nbsp;&nbsp;&nbsp;&nbsp;
								<label><input type="radio" name="gender" value="female" <?= $result->gender == 'female' ? 'checked' : '' ?> disabled> Female</label>
							</div>
						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Email</label>
								<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" required readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Phone Number</label>
								<input type="text" class="form-control"  name="phone"   value="<?= $result->phone ?>" id="phone" required readonly>
							</div>
                            
                            <div class="form-group ">
                                <label class="label_green">Photo</label>
								<div class="clear"></div>			
								<input type="image" src="<?=base_url()?>assets/uploads/thumbs/<?= !empty($result->avatar) ? $result->avatar : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
                            </div>
							
						</div>
					</div>
				</fieldset>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Address</legend>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label_green">Province</label>
                            <?php
							$p[''] = 'Select Province';
							foreach ($province as $value) {
								$p[$value->id] = $value->name;
							}
							echo form_dropdown('province', $p, $address_result->province, 'class="form-control select" disabled  id="province" required="required"'); ?>                        </div>
                       
                        <div class="form-group">
                            <label class="label_green">Commune</label>
                            <?php
							$c[''] = 'Select Commune';
						    foreach ($commune as $value) {
								$c[$value->id] = $value->name;
							}
							echo form_dropdown('commune', $c, $address_result->commune, 'class="form-control select" disabled  id="commune" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label class="label_green">District</label>
                            <?php
							$d[''] = 'Select District';
							
						   foreach ($district as $value) {
								$d[$value->id] = $value->name;
							}
							echo form_dropdown('district', $d, $address_result->district, 'class="form-control select" disabled  id="district" required="required"'); ?>
                        </div>
                    	
                         
                        <div class="form-group">
                            <label class="label_green">Village</label>
                            <?php
							$v[''] = 'Select Village';
						   foreach ($village as $value) {
								$v[$value->id] = $value->name;
							}
							echo form_dropdown('village', $v, $address_result->village, 'class="form-control select" disabled  id="village" required="required"'); ?>
                        </div>
                        <!--<div class="form-group pull-right">
                            <button type="button" class="btn btn-success btn_add_more_s btn-sm">Add more info</button>
                        </div>-->
                    </div>
                    
                </div>
               
            </fieldset>
            
<fieldset class="scheduler-border">
                <legend class="scheduler-border">Role </legend>
                
                <div id="field">
                    <div id="field0">
                    <!--<button type="button" id="addrole" class="btn btn-primary pull-right">Add</button>  -->             
                    <div class="col-md-12 well">
                            
                            <div class="form-group col-md-6">
                                <label class="label_green">Department</label>
                                <?php
                                $dep[''] = 'Select Department';
                                foreach ($department as $value) {
                                    $dep[$value->id] = $value->name;
                                }
                                echo form_dropdown('department_id[]', $dep, $access_result->department_id, 'class="form-control select"   disabled id="department_id"'); ?>                        </div>
                                
                             <div class="form-group col-md-6">
                                <label class="label_green">Role</label>
                                <?php
                                $rol[''] = 'Select Role';
                                foreach ($role as $value) {
                                    $rol[$value->access_location] = $value->position;
                                }
                                echo form_dropdown('role_id[]', $rol, $access_result->role_id, 'class="form-control select" disabled  id="role_id"'); ?>                        
                                </div>
                                
                             <div class="form-group col-md-6 location province" <?php if($access_result->province_id == 0){ ?> style="display:none" <?php } ?>>
                            <label class="label_green">Province</label>
                            <?php
							$p[''] = 'Select Province';
							foreach ($province as $value) {
								$p[$value->id] = $value->name;
							}
							echo form_dropdown('province_id[]', $p, $access_result->province_id, 'class="form-control  select" disabled  id="province_id"'); ?>                        </div>
                            
                         <div class="form-group col-md-6 location district" <?php if($access_result->district_id == 0){ ?> style="display:none" <?php } ?>>
                            <label class="label_green">District</label>
                            <?php
							$d[''] = 'Select District';
						   foreach ($adistrict as $value) {
								$d[$value->id] = $value->name;
							}
							echo form_dropdown('district_id[]', $d, $access_result->district_id, 'class="form-control  select" disabled  id="district_id"'); ?>
                        </div>
                   		
                        <div class="form-group col-md-6 location commune" <?php if($access_result->commune_id == 0){ ?> style="display:none" <?php } ?>>
                            <label class="label_green">Commune </label>
                            <?php
							$c[''] = 'Select Commune';
						    foreach ($acommune as $value) {
								$c[$value->id] = $value->name;
							}
							echo form_dropdown('commune_id[]', $c, $access_result->commune_id, 'class="form-control  select" disabled  id="commune_id"'); ?>
                        </div>
                        
                        <div class="form-group col-md-6 location village" <?php if($access_result->village_id == 0){ ?> style="display:none" <?php } ?>>
                            <label class="label_green">Village </label>
                            <?php
							$v[''] = 'Select Village';
						    foreach ($avillage as $value) {
								$v[$value->id] = $value->name;
							}
							echo form_dropdown('village_id[]', $v, $access_result->village_id, 'class="form-control  select" disabled  id="village_id"'); ?>
                        </div>
                        
                        <div class="form-group col-md-6 location reporter">
                            <label class="label_green">Reporter</label>
                            <?php
							$r[''] = 'Select Reporter';
							//print_r($reporter);
						   	foreach ($reporter as $value) {
								$r[$value->user_id] = $value->first_name;
							}
							echo form_dropdown('reporter_id[]', $r, $access_result->reporter_id, 'class="form-control select" disabled  id="reporter_id"'); ?>
                        </div>
                            
                       
                        
                    </div>
                    </div>
                
                
                </div>
            </fieldset>
                        
        </div>
        <div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_staff', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

