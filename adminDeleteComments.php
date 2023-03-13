<?php
require_once('config/dbFunc.class.php');
        
        $db = new dbFunc();
        $db = $db->dbConn();



if (isset($_POST['idCom'])) {
    $res = pg_query($db, "DELETE FROM public.inc_comment WHERE id =" . $_POST['idCom'] . ";");
    if ($res){
        echo "aaaaaaaaa";
    }else{
        echo "bbbbbbbbb";
    }
}
