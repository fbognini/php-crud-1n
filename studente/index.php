<?php
	session_start();
	include_once("../config.php");
	
    if(isset($_GET["idStudente"]) && !empty($_GET["idStudente"]))
		$idStudente = (int)$_GET["idStudente"];
	else
		$idStudente = 1;
	
	$query = "SELECT * FROM crud_studenti WHERE id=$idStudente;";
	$result = $mysqli->query($query);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$id = $row['id'];
		$cognome = $row['cognome'];
		$nome = $row['nome'];
        $dataNascita = $row['dataNascita'];
		$idClasse = $row['idClasse'];
		// $coordinatore = $row['coordinatore'];
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
                $(function(){
                    $.ajax({
                        type: "POST",
                        url: "../function/read.php",
                        data: { table: 0  },
                        success: function(data) {
                            var opts = $.parseJSON(data);
                            $.each(opts, function(i, d) {
                                if (d.id == $('#idClasse').val())
                                    $('#inputClasse').append('<option value="' + d.id + '" selected>' + d.classe + '</option>');
                                else
                                    $('#inputClasse').append('<option value="' + d.id + '">' + d.classe + '</option>');

                            });
                        }
                    });

                });
                

                $('.back').click(function(){
					parent.history.back();
					return false;
				});

                $('#modifica').click(function(){
                    var campi = ["cognome", "nome", "data di nascita", "classe"];
					var valori = [];
					var i = 0;
					var msg = "";
					$("[name='form']").each(function() {
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
						ids = { id: $('#idStudente').val(), cognome: valori[0], nome: valori[1], data: valori[2], idClasse: valori[3]  };
						var values = { table : 1, values : ids };
                        console.log(ids);
						$.ajax({
							type:'POST',
							url:'../function/edit.php',
							data: values,
							success: function(data) {
								if(data == "YES"){
									alert("Lo studente è stato modificato");
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
        <div class="jumbotron">
			<div class="container">
				<h1 class="display-4">Studente <?php echo $id ?></h1>
			</div>
        </div>
		<div class="container">
        
				<input type="hidden" id="idStudente" value="<?php echo $idStudente ?>"/>
				<input type="hidden" id="idClasse" value="<?php echo $idClasse ?>"/>
		
				<h4>Dati</h4>

                <div class="form-group row">
                <label for="inputCognome" class="col-sm-3 col-form-label">Cognome</label>
                <div class="col-sm-9">
                <input type="text" name="form" class="form-control" id="inputCognome" value="<?php echo $cognome ?>">
                </div>
                </div>
                <div class="form-group row">
                <label for="inputNome" class="col-sm-3 col-form-label">Nome</label>
                <div class="col-sm-9">
                <input type="text" name="form" class="form-control" id="inputNome" value="<?php echo $nome ?>">
                </div>
                </div>
                <div class="form-group row">
                    <label for="inputData" class="col-sm-3 col-form-label">Data di nascita</label>
                    <div class="col-sm-9">
                    <input type="date" name="form" class="form-control" id="inputData" value="<?php echo $dataNascita ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputClasse" class="col-sm-3 col-form-label">Classe</label>
                    <div class="col-sm-9">
                    <select class="form-control" name="form" id="inputClasse"></select>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="modifica">Modifica i dati</button>
		</div>
		</main>
		<footer class="container">
			<hr>
			<p>&copy; Franceso Bognini - I sorgenti sono disponibili su <a href="https://github.com/fbognini/php-crud-1n" target="_blank">GitHub</a></p>
		</footer>
	</body>
</html>