<?php $estadisticas_mes = EstadisticasMesCoin("XMR"); ?>
<div class="row dashboard-stats">
	<h2>Ultimo Mes (XMR)</h2>
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
<hr>

<?php $estadisticas_mes = EstadisticasMesCoin("WEB"); ?>
<div class="row dashboard-stats">
	<h2>Ultimo Mes (WEB)</h2>
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
