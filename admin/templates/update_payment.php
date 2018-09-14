<?php
	if(
		isset($_POST['id'])
		&& isset($_POST['fee'])
		&& isset($_POST['tx'])
	){
		
		$check = datosSQL("Select * from ".TBL_WITHDRAW." where `status` = ('0') and id='{$_POST['id']}'");
		if(isset($check->error) && $check->error == false && isset($check->data[0])){
			$check->data[0]['request'] = (float) $check->data[0]['request'];
			$check->data[0]['fee'] = (float) $_POST['fee'];
			$check->data[0]['totalPaid'] = (float) ($check->data[0]['request'] - $check->data[0]['fee']);
			$check->data[0]['tx'] = (string) $_POST['tx'];
			
			$update = crearSQL("UPDATE ".TBL_WITHDRAW." SET fee=?, totalPaid=?, tx=?, status=? WHERE id='{$_POST['id']}' ", array(
				$check->data[0]['fee']
				, $check->data[0]['totalPaid']
				, $check->data[0]['tx']
				, 1
			));
			if(isset($check->error) && $check->error == false && isset($check->data[0])){
				echo '<div class="alert alert-success" role="alert">Pago Actualizado.</div>';
			}else{
				echo '<div class="alert alert-danger" role="alert">Pago No Actualizado.</div>';
			}
		}else{
			echo '<div class="alert alert-warning" role="alert">No existe el pago.</div>';
		}
	}

	$dt = new DateTime();
	$today = $dt->format('Y-m-d H:i:s');
	$old = strtotime('-1 month', strtotime($today));
	$old = date('Y-m-d H:i:s', $old);
	
	$check = datosSQL("Select * from ".TBL_WITHDRAW." where `status`='0' and `create` >= ('{$old}') OR wallet_id='1' AND `create` <= ('{$today}')");
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
				Actualizar Pagos
			</div>
			<div class="card-body">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>id</th>
							<th>Address</th>
							<th>Solicitado</th>
							<th style="min-width:250px;">Fee</th>
							<th style="min-width:250px;">Transaccion</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payment As $items){ ?>
							<form method="POST" action="">
								<tr>
									<td><?php echo $items->id; ?></td>
									<td><a href="https://explorer.webchain.network/addr/<?php echo $items->wallet_address; ?>"><?php echo $items->wallet_address; ?></a></td>
									
									<td><?php echo $items->request; ?> <?php echo $items->wallet_coin; ?></td>
									<td><input name="fee" class="form-control" type="number" value="<?php echo $items->fee; ?>" /></td>
									<td><input name="tx" class="form-control" type="text" value="<?php echo $items->tx; ?>" /></td>
									
									<input name="id" class="form-control" type="hidden" value="<?php echo $items->id; ?>" />
									<td><button type="submit" class="btn btn-sm btn-success">Pagado</button></td>
								</tr>
							</form>
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