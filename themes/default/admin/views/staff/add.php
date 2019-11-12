<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("staff/add_staff", $attrib);
                ?>
        <div class="row">
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("Login information", "Login information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
                        	<?php $refer_code = $this->site->refercode('SS'); ?>
							<div class="form-group">
								<label class="label_green" >Username</label>
								<input type="text" class="form-control" name="username" id="username" value="" >
							</div>
							<div class="form-group">
								<label class="label_green">Password</label>
								<input type="text" class="form-control" name="password" id="password" required >
							</div>
							<div class="form-group">
								<label class="label_green">Confirm Password</label>
								<input type="text" class="form-control" name="confirm_password" id="confirm_password" required >
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
								<input type="text" class="form-control" name="first_name" id="first_name" required >
							</div>
							<div class="form-group">
								<label class="label_green">Last Name</label>
								<input type="text" class="form-control" name="last_name" id="last_name" >
							</div>
							
							<div class="form-group">
								<label for="sale_type" class="col-md-12 label_green" style="padding-left: 0px;">Gender</label>		
								<label><input type="radio" name="gender" value="male" checked> Male </label> &nbsp;&nbsp;&nbsp;&nbsp;
								<label><input type="radio" name="gender" value="female"> Female</label>
							</div>
						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Email</label>
								<input type="text" class="form-control" name="email" id="email">
							</div>
							<div class="form-group">
								<label class="label_green">Phone Number</label>
								<input type="text" class="form-control" name="phone" id="phone">
							</div>
                            
                            <div class="form-group ">
                                <label class="label_green">Photo</label>
                                <input id="avatar" type="file" data-browse-label="<?= lang('browse'); ?>" name="avatar" data-show-upload="false"
                                           data-show-preview="false" class="form-control files" accept="im/*">
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
							echo form_dropdown('province', $p, '', 'class="form-control select"  id="province" required="required"'); ?>                        </div>
                       
                        <div class="form-group">
                            <label class="label_green">Commune</label>
                            <?php
							$c[''] = 'Select Commune';
						   
							echo form_dropdown('commune', $c, '', 'class="form-control select"  id="commune" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                    	
                         <div class="form-group">
                            <label class="label_green">District</label>
                            <?php
							$d[''] = 'Select District';
						   
							echo form_dropdown('district', $d, '', 'class="form-control select"  id="district" required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <label class="label_green">Village</label>
                            <?php
							$v[''] = 'Select Village';
						   
							echo form_dropdown('village', $v, '', 'class="form-control select"  id="village" required="required"'); ?>
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
                                echo form_dropdown('department_id[]', $dep, '', 'class="form-control select"  id="department_id"'); ?>                        </div>
                                
                             <div class="form-group col-md-6">
                                <label class="label_green">Role</label>
                                <?php
                                $rol[''] = 'Select Role';
                                foreach ($role as $value) {
                                    $rol[$value->access_location] = $value->position;
                                }
                                echo form_dropdown('role_id[]', $rol, '', 'class="form-control select"  id="role_id"'); ?>                        
                                </div>
                                
                            <div class="form-group col-md-6 location province">
                                <label class="label_green">Province</label>
                                <?php
                                $p[''] = 'Select Province';
                                foreach ($province as $value) {
                                    $p[$value->id] = $value->name;
                                }
                                echo form_dropdown('province_id[]', $p, '', 'class="form-control  select"  id="province_id"'); ?>                        </div>
                                
                             <div class="form-group col-md-6 location district">
                                <label class="label_green">District</label>
                                <?php
                                $d[''] = 'Select District';
                               
                                echo form_dropdown('district_id[]', $d, '', 'class="form-control  select"  id="district_id"'); ?>
                            </div>
                            
                            <div class="form-group col-md-6 location commune">
                                <label class="label_green">Commune</label>
                                <?php
                                $c[''] = 'Select Commune';
                               
                                echo form_dropdown('commune_id[]', $c, '', 'class="form-control  select"  id="commune_id"'); ?>
                            </div>
                            
                            <div class="form-group col-md-6 location village">
                                <label class="label_green">Village</label>
                                <?php
                                $v[''] = 'Select Village';
                               
                                echo form_dropdown('village_id[]', $v, '', 'class="form-control  select"  id="village_id"'); ?>
                            </div>
                            
                            <div class="form-group col-md-6 location reporter">
                                <label class="label_green">Reporter</label>
                                <?php
                                $r[''] = 'Select Reporter';
                               
                                echo form_dropdown('reporter_id[]', $r, '', 'class="form-control select"  id="reporter_id"'); ?>
                            </div>
                            
                       
                        
                    </div>
                    </div>
                
                
                </div>
            </fieldset>
            
        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('add_staff', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	$('.location').hide();
	$('#role_id').change(function(){
		
		var role_id = $(this).val();
		if(role_id == ''){
			$("#role_id").select2("val", "");
			bootbox.alert('please check role');
       		return;
		}
		
		
				if(role_id == 'Province'){
					$('.location').hide();
					$('.province').show();
					$('.reporter').show();
				}else if(role_id == 'District'){
					
					$('.location').hide();
					$('.province').show();
					$('.district').show();
					$('.reporter').show();
				}else if(role_id == 'Commune'){
					$('.location').hide();
					$('.province').show();
					$('.district').show();
					$('.commune').show();
					$('.reporter').show();
				}else if(role_id == 'Village'){
					$('.location').hide();
					$('.province').show();
					$('.district').show();
					$('.commune').show();
					$('.village').show();
					$('.reporter').show();		
				}else{
					$('.location').hide();
				}
			
		
	});
	
	$('#province_id').change(function(){
		
		
		var id = $(this).val();
		var department_id = $('#department_id').val();
		var role_id = $('#role_id').val();
		
		$.ajax({
			type: 'POST',
			url: '<?=admin_url('staff/getdistrict_byprovince_rep')?>',
			data: {province_id: id, department_id:department_id, role_id:role_id},
			dataType: "json",
			cache: false,
			success: function (scdata) {
				console.log(scdata);
				
				$rep = '<option value="">Select Reporter</option>';
				$.each(scdata.rep,function(n,v){
					$rep += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				$loc = '<option value="">Select District</option>';
				$.each(scdata.loc,function(n,v){
					$loc += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				
				$("#district_id").html($loc);
				$("#reporter_id").html($rep);
				
			}
		})
	});
	
	$('#district_id').change(function(){
		
		
		var id = $(this).val();
		var department_id = $('#department_id').val();
		var role_id = $('#role_id').val();
		
		$.ajax({
			type: 'POST',
			url: '<?=admin_url('staff/getcommune_bydistrict_rep')?>',
			data: {district_id: id, department_id:department_id, role_id:role_id},
			dataType: "json",
			cache: false,
			success: function (scdata) {
				console.log(scdata);
				
				$rep = '<option value="">Select Reporter</option>';
				$.each(scdata.rep,function(n,v){
					$rep += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				$loc = '<option value="">Select Commune</option>';
				$.each(scdata.loc,function(n,v){
					$loc += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				
				$("#commune_id").html($loc);
				$("#reporter_id").html($rep);
				
			}
		})
	});
	
	$('#commune_id').change(function(){
		
		
		var id = $(this).val();
		var department_id = $('#department_id').val();
		var role_id = $('#role_id').val();
		
		$.ajax({
			type: 'POST',
			url: '<?=admin_url('staff/getvillage_bycommune_rep')?>',
			data: {commune_id: id, department_id:department_id, role_id:role_id},
			dataType: "json",
			cache: false,
			success: function (scdata) {
				console.log(scdata);
				
				$rep = '<option value="">Select Reporter</option>';
				$.each(scdata.rep,function(n,v){
					$rep += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				$loc = '<option value="">Select Village</option>';
				$.each(scdata.loc,function(n,v){
					$loc += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				
				$("#village_id").html($loc);
				$("#reporter_id").html($rep);
				
			}
		})
	});
	
	$('#village_id').change(function(){
		
		
		var id = $(this).val();
		var department_id = $('#department_id').val();
		var role_id = $('#role_id').val();
		
		$.ajax({
			type: 'POST',
			url: '<?=admin_url('staff/getreport_byvillage')?>',
			data: {village_id: id, department_id:department_id, role_id:role_id},
			dataType: "json",
			cache: false,
			success: function (scdata) {
				console.log(scdata);
				
				$rep = '<option value="">Select Reporter</option>';
				$.each(scdata.rep,function(n,v){
					$rep += '<option value="'+v.id+'">'+v.text+'</option>';
				});
				
				
				$("#reporter_id").html($rep);
				
			}
		})
	});
	
	
	
	
});

var next = 0;

$(document).on('click', '#addrole', function(){
	
     var addto = "#field" + next;
     var addRemove = "#field" + (next);
     next = next + 1;
	 var newIn = '<div id="field'+ next +'" name="field'+ next +'"><div class="col-md-12 well"><div class="form-group col-md-6"> <label class="label_green">Department</label><select name="department_id[]" class="form-control select"  id="department_id'+ next +'"><option value="">Select Department</option><?php foreach ($department as $value) { ?> <option value="<?= $value->id ?>"><?= $value->name ?></option><?php } ?></select></div><div class="form-group col-md-6"> <label class="label_green">Role</label><select name="role_id[]" class="form-control select"  id="role_id'+ next +'"><option value="">Select Role</option><?php foreach ($role as $value) { ?> <option value="<?= $value->id ?>"><?= $value->position ?></option><?php } ?></select></div>';
	 
	 var newInput = $(newIn);
	 var removeBtn = '<button type="button" id="remove' + (next) + '" class="btn btn-primary pull-right deleterole">Delete</button></div></div><div id="field">';
	 var removeButton = $(removeBtn);
	 
	$(addto).after(newInput);
	$(addRemove).after(removeButton);
	
	$("#field" + next).attr('data-source',$(addto).attr('data-source'));
	$("#count").val(next);  
	$('.deleterole').click(function(){
		
		var fieldNum = this.id.charAt(this.id.length-1);
		var fieldID = "#field" + fieldNum;
		$(this).remove();
		$(fieldID).remove();
	});
});
</script>
<script>
$('#province').change(function(){
	
	var id = $(this).val();
	$.ajax({
		type: 'POST',
		url: '<?=admin_url('system_settings/getdistrict_byprovince')?>',
		data: {province_id: id},
		dataType: "json",
		cache: false,
		success: function (scdata) {
			console.log(scdata);
			$option = '<option value="">Select district</option>';
			$.each(scdata,function(n,v){
				$option += '<option value="'+v.id+'">'+v.text+'</option>';
			});
			$("#district").html($option);
			
		}
	})
});

$('#district').change(function(){
	
	var id = $(this).val();
	$.ajax({
		type: 'POST',
		url: '<?=admin_url('system_settings/getcommune_bydistrict')?>',
		data: {district_id: id},
		dataType: "json",
		cache: false,
		success: function (scdata) {
			console.log(scdata);
			$option = '<option value="">Select Commune</option>';
			$.each(scdata,function(n,v){
				$option += '<option value="'+v.id+'">'+v.text+'</option>';
			});
			$("#commune").html($option);
			
		}
	})
});

$('#commune').change(function(){
	
	var id = $(this).val();
	$.ajax({
		type: 'POST',
		url: '<?=admin_url('system_settings/getvillage_bycommune')?>',
		data: {commune_id: id},
		dataType: "json",
		cache: false,
		success: function (scdata) {
			console.log(scdata);
			$option = '<option value="">Select Village</option>';
			$.each(scdata,function(n,v){
				$option += '<option value="'+v.id+'">'+v.text+'</option>';
			});
			$("#village").html($option);
			
		}
	})
});
</script>

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
							message: 'Username already exists.',
							delay: 1000
	                }
                }
            },
			
			password: {
                    validators: {
                        notEmpty: {message: 'Enter password.'},
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
						notEmpty:{ message: 'Enter confirm password.'},
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
            identification_number: {
                validators: {
                    /*notEmpty: {
                        message: 'Please enter identification number',
                    },*/
					stringLength: {
                        max: 20,
                        message: 'Identification nbumber should support 20 characters '
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_ \s]+$/,
						message: 'The make can only consist of alphabetical, number, space and underscore'
                    },
					remote: {
							type: 'POST',
							url: '<?=admin_url('formone/get_identification_number')?>',
							message: 'Identification number already exists.',
							delay: 1000
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
<script>
$(document).ready(function() {
   $('#phone').attr('maxlength', 15);
});
</script>
