<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
                ?>
        <div class="row">
        	
                
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("General information", "General information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green" >First Name </label>
								<input type="text" class="form-control" name="first_name" id="first_name" value="<?= $result->first_name ?>" required  readonly>
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
					<legend class="scheduler-border">  <?= lang("Family Details", "Family Details"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Houseband Occupation</label>
								<?php
									$o[''] = 'Select Occupation';
									foreach ($occupations as $value) {
										$o[$value->id] = $value->name;
									}
									echo form_dropdown('occupation', $o, $result->occupation, 'class="form-control select"  readonly id="occupation" required="required"'); 
								?> 
							</div>
                            <div class="form-group">
                                    <label class="label_green">Houseband Identification Number</label>
                                    <input type="text" class="form-control" value="<?= $result->identification_number ?>" name="identification_number" id="identification_number" readonly>
                            </div>
						
                            
                            <div class="form-group">
								<label class="col-sm-12 label_green" style="padding-left: 0px; ">Member of Family</label>
								<div class="col-sm-4 form-group">
									<label class="col-sm-12">Adult</label>
									<?php /*?><select class="form-control" name="no_of_adult" id="no_of_adult">
                                    	<?php for($i=0; $i<=10; $i++){ ?>
										<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php } ?>
									</select><?php */?>
									<div class="number_se">
										<span class="minus">-</span>
										<input type="text" value="<?= $result->no_of_adult ?>" name="no_of_adult" id="no_of_adult" readonly />
										<span class="plus">+</span>
									</div>
								</div>
								<div class="col-sm-4 form-group">
									<label class="col-sm-12 label_green">Child<small style="font-size: 8px;">(under 6 Yrs )</small></label>
									<?php /*?><select class="form-control" name="no_of_children" id="no_of_children">
										<?php for($i=0; $i<=10; $i++){ ?>
										<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php } ?>

									</select><?php */?>
									<div class="number_se">
										<span class="minus">-</span>
										<input type="text" value="<?= $result->no_of_children ?>" name="no_of_children" id="no_of_children" readonly />
										<span class="plus">+</span>
									</div>
								</div>
								<div class="col-sm-4 form-group">
									<label class="col-sm-12 label_green">Total</label>
									<input type="text" class="form-control" name="total_family_members" id="total_family_members" readonly value="<?= $result->total_family_members ?>" >
								</div>
							</div>
						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Wife Occupation</label>
								<?php
									$o[''] = 'Select Occupation';
									foreach ($occupations as $value) {
										$o[$value->id] = $value->name;
									}
									echo form_dropdown('wife_occupation', $o, $result->wife_occupation, 'class="form-control select"  readonly id="wife_occupation" required="required"'); 
								?> 
							</div>
							<div class="form-group">
								<label class="label_green">Wife Name</label>
								<input type="text" class="form-control" name="wife_name" value="<?= $result->wife_name ?>" readonly id="wife_name">
							</div>
                            <div class="form-group">
								<label class="label_green">Wife Identification Number</label>
								<input type="text" class="form-control" name="wife_identification_number" readonly value="<?= $result->wife_identification_number ?>" id="wife_identification_number">
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
							echo form_dropdown('province', $p, $address_result->province, 'class="form-control select"  disabled id="province" required="required"'); ?>                        </div>
                       
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
							echo form_dropdown('district', $d, $address_result->district, 'class="form-control select" disabled id="district" required="required"'); ?>
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
            
            
        </div>
        <div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

