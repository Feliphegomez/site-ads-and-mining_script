<?php
	if(isset($_GET['coin']) && $_GET['coin'] == "XMR" || isset($_GET['coin']) && $_GET['coin'] == "WEB"){
		$coin = $_GET['coin'];
	}else{
		exit("NO EXISTE LA MONEDA");
	}
	
	$estadisticas_mes = EstadisticasMesCoin($coin);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="row dashboard-stats">
	<h2>Ultimo Mes Detallado (<?php echo $coin; ?>)</h2>
	<hr>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-success">
				<i class="fa fa-check-circle-o text-large stat-icon success-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin countdown_first"><?php echo $estadisticas_mes->total_founds; ?></p>
				<p class="text-muted no-margin text"><span>Completados</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-danger">
				<i class="fa fa-briefcase text-large stat-icon danger-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin countdown_second"><?php echo $estadisticas_mes->total_jobs; ?></p>
				<p class="text-muted no-margin text"><span>Trabajos</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-lovender">
				<i class="fa fa-free-code-camp text-large stat-icon lovender-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin countdown_third"><?php echo (int) $estadisticas_mes->orphan; ?><span class="size-h3">%</span></p>
				<p class="text-muted no-margin text"><span>Huerfanos</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-info">
				<i class="fa fa-users text-large stat-icon info-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin countdown_fourth"><?php echo $estadisticas_mes->users; ?></p>
				<p class="text-muted no-margin text"><span>Usuarios</span></p>
			</div>
		</section>
	</div>
	
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-warning">
				<i class="fa fa-th text-large stat-icon warning-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo $estadisticas_mes->total_found_hashes; ?></p>
				<p class="text-muted no-margin text"><span>Total Hashes</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-secondary">
				<i class="fa fa-hourglass-end text-large stat-icon secondary-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo $estadisticas_mes->total_pdtePayment; ?></p>
				<p class="text-muted no-margin text"><span>Pagos Pendientes</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-success">
				<i class="fa fa-paper-plane text-large stat-icon success-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo $estadisticas_mes->total_payment; ?></p>
				<p class="text-muted no-margin text"><span>Pagos Realizados</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-danger">
				<i class="fa fa-shopping-cart text-large stat-icon danger-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo $estadisticas_mes->total_pdtePayment_value; ?></p>
				<p class="text-muted no-margin text"><span>Pendiente X Pagar</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-lovender">
				<i class="fa fa-money text-large stat-icon lovender-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo $estadisticas_mes->total_payment_value; ?></p>
				<p class="text-muted no-margin text"><span>Total Pagado</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-info">
				<i class="fa fa-balance-scale text-large stat-icon info-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo $estadisticas_mes->total_payment_value + $estadisticas_mes->total_pdtePayment_value; ?></p>
				<p class="text-muted no-margin text"><span>Total</span></p>
			</div>
		</section>
	</div>
</div>


<div class="row">
	<div class="col-md-4">
		<div id="chart1"></div>
	</div>
	<div class="col-md-4">
		<div id="chart2"></div>
	</div>
	<div class="col-md-4">
		<div id="chart3"></div>
	</div>
</div> 

<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	google.charts.setOnLoadCallback(drawChart2);
	google.charts.setOnLoadCallback(drawChart3);
	
	function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Topping');
		data.addColumn('number', 'Slices');
		data.addRows([
			['Pagado', <?php echo $estadisticas_mes->total_payment; ?>],
			['Pendiente X Pagar', <?php echo $estadisticas_mes->total_pdtePayment; ?>]
		]);

		var options = { 'title': 'Pagos', 'width': "100%", 'height': 350 };
		var chart = new google.visualization.PieChart(document.getElementById('chart1'));
		chart.draw(data, options);
	}
	
	function drawChart2() {
		var data2 = new google.visualization.DataTable();
		data2.addColumn('string', 'Topping');
		data2.addColumn('number', 'Slices');
		data2.addRows([
			['Pagado', <?php echo $estadisticas_mes->total_payment_value; ?>],
			['Pendiente X Pagar', <?php echo $estadisticas_mes->total_pdtePayment_value; ?>]
		]);

		var options2 = { 'title': 'Pagos $$$', 'width': "100%", 'height': 350 };
		var chart2 = new google.visualization.PieChart(document.getElementById('chart2'));
		chart2.draw(data2, options2);
	}
	function drawChart3() {
		var data3 = new google.visualization.DataTable();
		data3.addColumn('string', 'Topping');
		data3.addColumn('number', 'Slices');
		data3.addRows([
			['Completados', <?php echo $estadisticas_mes->total_founds; ?>],
			['Incompletos', <?php echo ($estadisticas_mes->total_jobs - $estadisticas_mes->total_founds); ?>]
		]);

		var options3 = { 'title': 'Trabajos', 'width': "100%", 'height': 350 };
		var chart3 = new google.visualization.PieChart(document.getElementById('chart3'));
		chart3.draw(data3, options3);
	}
</script>


