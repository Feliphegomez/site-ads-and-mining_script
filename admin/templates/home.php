<?php

	$dt = new DateTime();
	$inicio = $dt->format('Y-m-d H:i:s');
	$fin = date('Y-m-d H:i:s', strtotime('-1 month', strtotime($inicio)));
	
	$estadisticas_mes = AdminEstadisticasDate($inicio, $fin);
	
	
?>
<h2>Ultimo Mes</h2>

<div class="row dashboard-stats">
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-success">
				<i class="fa fa-cog text-large stat-icon success-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin countdown_first"><?php echo count($estadisticas_mes->jobs); ?></p>
				<p class="text-muted no-margin text"><span>Completados</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-danger">
				<i class="fa fa-shopping-cart text-large stat-icon danger-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin countdown_second"><?php echo count($estadisticas_mes->founds); ?></p>
				<p class="text-muted no-margin text"><span>Trabajos</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-lovender">
				<i class="fa fa-rocket text-large stat-icon lovender-text"></i>
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
				<p class="size-h1 no-margin countdown_fourth"><?php echo ($estadisticas_mes->users); ?></p>
				<p class="text-muted no-margin text"><span>Usuarios</span></p>
			</div>
		</section>
	</div>
	
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-info">
				<i class="fa fa-users text-large stat-icon info-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo ($estadisticas_mes->total_hashes); ?></p>
				<p class="text-muted no-margin text"><span>Total Hashes</span></p>
			</div>
		</section>
	</div>
	
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-info">
				<i class="fa fa-users text-large stat-icon info-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo ($estadisticas_mes->payment_pdte); ?></p>
				<p class="text-muted no-margin text"><span>Pagos Pendientes</span></p>
			</div>
		</section>
	</div>
	
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-info">
				<i class="fa fa-users text-large stat-icon info-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo ($estadisticas_mes->payment); ?></p>
				<p class="text-muted no-margin text"><span>Pagos Realizados</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-success">
				<i class="fa fa-money text-large stat-icon success-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo ($estadisticas_mes->payment_pdte_value); ?></p>
				<p class="text-muted no-margin text"><span>Pendiente X Pagar</span></p>
			</div>
		</section>
	</div>
	<div class="col-md-3 col-sm-6">
		<section class="panel panel-box">
			<div class="panel-left panel-icon bg-success">
				<i class="fa fa-money text-large stat-icon success-text"></i>
			</div>
			<div class="panel-right panel-icon bg-reverse">
				<p class="size-h1 no-margin "><?php echo ($estadisticas_mes->payment_value); ?></p>
				<p class="text-muted no-margin text"><span>Total Pagado</span></p>
			</div>
		</section>
	</div>
</div> 



<script>
$(function() {
	function countUp(count) {
		var div_by = 100,
			speed = Math.round(count / div_by),
			$display = $('.countdown_first'),
			run_count = 1,
			int_speed = 24;
		var int = setInterval(function () {
			if (run_count < div_by) {
				$display.text(speed * run_count);
				run_count++;
			} else if (parseInt($display.text()) < count) {
				var curr_count = parseInt($display.text()) + 1;
				$display.text(curr_count);
			} else {
				clearInterval(int);
			}
		}, int_speed);
	}
	countUp(<?php echo count($estadisticas_mes->founds); ?>);

	function countUp2(count) {
		var div_by = 100,
			speed = Math.round(count / div_by),
			$display = $('.countdown_second'),
			run_count = 1,
			int_speed = 24;
		var int = setInterval(function () {
			if (run_count < div_by) {
				$display.text(speed * run_count);
				run_count++;
			} else if (parseInt($display.text()) < count) {
				var curr_count = parseInt($display.text()) + 1;
				$display.text(curr_count);
			} else {
				clearInterval(int);
			}
		}, int_speed);
	}
	countUp2(<?php echo count($estadisticas_mes->jobs); ?>);

	function countUp3(count) {
		var div_by = 100,
			speed = Math.round(count / div_by),
			$display = $('.countdown_fourth'),
			run_count = 1,
			int_speed = 24;
		var int = setInterval(function () {
			if (run_count < div_by) {
				$display.text(speed * run_count);
				run_count++;
			} else if (parseInt($display.text()) < count) {
				var curr_count = parseInt($display.text()) + 1;
				$display.text(curr_count);
			} else {
				clearInterval(int);
			}
		}, int_speed);
	}
	countUp3(<?php echo ($estadisticas_mes->users); ?>);
});
</script>


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
