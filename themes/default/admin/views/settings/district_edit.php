

<script>
$('form[class="edit_from"]').bootstrapValidator({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please Enter the Name'
                    },
                    remote: {
							type: 'POST',
							url: '<?=admin_url('system_settings/check_duplicate_district')?>',
                            data: function(validator) {
                            return {
                                id: validator.getFieldElements('id').val(),
                                province_id: validator.getFieldElements('province_id').val()
                                };
                            },
							message: 'District name already exists.',
							delay: 1000
	                }
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
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_district'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator','class' => 'edit_from', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/edit_district/".$id, $attrib); ?>
        <div class="modal-body">
            <h2 class="box_he_de"><?= lang('enter_info'); ?></h2>
            
                        
            <div class="col-md-12">
           
            <?php echo form_hidden('id', $result->id, 'class="form-control" id="id"'); ?>
            
            
            <div class="form-group  col-md-12 col-xs-12">
                <?= lang('code', 'code'); ?>
                <?php echo form_input('code', $result->code, 'class="form-control" readonly id="code" required="required"'); ?>
            </div>

            <div class="form-group col-md-12 col-xs-12">
            Province Name*
				<?php
                $c[''] = 'Select Province';
                foreach ($parent as $value) {
                    $c[$value->id] = $value->name;
                }
                echo form_dropdown('province_id', $c, $result->province_id, 'class="form-control select"  id="province_id" required="required"'); ?>
            </div>
            
            <div class="form-group col-md-12 col-xs-12">
            District Name*
                <?php echo form_input('name', $result->name, 'class="form-control" id="name" onkeyup="inputFirstUpper(this)" required="required"'); ?>
            </div>
            
            
           
            </div>
            
            <div style="clear: both;height: 10px;"></div>
            
            

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_district', lang('submit'), 'class="btn btn-primary change_btn_save center-block"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= @$modal_js ?>


<script>
$('#province_id').change(function(){
	$('#name').val('');
    $('.edit_from').bootstrapValidator('revalidateField', 'name');
});
</script>