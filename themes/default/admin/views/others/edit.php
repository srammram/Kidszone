<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off"); echo admin_form_open_multipart("others/edit_others/".$id, $attrib); ?>

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
								<label class="label_green" >Others Name </label>
								<input type="text" class="form-control" name="name" id="name"  value="<?= $result->name ?>" required >
							</div>	
						</div>
					</div>
				</fieldset>

        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('edit_others', lang('submit'), 'class="btn btn-primary"'); ?></div>
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
			name: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the name'
                    },
					regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
						message: 'The make can only consist of alphabetical and number'
                    },
					remote: {
							type: 'POST',
							url: '<?=admin_url('others/get_name')?>',
							data: { id: <?php echo $result->id; ?> },
							message: 'Name already exists.',
							delay: 1000
	                }
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