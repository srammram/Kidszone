<script>
$('form[class="add_from"]').bootstrapValidator({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the name'
                    },
                    remote: {
							type: 'POST',
							url: '<?=admin_url('system_settings/check_duplicate_value/age/name/'.$id)?>',
							message: 'Name already exists.',
							delay: 1000
	                }
                }
            }
            
        },
        submitButtons: 'input[type="submit"]'
    });
    </script>





<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_age'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'class' => 'add_from', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/add_age", $attrib); ?>
        <div class="modal-body">
            <h2 class="box_he_de"> <?= lang('enter_info'); ?></h2>
            
            <div class="col-md-6">

            <div class="form-group">
                Name*
                
                <?php echo form_input('name', '', 'class="form-control" id="name" xonkeyup="inputFirstUpper(this)" required="required"'); ?>
            </div>
            </div>
            
            <div style="clear: both;height: 10px;"></div>
            
            

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_age', lang('submit'), 'class="btn btn-primary change_btn_save center-block"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= @$modal_js ?>