<h3>Completados</h3>
<div class="row">
	<div class="col-md-6">
		<table class="table table-responsive">
			<tr>
				<th>Address</th>
				<th>Found ID</th>
				<th>Hashes</th>
				<th>Hashes/Seg</th>
			</tr>
			<?php 
				foreach($estadisticas_mes->founds As $item){ 
					if($item->wallet_address !== ''){
				?>
				<tr>
					<td><a target="_new" href="https://explorer.webchain.network/addr/<?php echo $item->wallet_address; ?>"><?php echo substr($item->wallet_address, 0, -25); ?>...</a></td>
					<td><?php echo $item->found_id; ?></td>
					<td><?php echo $item->found_hashes; ?> H</td>
					<td><?php echo $item->found_hashesPerSecond; ?> H/s</td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div>
	
	<div class="col-md-6">
		<h3>Trabajos</h3>
		<table class="table table-responsive">
			<tr>
				<th>Address</th>
				<th>Job ID</th>
				<th>Throttle</th>
			</tr>
			<?php 
				foreach($estadisticas_mes->jobs As $item){ 
					if($item->wallet_address !== ''){
				?>
				<tr>
					<td><a target="_new" href="https://explorer.webchain.network/addr/<?php echo $item->wallet_address; ?>"><?php echo substr($item->wallet_address, 0, -25); ?>...</a></td>
					<td><?php echo $item->job_id; ?></td>
					<td><?php echo $item->job_throttle; ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div> 
</div>

<div class="row">
	<div class="col-md-6">
		<h3>Pagos Pendientes</h3>
		<table class="table table-responsive">
			<tr>
				<th>Address</th>
				<th>Pago ID</th>
				<th>Solicitado</th>
				<th>Fee</th>
				<th>Total Pagado</th>
			</tr>
			<?php 
				foreach($estadisticas_mes->pdtePayment As $item){ 
					if($item->wallet_address !== ''){
				?>
				<tr>
					<td><a target="_new" href="https://explorer.webchain.network/addr/<?php echo $item->wallet_address; ?>"><?php echo substr($item->wallet_address, 0, -25); ?>...</a></td>
					<td><?php echo $item->withdraw_id; ?></td>
					<td><?php echo $item->withdraw_request; ?> <?php echo $item->wallet_coin; ?></td>
					<td><s><?php echo $item->withdraw_fee; ?> <?php echo $item->wallet_coin; ?></s></td>
					<td><s><?php echo $item->withdraw_totalPaid; ?> <?php echo $item->wallet_coin; ?></s></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div> 
	
	<div class="col-md-6">
		<h3>Pagos Realizados</h3>
		<table class="table table-responsive">
			<tr>
				<th>Address</th>
				<th>Pago ID</th>
				<th>Solicitado</th>
				<th>Fee</th>
				<th>Total Pagado</th>
			</tr>
			<?php 
				foreach($estadisticas_mes->payment As $item){ 
					if($item->wallet_address !== ''){
				?>
				<tr>
					<td><a target="_new" href="https://explorer.webchain.network/addr/<?php echo $item->wallet_address; ?>"><?php echo substr($item->wallet_address, 0, -25); ?>...</a></td>
					<td><?php echo $item->withdraw_id; ?></td>
					<td><?php echo $item->withdraw_request; ?> <?php echo $item->wallet_coin; ?></td>
					<td><?php echo $item->withdraw_fee; ?> <?php echo $item->wallet_coin; ?></td>
					<td><?php echo $item->withdraw_totalPaid; ?> <?php echo $item->wallet_coin; ?></td>
					<td><a target="_new" href="https://explorer.webchain.network/tx/<?php echo $item->withdraw_tx; ?>"><?php echo substr($item->withdraw_tx, 0, -45); ?>...</a></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div> 
</div>



<style>
.panel-box {
    display: table;
    table-layout: fixed;
    width: 100%;
    height: 100px;
    text-align: center;
    border: medium none;
}
	
.panel-box .panel-icon {
    display: table-cell;
    padding: 29px;
    width: 1%;
    vertical-align: top;
    border-radius: 0px;
    text-align: center;
	border-bottom: 1px solid #fcfcfc;
	border-top: 1px solid #fcfcfc;
	border-right: 1px solid #fcfcfc;
}

.dashboard-stats .stat-icon {
    line-height: 65px;
}

.bg-success {
    background-color: #A3C86D !important;
    color: #FFF !important;
}
	
.success-text {
    color: #82b33a;
}
	
.bg-danger {
    background-color: #FF7857 !important;
    color: #FFF !important;
}
	
.danger-text {
    color: #d15b3d;
}

.bg-lovender {
    background-color: #8075C4 !important;
    color: #FFF !important;
}

.lovender-text {
    color: #6a5fb1;
}

.bg-info {
    background-color: #7ACBEE !important;
    color: #FFF !important;
}
	
.info-text {
    color: #3ca0cb;
}

.size-h1 {
    font-size: 20px;
}

.panel-icon p.text {
    font-weight: bold;
    font-size: 14px;
    text-align: center;
}

.panel-icon i {
    text-align: center;
}

.panel-icon i {
    text-align: center;
}

.text-large {
    font-size: 50px;
}

.text-large {
    font-size: 50px;
}
</style>
