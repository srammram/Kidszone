

<script>
$('form[class="edit_from"]').bootstrapValidator({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please Enter the Name'
                    },
                    
                }
            },
            
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
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_role'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator','class' => 'edit_from', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/edit_role/".$id, $attrib); ?>
        <div class="modal-body">
           <h2 class="box_he_de"> <?= lang('enter_info'); ?></h2>
              
            <div class="col-md-6">
            <div class="form-group">
                <?= lang('code', 'code'); ?>
                <?php echo form_input('code', $result->code, 'class="form-control" readonly id="code" onkeyup="inputUpper(this)" required="required"'); ?>
            </div>
            <div class="form-group">
                Position*
                <?php echo form_input('position', $result->position, 'class="form-control" id="position" onkeyup="inputFirstUpper(this)" required="required"'); ?>
            </div>
            <div class="form-group">
                Access Location*
				<?php
                $c[''] = 'Select Access';
				$c['Province'] = 'Province';
				$c['District'] = 'District';
				$c['Commune'] = 'Commune';
				$c['Village'] = 'Village';
                
                echo form_dropdown('access_location', $c, $result->access_location, 'class="form-control select"  id="access_location" required="required"'); ?>
            </div>
            </div>
            
            <div style="clear: both;height: 10px;"></div>
            
            

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_role', lang('submit'), 'class="btn btn-primary change_btn_save center-block"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= @$modal_js ?>