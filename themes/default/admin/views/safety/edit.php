<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("safety/safety_edit/".$id, $attrib);
                ?>
        <div class="row">
        	
		<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("safety information", "Safety information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green" >Title</label>
								<input type="text" class="form-control" name="title" id="title" value="<?= $result->title ?>">
							</div>
							<div class="form-group">
								<label class="label_green">Description</label>
								<textarea rows="5" style="width: 100%;" name="desc_msg" id="desc_msg"><?= $result->desc_msg ?></textarea>
							</div>
						</div>
					</div>
			</fieldset>
            
        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('safety_edit', lang('submit'), 'class="btn btn-primary"'); ?></div>
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
			 title: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the title'
                    }
                }
            },
            /*desc_msg: {
                 validators: {
                    notEmpty: {
                        message: 'Please enter the description'
                    },
                }
            }*/

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