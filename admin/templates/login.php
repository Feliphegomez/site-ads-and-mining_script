<?php
	if(isset($_POST['nick']) && isset($_POST['hash'])){
		$_POST['hash'] = md5($_POST['hash']);
		
		
		$checkb = datosSQL("Select * from ".TBL_ADMIN." where nick='{$_POST['nick']}' and hash='{$_POST['hash']}'");
		if(isset($checkb->error) && $checkb->error == false && isset($checkb->data[0])){
			$_SESSION = $checkb->data[0];
			?>
			<meta http-equiv="refresh" content="0; url=index.php">
			<?php
			exit();
		}else{
			echo "Datos Incorrectos.";
		}	
	}
?>
<div class="row">
	<div class="col-md-4 offset-md-4">
		<div class="card text-center card  bg-default mb-3">
			<div class="card-header">
				Panel Admin
			</div>
			<form method="POST" action="">
				<div class="card-body">
					<input type="text" name="nick" class="form-control input-sm chat-input" placeholder="Usuario" />
					</br>
					<input type="password" name="hash" class="form-control input-sm chat-input" placeholder="Contraseña" />
				</div>
				<div class="card-footer text-muted">
					<button type="submit" class="btn btn-secondary">Ingresar</button>
				</div>
			</form>
		</div>
	</div>
</div>