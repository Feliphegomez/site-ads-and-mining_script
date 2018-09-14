<?php if(isset($_SESSION['nick'])){ ?>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand text-white" href="index.php">ADMIN</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav ml-auto">
				
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user"></i> Estadisticas
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<?php
								
								$checkb = datosSQL("Select coin from ".TBL_WALLET." group by coin ");
								if(isset($checkb->error) && $checkb->error == false && isset($checkb->data[0])){
									foreach($checkb->data As $item){
										echo '<a class="dropdown-item" href="index.php?page=report&coin='.$item['coin'].'">  '.$item['coin'].'</a>';
									}
								}else{}
							?>
							
						</div>
					</li>
				
				
					<li class="nav-item"><a class="nav-link " href="index.php?page=update_payment"> <i class="fa fa-briefcase"></i> Actualizar Pagos</a></li>
					<li class="nav-item"><a class="nav-link " href="index.php?page=payment"><i class="fa fa-book"></i> Ultimos Pagos</a></li>
					
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user"></i> <?php echo $_SESSION['nick']; ?>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="index.php?page=logout">  Cerrar Sesion</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<bR>
	<bR>
<?php } ?>