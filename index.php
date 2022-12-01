<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>PHP CRUD</title>
</head>

<body>
	<!-- on inlus le processu de connection a la base de donnee -->

	<?php require_once "process.php";?>
	<?php  if (isset ($_SESSION['message'])):?>
	<div class="alert alert-<?=$_SESSION['msg_type']?>">
		<?php
		echo $_SESSION['message'];
		unset($_SESSION['message']);
		?>
		<?php endif;?>


		<div class="container">

			<?php
			$result='';
			$name = '';
			$location = '';
			$update = false;
			$id = 0;
	$user='root';
	$mdp='';
	$bd='php_crud';
	$serveur='localhost';
	
	$link = mysqli_connect($serveur,$user,$mdp,$bd);
	if ($link)
	{
		 //echo ?connexion etablit?;
		 $result = $link -> query("SELECT * FROM data") ;   
	}
	else
	{
		die (mysqli_connect_error());
	}
	 //pre_r($result);
	 //pre_r($result -? fetch_assoc());
	 ?>
			<!-- creation du tableau  -->


			<div class="row justify-content-center">
				<table class="table">
					<thead>
						<tr>
							<th>Name </th>
							<th>Location</th>
							<th colspan="2">Action</th>
						</tr>
					</thead>
					<!-- bout de code qui permet d'ajouter une nouvelle ligne dans le tableau a chaque fois q'une condition est verifier -->
					<?php while ($row = $result -> fetch_assoc()):?>
					<tr>
						<td>
							<?php echo $row['name'];?>
						</td>
						<td>
							<?php echo $row['location'];?>
						</td>
						<td>
							<a href="process.php?edit= <?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
							<a href="process.php?delete= <?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
						</td>
					</tr>
					<?php endwhile ;?>
				</table>
			</div>

			<?php


	 //insertion de la fonction qui permet de ranger les elements sous forme de tableau.
	function pre_r( $array)

	{
		echo '<pre>';
		print_r($array);
		echo '</pre>'; 
	}
	if(isset($_GET['update'])){
		$update = true;
	}else{
		$update = false;
	}

	if($update == 'true') {
		$id = $_GET['id'];
		$result_upt = $link->query("SELECT * FROM data WHERE id= $id") or die($link->error);
		$update_row = $result_upt->fetch_assoc();
		$name = $update_row['name'];
		$location =$update_row['location'];
	}

	?>
			
		<div class="row justify-content-center">
			<form action="process.php" method="POST">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class=" form-group">
					<label for="Name">Name</label>
					<input type="text" name="name" class="form-control" value="<?php echo $name; ?>"
						placeholder=" Enter your name">
				</div>
				<div class="form-group">
					<label for="Location">Location</label>
					<input type="text" name="location" class="form-control" value="<?php echo $location; ?>"
						placeholder=" Enter your location">
				</div>
				<div class="form-group">
					<?php if ($update==true):?>
					<button type="submit" class="btn btn-info" name="update">Update</button>
					<?php else: ?>
					<button type="submit" class="btn btn-primary" name="save">Save</button>
					<?php endif; ?>
				</div>
			</form>
		</div>


</body>

</html>