<?php
    include('../config.php');

    $table = $_POST['table'];
    // $values = $_POST['values'];
    // $id = implode(",",$id);
	// var_dump($values);
	$result = true;
    if ($table == 0) {
		// $values['classe'] = $mysqli->real_escape_string(strtoupper($values['classe']));
		// $values['coordinatore'] = $mysqli->real_escape_string(ucfirst(strtolower($values['coordinatore'])));
        $query = "SELECT * FROM crud_classi";
        // echo $query;
        $result = $mysqli->query($query);
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row; 
        }
    }
    else {
		$cognome    = $mysqli->real_escape_string(ucfirst(strtolower($values['cognome'])));
		$nome       = $mysqli->real_escape_string(ucfirst(strtolower($values['nome'])));
        $data       = $mysqli->real_escape_string($values['data']);
        $idClasse   = $mysqli->real_escape_string($values['idClasse']);
        $query = "INSERT INTO crud_studenti (cognome, nome, dataNascita, idClasse) VALUES ('$cognome', '$nome', '$data', '$idClasse')";
		// echo $query;
		if (!$mysqli->query($query)) {
			echo "ERRORE: matricola gia' presente";
			unset($result);
		}
        
    }
    if (isset($result)) {
        echo json_encode($data);
    } 
?>