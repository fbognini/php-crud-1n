<?php
    include('../config.php');

    $table = $_POST['table'];
    $idClasse = $_POST['values'];
    // $id = implode(",",$id);
	// var_dump($idClasse);
	$result = true;
    if ($table == 0) {
		$idClasse['classe'] = strtoupper($idClasse['classe']);
		$idClasse['coordinatore'] = ucfirst(strtolower($idClasse['coordinatore']));
        $query = "UPDATE crud_classi SET classe='".$idClasse['classe']."', coordinatore='".$idClasse['coordinatore']."' WHERE id='".$idClasse['id']."'";
		// echo $query;
		if (!$mysqli->query($query)) {
			echo "ERRORE\nClasse gia' presente";
			unset($result);
		}
    }
    else {
        // aggiungo
        
    }
    if (isset($result)) {
        echo "YES";
     } 
?>