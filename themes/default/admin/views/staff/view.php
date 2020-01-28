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
								<label class="label_green" >User Name </label>
								<input type="text" class="form-control" name="username" id="username" value="<?= $result->username ?>" required readonly>
							</div>
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
                        
        </div>
        <div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_staff', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

