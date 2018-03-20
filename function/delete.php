<?php
    include('../config.php');
    //echo '<script language="javascript">alert("message successfully sent")</script>';
    $table = $_POST['table'];
    $id = $_POST['id'];
    $id = implode(",",$id);
    if ($table == 0) {
        $result = true;

        try {
            $mysqli->begin_transaction();        

            
            $query = "DELETE FROM crud_studenti WHERE idClasse IN ($id)";        
            if (!$mysqli->query($query)) {
                throw new Exception("MySQL error $mysqli->error");
            }
            $query = "DELETE FROM crud_classi WHERE id IN ($id)";
            if (!$mysqli->query($query)) {
                throw new Exception("MySQL error $mysqli->error");
            }

            $mysqli->commit();
        } catch (Exception $e) {
            unset($result);
            echo $e;

            $mysqli->rollback();
        }
    }
    else {
        $query = "DELETE FROM crud_studenti WHERE id IN ($id)";
        $result = $mysqli->query($query);
    }
    
    if (isset($result)) {
        echo "YES";
     }
?>