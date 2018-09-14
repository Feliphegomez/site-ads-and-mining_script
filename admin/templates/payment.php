<?php
	$dt = new DateTime();
	$today = $dt->format('Y-m-d H:i:s');
	$old = strtotime('-1 month', strtotime($today));
	$old = date('Y-m-d H:i:s', $old);
	
	$check = datosSQL("Select * from ".TBL_WITHDRAW." where `status`='1' and `create` >= ('{$old}') OR wallet_id='1' AND `create` <= ('{$today}')");
	$payment = (array());
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$payment[] = new PaymentInfo($item);
		}
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="card text-center card  bg-default mb-3">
			<div class="card-header">
				Ultimos Pagos
			</div>
			<div class="card-body">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>id</th>
							<th>Address</th>
							<th>Solicitado</th>
							<th>Fee</th>
							<th>Total Pagado</th>
							<th>Transaccion</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payment As $items){ ?>
							<tr>
								<td><?php echo $items->id; ?></td>
									<td><a href="https://explorer.webchain.network/addr/<?php echo $items->wallet_address; ?>" target="_new"><?php echo $items->wallet_address; ?></a></td>
								
								<td><?php echo $items->request; ?> <?php echo $items->wallet_coin; ?></td>
								<td><?php echo $items->fee; ?> <?php echo $items->wallet_coin; ?></td>
								<td><?php echo $items->totalPaid; ?> <?php echo $items->wallet_coin; ?></td>
								<td><a href="https://explorer.webchain.network/tx/<?php echo $items->tx; ?>" target="_new"><?php echo $items->tx; ?></a></td>
							</tr>
						<?php } ?>
						<?php if(count($payment) == 0){ ?>
							<tr><td colspan="6">No existen pagos pendientes por actualizar.</td></tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>