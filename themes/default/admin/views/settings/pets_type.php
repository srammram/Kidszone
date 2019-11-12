<script>

function active_status(x) {
		//alert(x);
        var y = x.split("__");
		return y[1] == 1 ?
		"<a href='#' class='tip po' title='' data-content=\"<p>Are you Sure</p><a class='btn btn-danger' id='a__$1' href=' <?= admin_url('system_settings/pets_type_status/deactive/') ?>"+ y[0] +" '>Yes I`m Sure</a> <button class='btn po-close'>No</button>\"  rel='popover'><span class=\"label label-success\">"+lang['active']+"</span> </a>"
			:

		"<a href='#' class='tip po' title='' data-content=\"<p>Are you Sure</p><a class='btn btn-danger' id='a__$1' href=' <?= admin_url('system_settings/pets_type_status/active/') ?>"+ y[0] +" '>Yes I`m Sure</a> <button class='btn po-close'>No</button>\"  rel='popover'><span class=\"label label-danger\">"+lang['inactive']+"</span> </a>"
		
        
    }

    $(document).ready(function () {
        oTable = $('#UsrTable').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('system_settings/getPets_type') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            
             'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
				var index = oSettings._iDisplayStart+parseInt(iDisplayIndex) +parseInt(1) ;
                $("td:first", nRow).html(index);
                return nRow;
            },
             "aoColumns": [  null, null, null, null, {"mRender": active_status}, {"bSortable": false}]
        });
    });
</script>
<style>.table td:nth-child(6) {
        text-align: right;
        width: 10%;
    }

    .table td:nth-child(8) {
        text-align: center;
    }</style>
<?php if ($Owner) {
    echo admin_form_open('system_settings/country_actions', 'id="action-form"');
} ?>
<div class="box">
   
   
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <?php if($this->data['menu']->{'system_settings-add_pets_type'}==1 || $this->data['menu']->{'system_settings-add_pets_type'}=="") { ?>
                <a href="<?= admin_url('system_settings/add_pets_type'); ?>" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?= lang("add_pets_type"); ?></button></a>
                <?php } ?>
    

                <div class="table-responsive">
                    <table id="UsrTable" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-xs-2"><?php echo lang('S.No'); ?></th>
                            <th class="col-xs-2"><?php echo lang('code'); ?></th>
                            <th style="width:100px;">Pets Type Name</th>
                            <th style="width:100px;">Pets Name</th>
                            <th style="width:100px;"><?php echo lang('staus'); ?></th>
                            <th class="col-xs-2"><?php echo lang('action'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty"><?= lang('no data') ?></td>
                        </tr>
                        </tbody>
                        
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<?php if ($Owner) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>

   

<?php } ?>