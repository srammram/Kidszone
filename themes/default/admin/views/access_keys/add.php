<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("access_keys/add", $attrib);
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
								<label class="label_green" >Access Key</label>
								<input type="text" class="form-control" name="reference_key" id="reference_key" required >
								<input type="button" value="Generate Key" id="genKey">&nbsp;
							</div>						
						</div>
					</div>
				</fieldset>
            
        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('add_access_key', lang('submit'), 'class="btn btn-primary"'); ?></div>
         </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<script>

$( window ).load(function() {
  		var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		var string_length = 10;
		var randomstring = '';
		for (var i=0; i<string_length; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			randomstring += chars.substring(rnum,rnum+1);
		}

		$('#reference_key').val(randomstring);
});

$(document).ready(function() {
	

	
	
	$('#genKey').click(function(){

	//$('form[class="add_from"]').bootstrapValidator('revalidateField', 'reference_key');
	
	$('.add_from')
	.bootstrapValidator('updateStatus', 'reference_key', 'VALIDATING')
	.bootstrapValidator('validateField', 'reference_key');
	
	//$('form[class="add_from"]').bootstrapValidator(options).bootstrapValidator('validate');
	    //$(this).closest('form[class="add_from"]').bootstrapValidator('revalidateField', $(this).prop('reference_key'));


	 //$('.add_from').bootstrapValidator('revalidateField', 'reference_key');
		var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		var string_length = 10;
		var randomstring = '';
		for (var i=0; i<string_length; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			randomstring += chars.substring(rnum,rnum+1);
		}

		$('#reference_key').val(randomstring);

	})
	
$('form[class="add_from"]').bootstrapValidator({
	message: 'This value is not valid',
	 feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		 excluded: ':disabled',
         fields: {
			reference_key: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the access key'
                    },
					/*regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
						message: 'The make can only consist of alphabetical and number'
                    },*/
					/*remote: {
							type: 'POST',
							url: '<?=admin_url('access_keys/get_access_keys')?>',
							message: 'Access key already exists.',
							delay: 1000
	                }*/
                }
            }

        	},
        submitButtons: 'input[type="submit"]'
    })
	
	});
</script>