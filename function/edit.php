<?php
    include('../config.php');

    $table = $_POST['table'];
    $values = $_POST['values'];
    // $id = implode(",",$id);
	// var_dump($values);
	$result = true;
    if ($table == 0) {
		$values['classe'] = strtoupper($values['classe']);
		$values['coordinatore'] = ucfirst(strtolower($values['coordinatore']));
        $query = "UPDATE crud_classi SET classe='".$values['classe']."', coordinatore='".$values['coordinatore']."' WHERE id='".$values['id']."'";
		// echo $query;
		if (!$mysqli->query($query)) {
			echo "ERRORE\nClasse gia' presente";
			unset($result);
		}
    }
    else {
        $id         = $mysqli->real_escape_string($values['id']);
		$cognome    = $mysqli->real_escape_string(ucfirst(strtolower($values['cognome'])));
		$nome       = $mysqli->real_escape_string(ucfirst(strtolower($values['nome'])));
        $data       = $mysqli->real_escape_string($values['data']);
        $idClasse   = $mysqli->real_escape_string($values['idClasse']);
        $query = "UPDATE crud_studenti SET cognome='$cognome', nome='$nome', dataNascita='$data', idClasse='$idClasse' WHERE id='$id'";
		// echo $query;
		if (!$mysqli->query($query)) {
            echo "ERRORE\nSi è verificato un errore inaspettato";
			unset($result);
		}

        
    }
    if (isset($result)) {
        echo "YES";
     } 
?>