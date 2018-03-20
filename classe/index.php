<?php
	session_start();
	include_once("../config.php");
	
	if(isset($_GET["idClasse"]) && !empty($_GET["idClasse"]))
		$idClasse = (int)$_GET["idClasse"];
	else
		$idClasse = 1;
	
	$query = "SELECT classe, coordinatore FROM crud_classi WHERE id=$idClasse;";
	$result = $mysqli->query($query);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$classe = $row['classe'];
		$coordinatore = $row['coordinatore'];
		$result->free();
	} else {
		header('Location: ../index.php');
	}
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
		<link href="../style.css" rel="stylesheet">
		<script>
			$( document ).ready(function() {
				$(".rowclick").click(function(e) {
					if (!($(e.target).closest('[type="checkbox"]').length > 0)) {
						$( "#idStudente" ).val($(this).attr('id'));
						$( "#fstudenti" ).submit().attr('id')
					} 
				});

				$("#checkAll").click(function() {
    				$('input:checkbox').not(this).prop('checked', this.checked);

					if ( $("[name=students]:checked").length == 0) {
						$("#azioni").hide();
					} else {
						$("#azioni").show();
					}
				});

				$("[name=students]").click(function () {
					if ($(this).is(":checked")) {
						var isAllChecked = 0;

						$("[name=students]").each(function() {
							if (!this.checked)
								isAllChecked = 1;
						});

						if (isAllChecked == 0) {
							$("#checkAll").prop("checked", true);
						}     
					}
					else {
						$("#checkAll").prop("checked", false);
					}

					if ( $("[name=students]:checked").length == 0) {
						$("#azioni").hide();
					} else {
						$("#azioni").show();
					}

					
				});

				$("#delete").click(function(e) {
					var ids = [];
					var id;

					$("[name=students]:checked").each(function() {
						id = $(this).parent().parent().attr('id');
						ids.push(id);
					});

					var values = { table : 1, id : ids };
 
					if (confirm("Vuoi cancellare tutti gli studenti selezionati?")) {
						$.ajax({
							type:'POST',
							url:'../function/delete.php',
							data: values,
							success: function(data) {
								if(data == "YES"){
									alert("Gli studenti sono stati elimati");
									location.reload();
								} else {
									alert(data);
								}
							}
						})
					} 
				});

				$(".delete").click(function(e) {
					var $ele = $(e.target).parent().parent();
					var id = $ele.attr('id');
					var ids = [];
					ids.push(id);

					var values = { table : 1, id : ids }

					$.ajax({
						type:'POST',
						url:'../function/delete.php',
						data: values,
						success: function(data) {
							if(data == "YES"){
								alert("Lo studente è stato eliminato");
								location.reload();
							} else {
								alert(data);
							}
						}
					})
				});

				$("#edit").click(function(e) {
					var id = $("#idClasse").val();
					var classe = $("#editClasse").val();
					var coordinatore = $("#editCoordinatore").val();
					// console.log(id + " " + classe + " " + coordinatore);
					var msg = "";
					if(!classe)
						msg += "ERRORE: aggiungere la classe\n";
					if(!coordinatore)
						msg += "ERRORE: aggiungere il coordinatore\n";
						
					if(msg) {
						alert(msg);
					} else {
						ids = {id: id, classe, coordinatore: coordinatore};
						var values = { table : 0, values : ids };
						$.ajax({
							type:'POST',
							url:'../function/edit.php',
							data: values,
							success: function(data) {
								if(data == "YES"){
									alert("La classe è stata modificata");
									location.reload();
								} else {
									alert(data);
								}
							}
						});
					}
				});
				
				// $("#add").click(function(e) {
					
				// 	// $('#emptyDropdown').empty()
				// 	// var dropDown = document.getElementById("carId");
				// 	// var carId = dropDown.options[dropDown.selectedIndex].value;
				// 	// $.ajax({
				// 		// type: "POST",
				// 		// url: "/project/main/getcars",
				// 		// data: { 'carId': carId  },
				// 		// success: function(data){
				// 			// var opts = $.parseJSON(data);
				// 			// $.each(opts, function(i, d) {
				// 				// $('#emptyDropdown').append('<option value="' + d.ModelID + '">' + d.ModelName + '</option>');
				// 			// });
				// 		// }
				// 	// });
				// });
				
				$("#add").click(function(e) {

					var campi = ["cognome", "nome", "data di nascita"];
					var valori = [];
					var i = 0;
					var msg = "";
					$("#myModal :input[name='form']").each(function() {
							if(!this.value) {
								msg += "ERRORE: inserire campo " + campi[i] + "\n";
							} else {
								valori[i] = this.value;
							}
							i++;
					});

					if (msg) {
						alert(msg);
					} else {
						ids = { cognome: valori[0], nome: valori[1], data: valori[2], idClasse: $("#idClasse").val() };
						var values = { table : 1, values : ids };
						$.ajax({
							type:'POST',
							url:'../function/add.php',
							data: values,
							success: function(data) {
								if(data == "YES"){
									alert("Lo studente è stato aggiunto");
									location.reload();
								} else {
									alert(data);
								}
							}
						})
					}
				});

				$('.back').click(function(){
					parent.history.back();
					return false;
				});
				 
			});
		</script>
	</head>
	<body>
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
            	<i class="material-icons back" style="color: white">arrow_back</i>
			<div class="container">
				<div class="navbar-brand">Pannello amministratore</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<!-- Navbar links -->
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="../">Lista Classi</a>
						</li>
					</ul>
				</div> 
			</div>
		</nav>
		<main role="main">
		<!-- The Modal -->
		<div class="modal fade" id="myModal">
			<div class="modal-dialog">
			<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
			<h4 class="modal-title">Nuovo studente</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
			<div class="form-group row">
			<label for="inputCognome" class="col-sm-4 col-form-label">Cognome</label>
			<div class="col-sm-8">
			<input type="text" name="form" class="form-control" id="inputCognome">
			</div>
			</div>
			<div class="form-group row">
			<label for="inputNome" class="col-sm-4 col-form-label">Nome</label>
			<div class="col-sm-8">
			<input type="text" name="form" class="form-control" id="inputNome">
			</div>
			</div>
			<div class="form-group row">
			<label for="inputData" class="col-sm-4 col-form-label">Data di nascita</label>
			<div class="col-sm-8">
			<input type="date" name="form" class="form-control" id="inputData">
			</div>
			</div>
			<div class="form-group row">
			<label for="inputClasse" class="col-sm-4 col-form-label">Classe</label>
			<div class="col-sm-8">
			<?php echo '<input type="text" class="form-control" id="inputClasse" value="'.$classe.'" disabled>'; ?>
			</div>
			</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
			<button type="button" class="btn btn-danger" id="add">Aggiungi</button>
			<!--button type="button" class="btn btn-danger" data-dismiss="modal" id="add">Aggiungi</button-->
			</div>

			</div>
			</div>
		</div>
        <div class="jumbotron">
			<div class="container">
				<h1 class="display-4">Classe <?php echo htmlentities($classe) ?></h1>
			</div>
        </div>
		<div class="container">
			<h4>Modifica classe</h4>
			<div class="form-row">
				<?php 
				echo '<input type="hidden" id="idClasse" name="idClasse" value="'.$idClasse.'">';
				echo '<div class="col-3"><input type="text" id="editClasse" class="form-control" placeholder="Classe" value="'.$classe.'" required></div>';
				echo '<div class="col-6"><input type="text" id="editCoordinatore" class="form-control" placeholder="Coordinatore" value="'.$coordinatore.'" required></div>';
				?>
				<div class="col-3"><button type="button" class="btn btn-primary w-100" id="edit">Modifica</button></div>
			</div>
			<br>
			<form method="GET" id="fstudenti" class="form-horizontal" action="../studente/index.php">
				<input type="hidden" id="idStudente" name="idStudente"/>
			
				<h4>Studenti</h4>
				<div class="row">
					<div class="group">
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Nuovo</button>
					</div>
					<div class="group" id="azioni">
						<button type="button" class="btn btn-primary" id="delete">Elimina</button>
						<button type="button" class="btn btn-default" hidden>Sposta</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr><th style="width: 5%"><input type="checkbox" id="checkAll"></th><th style="width: 5%"></th><th style="width: 10%">Matricola</th><th>Cognome</th><th>Nome</th></tr>
						</thead>
						<tbody>
						<?php
						$query = "SELECT * FROM crud_studenti WHERE idClasse=$idClasse;";
						if ($result = $mysqli->query($query)) {
							$i = 1;
							while ($row = $result->fetch_assoc()) {
								$idStudente = $row['id'];
								$nome = htmlentities($row['nome']);
								$cognome = htmlentities($row['cognome']);
								// $data = htmlentities(date("d-m-Y", strtotime($row['dataNascita'])));
								echo '<tr class="rowclick pointer" id="'.$idStudente.'"><td><input type="checkbox" name="students"></td><td>'.$i++.'</td><td>'.$idStudente.'</td><td><b>'.$cognome.'</b></td><td>'.$nome.'</td></tr>';
							}
							$result->free();
						}
						?>
						</tbody>
					</table>
				</div>
			</form>	
		</div>
		</main>
		<footer class="container">
			<hr>
			<p>&copy; Franceso Bognini - I sorgenti sono disponibili su <a href="https://github.com/fbognini/php-crud-1n" target="_blank">GitHub</a></p>
		</footer>
	</body>
</html>