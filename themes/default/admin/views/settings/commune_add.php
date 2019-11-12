
<script>
$('form[class="add_from"]').bootstrapValidator({
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
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_commune'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'class' => 'add_from', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/add_commune", $attrib); ?>
        <div class="modal-body">
            <h2 class="box_he_de"><?= lang('enter_info'); ?></h2>
          
            
            <div class="col-md-12">
                <div class="form-group col-md-12 col-xs-12">
                <?php $code = $this->site->commoncode('C', 'commune'); ?>
                <?= lang('code', 'code'); ?>
                <?php echo form_input('code', $code, 'class="form-control" readonly id="code" required="required"'); ?>
            </div>
             <div class="form-group col-md-12 col-xs-12">
                Province Name*
				<?php
                $p[''] = 'Select Province';
                foreach ($parent as $value) {
                    $p[$value->id] = $value->name;
                }
                echo form_dropdown('province_id', $p, '', 'class="form-control select"  id="province_id" required="required"'); ?>
            </div>
            <div class="form-group col-md-12 col-xs-12">
                District Name*
				<?php
                $c[''] = 'Select District';
               
                echo form_dropdown('district_id', $c, '', 'class="form-control select"  id="district_id" required="required"'); ?>
            </div>
            
            
            <div class="form-group col-md-12 col-xs-12">
               Commune Name*
                <?php echo form_input('name', '', 'class="form-control" id="name" onkeyup="inputFirstUpper(this)" required="required"'); ?>
            </div>
            
           
            </div>
            
            <div style="clear: both;height: 10px;"></div>
            
            

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_commune', lang('submit'), 'class="btn btn-primary change_btn_save center-block"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= @$modal_js ?>
<script>
$('#province_id').change(function(){
	
	var id = $(this).val();
	$.ajax({
		type: 'POST',
		url: '<?=admin_url('system_settings/getdistrict_byprovince')?>',
		data: {province_id: id},
		dataType: "json",
		cache: false,
		success: function (scdata) {
			console.log(scdata);
			$option = '<option value="">Select District</option>';
			$.each(scdata,function(n,v){
				$option += '<option value="'+v.id+'">'+v.text+'</option>';
			});
			$("#district_id").html($option);
			
		}
	})
});
</script>