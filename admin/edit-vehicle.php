<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_POST['submit'])) {
		$vehicletitle = $_POST['vehicletitle'];
		$brand = $_POST['brandname'];
		$vehicleoverview = $_POST['vehicalorcview'];
		$priceperday = $_POST['priceperday'];
		$fueltype = $_POST['fueltype'];
		$modelyear = $_POST['modelyear'];
		$seatingcapacity = $_POST['seatingcapacity'];
		$vimage1 = $_FILES["img1"]["name"];
		$vimage2 = $_FILES["img2"]["name"];
		$vimage3 = $_FILES["img3"]["name"];
		$vimage4 = $_FILES["img4"]["name"];
		$vimage5 = $_FILES["img5"]["name"];
		$transmission = $_POST['transmissiontype'];
		$power = $_POST['power'];
		$id = intval($_GET['id']);

		$sql = "update tblvehicles set VehiclesTitle=:vehicletitle,VehiclesBrand=:brand,VehiclesOverview=:vehicleoverview,PricePerDay=:priceperday,FuelType=:fueltype,ModelYear=:modelyear,SeatingCapacity=:seatingcapacity,Transmission=:transmission,CarPower=:carpower where id=:id ";
		$query = $dbh->prepare($sql);
		$query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
		$query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
		$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
		$query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
		$query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
		$query->bindParam(':transmission', $transmission, PDO::PARAM_STR);
		$query->bindParam(':carpower', $power, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();

		$msg = "Editado com sucesso";
	}


?>
	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>Dashboard</title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>
	</head>

	<body>
		<?php include('includes/header.php'); ?>
		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title text-center">Editar Veículo</h2>

							<div class="row">
								<div class="col-md-12">
									<?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
									<?php
									$id = intval($_GET['id']);
									$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:id";
									$query = $dbh->prepare($sql);
									$query->bindParam(':id', $id, PDO::PARAM_STR);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $result) {	?>

											<form method="post" class="form-horizontal" enctype="multipart/form-data">
												<div class="form-group">
													<label class="col-sm-2 control-label">Nome <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="vehicletitle" class="form-control" value="<?php echo htmlentities($result->VehiclesTitle) ?>" required>
													</div>
													<label class="col-sm-2 control-label">Marca <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<select class="selectpicker" name="brandname" required>
															<option value="<?php echo htmlentities($result->bid); ?>"><?php echo htmlentities($bdname = $result->BrandName); ?> </option>
															<?php $ret = "select id,BrandName from tblbrands";
															$query = $dbh->prepare($ret);
															//$query->bindParam(':id',$id, PDO::PARAM_STR);
															$query->execute();
															$resultss = $query->fetchAll(PDO::FETCH_OBJ);
															if ($query->rowCount() > 0) {
																foreach ($resultss as $results) {
																	if ($results->BrandName == $bdname) {
																		continue;
																	} else {
															?>
																		<option value="<?php echo htmlentities($results->id); ?>"><?php echo htmlentities($results->BrandName); ?></option>
															<?php }
																}
															} ?>

														</select>
													</div>
												</div>

												<div class="hr-dashed"></div>
												<div class="form-group">
													<label class="col-sm-2 control-label">Informações Adicionais <span style="color:red">*</span></label>
													<div class="col-sm-10">
														<textarea class="form-control" name="vehicalorcview" rows="3" required><?php echo htmlentities($result->VehiclesOverview); ?></textarea>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Preço por Dia (€) <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="priceperday" class="form-control" value="<?php echo htmlentities($result->PricePerDay); ?>" required>
													</div>
													<label class="col-sm-2 control-label">Combustível <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<select class="selectpicker" name="fueltype" required>


															<?php if ($result->FuelType = "Diesel") { ?>
																<option default value="<?php echo htmlentities($result->FuelType); ?>"> <?php echo htmlentities($result->FuelType); ?> </option>
																<option value="Petrol">Gasolina</option>
															<?php } else { ?>
																<option default value="<?php echo htmlentities($result->FuelType); ?>"> <?php echo htmlentities($result->FuelType); ?> </option>
																<option value="Diesel">Diesel</option>
															<?php } ?>
														</select>
													</div>
												</div>


												<div class="form-group">
													<label class="col-sm-2 control-label">Ano <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="modelyear" class="form-control" value="<?php echo htmlentities($result->ModelYear); ?>" required>
													</div>
													<label class="col-sm-2 control-label">Capacidade <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="seatingcapacity" class="form-control" value="<?php echo htmlentities($result->SeatingCapacity); ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label">Potência <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="power" class="form-control" value="<?php echo htmlentities($result->CarPower); ?>" required>
													</div>
													<label class="col-sm-2 control-label">Transmição <span style="color:red">*</span></label>
													<div class="col-sm-4">
														<select class="selectpicker" name="transmissiontype" required>

															<?php if ($result->Transmission = "Manual") { ?>
																<option default value="<?php echo htmlentities($result->Transmission); ?>"> <?php echo htmlentities($result->Transmission); ?> </option>
																<option value="Automatic">Automática</option>
															<?php } else { ?>
																<option default value="<?php echo htmlentities($result->Transmission); ?>"> <?php echo htmlentities($result->Transmission); ?> </option>
																<option value="Manual">Manual</option>
															<?php } ?>

														</select>
													</div>
												</div>

												<div class="hr-dashed"></div>

												<div class="form-group">
													<div class="col-sm-12">
														<h4><b>Imagens</b></h4>
													</div>
												</div>


												<div class="form-group">
													<div class="col-sm-4">
														Imagem 1 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" width="300" height="200" style="border:solid 1px #000">
														<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id) ?>">Mudar Imagem 1</a>
													</div>
													<div class="col-sm-4">
														Imagem 2 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" width="300" height="200" style="border:solid 1px #000">
														<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id) ?>">Mudar Imagem 2</a>
													</div>
													<div class="col-sm-4">
														Imagem 3 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" width="300" height="200" style="border:solid 1px #000">
														<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id) ?>">Mudar Imagem 3</a>
													</div>
												</div>


												<div class="form-group">
													<div class="col-sm-4">
														Imagem 4 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" width="300" height="200" style="border:solid 1px #000">
														<a href="changeimage4.php?imgid=<?php echo htmlentities($result->id) ?>">Mudar Imagem 4</a>
													</div>
													<div class="col-sm-4">
														Imagem 5
														<?php if ($result->Vimage5 == "") {
															echo htmlentities("File not available");
														} else { ?>
															<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" width="300" height="200" style="border:solid 1px #000">
															<a href="changeimage5.php?imgid=<?php echo htmlentities($result->id) ?>">Mudar Imagem 5</a>
														<?php } ?>
													</div>

												</div>
												<div class="hr-dashed"></div>
										<?php }
									} ?>
										<div class="form-group">
											<div class="col-sm-8 col-sm-offset-4">
												<button class="btn btn-primary" name="submit" type="submit">Guardar</button>
											</div>
										</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>





		<!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
	</body>

	</html>
<?php } ?>