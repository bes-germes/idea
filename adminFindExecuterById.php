<?php

if (isset($_POST['id_student'])) {
    include_once('config\dbFunc.class.php');

    $db = new dbFunc();

    $db = $db->dbConn();

        $res_students_names = pg_query($db, "SELECT first_name, middle_name, last_name FROM public.students where id =" . $_POST['id_student']);

        $bebeebe = pg_fetch_assoc($res_students_names);
        
        echo $bebeebe['first_name'] . " " .$bebeebe['middle_name'] . " ". $bebeebe['last_name'] ;
}
