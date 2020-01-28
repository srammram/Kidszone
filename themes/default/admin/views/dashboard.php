<?php
//echo '<pre>';
//print_r($this->data);
?>
<style>
.form_das.clr-block-1 {
    background:#337AB7;
    margin-right: 0.8em;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    transition: 0.5s all;
    -webkit-transition: 0.5s all;
    -moz-transition: 0.5s all;
    -o-transition: 0.5s all;
}
.form_das {
    padding: 15px;
    background: #999;
}
	.form_das .table tbody tr td{border: none;font-size: 16px;color: #fff;}
	.form_das .table tbody tr td:last-child{text-align: right;}
	.market-update-left {
    padding: 0px;
}
	.form_das h3 {
    color: #fff;
    font-size: 2.5em;
    font-family: 'Carrois Gothic', sans-serif;
		margin-bottom: 30px;
}
/*	.form_das h3::after{content: '';position: absolute;width: 15px;height: 3px;background-color: #333;bottom: 0px;left: 0px;}*/

	.market-update-right i.fa.fa-file-text-o {
    font-size: 3em;
    color: #337AB7;
    width: 80px;
    height: 80px;
    background: #fff;
    text-align: center;
    border-radius: 49px;
    -webkit-border-radius: 49px;
    -moz-border-radius: 49px;
    -o-border-radius: 49px;
    line-height: 1.7em;
}
	.form_das.clr-block-3 .market-update-right i.fa.fa-file-text-o{color: #28487b;}
	.form_das.clr-block-2 .market-update-right i.fa.fa-file-text-o{color: #c45d2c;}
	.form_das.clr-block-3 {
		background: #28487b;
	height: 100%;
/*		min-height: 229px;*/
	}
	.form_das.clr-block-2 {
		background: #c45d2c;}
	.form_das.clr-block:hover {
    background: #3C3C3C;
    transition: 0.5s all;
    -webkit-transition: 0.5s all;
    -moz-transition: 0.5s all;
    -o-transition: 0.5s all;
}
	
</style>
<div class="box">
<div class="box-content">
<div class="row">

<div class="col-sm-4">
	<div class="form_das clr-block clr-block-3">
		<div class="col-md-8 market-update-left">
			<h3>Today</h3>
			<table class="table">
				<tr>
					<td>Total Count</td>
					<td>:</td>
					<td><?= !empty($register_count_today) ? $register_count_today : '0'; ?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-4 market-update-right">
			<i class="fa fa-file-text-o"> </i>
		</div>
	  <div class="clearfix"> </div>
	</div>

  </div>


	<div class="col-sm-4">
	<div class="form_das clr-block clr-block-1">
		<div class="col-md-8 market-update-left">
			<h3>Monthly</h3>
			<table class="table">
				<tr>
					<td><?php echo date('F') ?></td>
					<td>:</td>
					<td><?= !empty($register_count_month) ? $register_count_month : '0';?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-4 market-update-right">
			<i class="fa fa-file-text-o"> </i>
		</div>
	  <div class="clearfix"> </div>
	</div>

  </div>
  <div class="col-sm-4">
	<div class="form_das clr-block clr-block-2">
		<div class="col-md-8 market-update-left">
			<h3>Yearly</h3>
			<table class="table">
				<tr>
					<td><?= date("Y");?></td>
					<td>:</td>
					<td><?= !empty($register_count_year) ? $register_count_year : '0'; ?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-4 market-update-right">
			<i class="fa fa-file-text-o"> </i>
		</div>
	  <div class="clearfix"> </div>
	</div>

  </div>
  <?php /*?><div class="col-sm-4">
	<div class="form_das clr-block clr-block-3">
		<div class="col-md-8 market-update-left">
			<h3>Total</h3>
			<table class="table">
				<tr>
					<td>Total Count</td>
					<td>:</td>
					<td><?= $register_count?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-4 market-update-right">
			<i class="fa fa-file-text-o"> </i>
		</div>
	  <div class="clearfix"> </div>
	</div>

  </div><?php */?>

</div>
</div>
