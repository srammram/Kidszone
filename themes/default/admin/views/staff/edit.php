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
					<legend class="scheduler-border">  <?= lang("Change Password", "Change Password"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">

							<div class="form-group">
								<label class="label_green">Username</label>
								<input type="text" class="form-control" name="username" id="username" value="<?= $result->username ?>" required>
							</div>

							<div class="form-group">
								<label class="label_green">Password</label>
								<input type="text" class="form-control" name="password" id="password" >
							</div>
							<div class="form-group">
								<label class="label_green">Confirm Password</label>
								<input type="text" class="form-control" name="confirm_password" id="confirm_password" >
							</div>

						</div>
						
					</div>
				</fieldset>
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("General information", "General information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green" >First Name </label>
								<input type="text" class="form-control" name="first_name" id="first_name" value="<?= $result->first_name ?>" required>
							</div>
							<div class="form-group">
								<label class="label_green">Last Name</label>
								<input type="text" class="form-control" name="last_name" id="last_name" value="<?= $result->last_name ?>" >
							</div>
							
							<div class="form-group">
								<label for="sale_type" class="col-md-12 label_green" style="padding-left: 0px;">Gender</label>		
								<label><input type="radio" name="gender" value="male" <?= $result->gender == 'male' ? 'checked' : '' ?>> Male </label> &nbsp;&nbsp;&nbsp;&nbsp;
								<label><input type="radio" name="gender" value="female" <?= $result->gender == 'female' ? 'checked' : '' ?>> Female</label>
							</div>
						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Email</label>
								<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" >
							</div>
							<div class="form-group">
								<label class="label_green">Phone Number</label>
								<input type="text" class="form-control"  name="phone"   value="<?= $result->phone ?>" id="phone">
							</div>
                            
                            <div class="form-group ">
                                <label class="label_green">Photo</label>
                                <input id="avatar" type="file" data-browse-label="<?= lang('browse'); ?>" name="avatar" data-show-upload="false"
                                           data-show-preview="false" class="form-control files" accept="im/*">
                            </div>
							<div xclass="text-center"><img src="<?=base_url()?>assets/uploads/thumbs/<?= $result->avatar ?>" alt="" style="width:100px; height:100px;" /></div>
						</div>
					</div>
				</fieldset>

        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('edit_staff', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
$('form[class="add_from"]').bootstrapValidator({
	message: 'This value is not valid',
	 feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		 excluded: ':disabled',
         fields: {
			username: {
                 validators: {
                    notEmpty: {
                        message: 'Please Enter the username'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
						message: 'The make can only consist of alphabetical and number'
                    },
					remote: {
							type: 'POST',
							url: '<?=admin_url('staff/get_username')?>',
							data: { id: <?php echo $result->id; ?> },
							message: 'Username already exists.',
							delay: 1000
	                }
                }
            },
			password: {
                    validators: {
                        //notEmpty: {message: 'Enter password.'},
                    	callback: {
                        message: 'The password is not valid.',
                        callback: function(value, validator, $field) {
                            if (value === '') {
                                return true;
                            }
                            return true;
                        	}
                    	},
						/*identical: {
							field: 'confirm_password',
							message: 'The password and its confirm password are not the same.'
						}*/
                    }
            },
			confirm_password:{
					validators:{
						//notEmpty:{ message: 'Enter confirm password.'},
                    	callback: {
                        message: 'The password is not valid.',
                        callback: function(value, validator, $field) {
                            if (value === '') {
                                return true;
                            }
                            return true;
                        	}
                    	},
						identical: {
							field: 'password',
							message: 'The password and its confirm password are not the same.'
						}
					}
			},
            first_name: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the first name'
                    },
                }
            },
			phone: {
               validators: {
                    notEmpty: {
                        message: 'Please enter mobile number'
                    },
				   stringLength: {
					   	min:8,
                        max: 15,
                        message: 'Please put 15 digit mobile number'
                    },
					regexp: {
                        //regexp: /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)([0|\+[0-9]{1,5})?([1-9][0-9]{9})$/,
						regexp: /^[0-9 ]+$/,
                        message: 'The Mobile number can only consist of number'
                    }
                }
            },
			avatar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpg,image/jpeg,image/png',
                        message: 'The selected file is not valid'
                    }
                }
            }, 

        	},
        submitButtons: 'input[type="submit"]'
    }).find('input[name="need_loan"]')
            // Init iCheck elements
            .iCheck({
                radioClass: 'iradio_square-blue'
            })
            // Called when the radios/checkboxes are changed
            .on('ifChanged', function(e) {
                // Get the field name
                var field = $(this).attr('name');
                $('.add_from').bootstrapValidator('revalidateField', field);
            });
	
	});
</script>