<script>
    
	
	function active_status(x) {
		
        var y = x.split("__");
		return y[1] == 1 ?
		"<a href='#' class='tip po' title='' data-content=\"<p>Are you Sure</p><a class='btn btn-danger' id='a__$1' href=' <?= admin_url('age/age_status/deactive/') ?>"+ y[0] +" '>Yes I`m Sure</a> <button class='btn po-close'>No</button>\"  rel='popover'><span class=\"label label-success\">"+lang['active']+"</span> </a>"
			:

		"<a href='#' class='tip po' title='' data-content=\"<p>Are you Sure</p><a class='btn btn-danger' id='a__$1' href=' <?= admin_url('age/age_status/active/') ?>"+ y[0] +" '>Yes I`m Sure</a> <button class='btn po-close'>No</button>\"  rel='popover'><span class=\"label label-danger\">"+lang['inactive']+"</span> </a>"
		
        
    }
	
	
	
	function mobile_status(mob) {
		
		//var mobile = mob.slice(-4);		
		//return '******'+mobile;
        var mobile = mob;	
        return mobile;
    }
	
    $(document).ready(function () {
        'use strict';
        oTable = $('#UsrTable').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('age/getAge?sdate='.$_GET['sdate'].'&edate='.$_GET['edate']) ?>',
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
             "aoColumns": [ null, null, null, {"mRender": active_status},  {"bSortable": true}]

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
    echo admin_form_open('incentive/incentive_actions', 'id="action-form"');
} ?>



<div class="box">
   
   
    <div class="box-content">
    
        <div class="row">
            <div class="col-lg-12">
                
                <?php /*?><div class="col-lg-3">
					<div class="form-group">
						<?php echo lang('Start Date', 'Start Date'); ?>
						<div class="controls">
							<input type="text" id="start_date" name="start_date" class="form-control" onkeypress="dateCheck(this);" value="<?= $_GET['sdate'] ?>"/>
						</div>
					 </div>
				</div>
				<div class="col-lg-3">        
					<div class="form-group">
						<?php echo lang('End Date', 'End Date'); ?>
						<div class="controls">
							<input type="text" id="end_date" name="end_date" class="form-control" onkeypress="dateCheck(this);"  value="<?= $_GET['edate'] ?>"/>
						</div>
					</div>
				</div>
				<div class="col-lg-3 row">
					<div class="form-group col-lg-7">
						<?php echo lang('&nbsp;'); ?><br>
					   <a href="javascript:void(0)" id="filte_ride" class="btn btn-primary btn-block">SEARCH</a>
					</div>

					<div class="form-group col-lg-5">            	
						<?php echo lang('&nbsp;'); ?><br>
						 <?php
						$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
						?>
					   <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0]; ?>" id="resetfilter"  class="btn btn-primary btn-block">RESET</a>
					</div>            
				</div><?php */?>
            <div class="clearfix"></div>
            
          
            
            <div class="clearfix"></div>
			
            	<a href="<?= admin_url('age/add_age'); ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?= lang("add_age"); ?></button></a>
                
                <div class="table-responsive">
                    <table id="UsrTable" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        	<th class="col-xs-2"><?php echo lang('S.No'); ?></th>
                            <th class="col-xs-2"><?php echo lang('name'); ?></th>
                            <th class="col-xs-2"><?php echo lang('khmer name'); ?></th>
                            <th style="width:100px;"><?php echo lang('status'); ?></th>
                            <th style="width:80px;"><?php echo lang('actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
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

    <script language="javascript">
        $(document).ready(function () {
            $('#set_admin').click(function () {
                $('#usr-form-btn').trigger('click');
            });

        });
    </script>

<?php } ?>

<script>
$(document).ready(function(){
	var m_new = new Date();
	var month_new = m_new.getMonth() - <?= $due_month ?>;
	m_new.setMonth(month_new);
	
	var yearRangeMin =  '-<?= $due_year ?>:+0';
	var yearRangeMax =  '-0:+<?= $due_year ?>';
	
	function getDate(element) {
     var date;
     try {
       date = element.value;
     } catch (error) {
       date = null;
     }

     return date;
   }

	var dateFormat =  "dd/mm/yy";
		
	var start_date = $("#start_date") .datepicker({
       defaultDate: "+1w",
	   
	   dateFormat: "dd/mm/yy" ,
		changeMonth: true,
		changeYear: true,
		
		maxDate: 0,
		numberOfMonths: 1,
		yearRange: '-100:+0',
		
	})
	.on("change", function() {
		end_date.datepicker("option", "minDate", getDate(this));
	});
	
	var end_date = $("#end_date") .datepicker({
       defaultDate: "+1w",
	   
	   dateFormat: "dd/mm/yy" ,
		changeMonth: true,
		changeYear: true,
		
		maxDate: 0,
		numberOfMonths: 1
	})
	.on("change", function() {
		start_date.datepicker("option", "maxDate", getDate(this));
	});
	
	$('#filte_ride').click(function(e) {
        var site = '<?php echo site_url() ?>';
		var sdate = $('#start_date').val();
		var edate = $('#end_date').val();
		var is_country = $('#is_country').val();
		
		window.location.href = site+"admin/incentive/index?sdate="+sdate+"&edate="+edate+"&is_country="+is_country;
		
    });

});

</script>
<script>
//var date = document.getElementById('start_date');



</script>