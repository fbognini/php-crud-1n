<?php
	session_start();
	include_once("config.php");
	
	if(isset($_POST["status"]) && !empty($_POST["status"]))
		$status = $_POST["status"];
	else
		$status = "menu";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Crud</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

		<script>
			$( document ).ready(function() {
				$(".rowclick").click(function(e) {
					if (!($(e.target).closest('td[class="editor"]').length > 0)) {
						$( "#idClasse" ).val($(this).attr('id'));
						$( "#fclassi" ).submit().attr('id')
					} 
				});

				$(".delete").click(function(e) {
					var $ele = $(e.target).parent().parent();
					var id = $ele.attr('id');
					var ids = [];
					ids.push(id);

					var values = { table : 0, id : ids }

					if (confirm("ATTENZIONE\nCancellando la classe eliminererai anche gli studenti che ne fanno parte.\nVuoi continuare?")) {
						$.ajax({
							type:'POST',
							url:'function/delete.php',
							data: values,
							success: function(data) {
								if(data == "YES"){
									alert("La classe è stata eliminata");
									location.reload();
								} else {
									alert(data);
								}
							}
						})
					} 
				});
				
				$("#add").click(function(e) {
					var classe = $("#newClasse").val();
					var coordinatore = $("#newCoordinatore").val();
					var msg="";
					if(!classe)
						msg += "ERRORE: aggiungere la classe\n";
					if(!coordinatore)
						msg += "ERRORE: aggiungere il coordinatore\n";
						
					if(msg) {
						alert(msg);
					} else {
						ids = {classe: classe, coordinatore: coordinatore};
						var values = { table : 0, values : ids };
						$.ajax({
							type:'POST',
							url:'function/add.php',
							data: values,
							success: function(data) {
								if(data == "YES"){
									alert("La classe è stata aggiunta");
									location.reload();
								} else {
									alert(data);
								}
							}
						})
					}
				});
			});
	</script>
	</head>
	<body>
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<div class="container">
				<div class="navbar-brand">Pannello amministratore</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- Navbar links -->
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="#">Lista Classi</a>
						</li>
					</ul>
				</div> 
			</div>
		</nav>
		<main role="main">
        <div class="jumbotron">
			<div class="container">
				<h1 class="display-4">Benvenuto</h1>
			</div>
        </div>
		<div class="container">
		
			<h4>Lista classi</h4>

			<p>Tabella contente tutti le classi presenti nel dabatase</p>

			<div class="form-row">
				<div class="col-3"><input type="text" id="newClasse" class="form-control" placeholder="Classe" required></div>
				<div class="col-6"><input type="text" id="newCoordinatore" class="form-control" placeholder="Coordinatore" required></div>
				<div class="col-3"><button type="button" class="btn btn-primary w-100" id="add">AGGIUNGI</button></div>
			</div>
			<form method="GET" id="fclassi" class="form-horizontal" action="classe/index.php">
				<input type="hidden" id="idClasse" name="idClasse"/>
			
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr><th style="width: 5%"></th><th style="width: 5%">Classe</th><th>Coordinatore</th></tr>
						</thead>
						<tbody>
						<?php
						$query = "SELECT * FROM crud_classi";
						if ($result = $mysqli->query($query)) {
							while ($row = $result->fetch_assoc()) {
								$id = $row['id'];
								$classe = htmlentities($row['classe']);
								$coordinatore = htmlentities($row['coordinatore']);
								echo '<tr class="pointer rowclick" id="'.$id.'"><td style="width: 5%">'.$id.'</td><td><b>'.$classe.'</b></td><td>'.$coordinatore.'</td><td class="editor"><i class="material-icons delete" >delete</i></td></tr>';
							}
							$result->free();
						}
						?>
						</tbody>
					</table>
				</div>
				
				
				<?php
			echo "</form>";
		?>
		</div>
		</main>
		<footer class="container">
			<hr>
			<p>&copy; Franceso Bognini - I sorgenti sono disponibili su <a href="https://github.com/fbognini/php-crud-db" target="_blank">GitHub</a></p>
		</footer>
	</body>
</html>