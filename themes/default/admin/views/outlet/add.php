<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("outlet/add_outlet", $attrib);
                ?>
<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
                
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("General information", "General information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green" >Outlet Name </label>
								<input type="text" class="form-control" name="name" id="name" required >
							</div>
							<div class="form-group">
								<label class="label_green">Code</label>
								<input type="text" class="form-control" name="code" id="code" >
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Latitude</label>
								<input type="text" class="form-control" name="lat" id="lat">
							</div>
							<div class="form-group">
								<label class="label_green">Longitude</label>
								<input type="text" class="form-control" name="lng" id="lng">
							</div>
						</div>
					</div>

                    <div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Device IP</label>
								<input type="text" class="form-control" name="device_ip" id="device_ip">
							</div>
						</div>
					</div>
				</fieldset>
            
        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('add_outlet', lang('submit'), 'class="btn btn-primary"'); ?></div>
         </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

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
			 code: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the code'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
						message: 'The make can only consist of alphabetical and number'
                    },
					remote: {
							type: 'POST',
							url: '<?=admin_url('outlet/get_code')?>',
							message: 'Code already exists.',
							delay: 1000
	                }
                }
            },
			
			name: {
                    validators: {
                        notEmpty: {message: 'Please enter the outlet name.'}
                    }
            },

            lat: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the latitude'
                    },
					remote: {
							type: 'POST',
							url: '<?=admin_url('outlet/get_latitude')?>',
							message: 'Latitude code already exists.',
							delay: 1000
	                }
                }
            },

            lng: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the longitude'
                    },
					remote: {
							type: 'POST',
							url: '<?=admin_url('outlet/get_longitude')?>',
							message: 'Longitude code already exists.',
							delay: 1000
	                }
                }
            },

			device_ip: {
				validators: {
                    notEmpty: {
                        message: 'Please enter the device ip'
                    },
				}
			}

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