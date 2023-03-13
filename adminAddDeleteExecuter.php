<?php

if (isset($_POST['postID']) && isset($_POST['user_id']) && isset($_POST['role'])) {
    include_once('config\dbFunc.class.php');

    $db = new dbFunc();

    $db = $db->dbConn();


    $is_executer = pg_query($db, " SELECT id, idea_id, user_id, role, role_date FROM public.inc_executors WHERE idea_id = ".$_POST['postID']. "and user_id = ". $_POST['user_id']. ";");

    if (pg_num_rows($is_executer) > 0){
    
        $res_update_executer = pg_query($db, "UPDATE public.inc_executors SET role= " . $_POST['role'] . ", role_date='" . date('d.m.Y H:i:s') . "' WHERE user_id = " . $_POST['user_id'] . "and idea_id =" .  $_POST['postID']);
    }else{
        $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM public.inc_executors"));
        $res_update_executer = pg_query($db, "INSERT INTO public.inc_executors(id, idea_id, user_id, role, role_date)VALUES (" . $count[0] . ", " . $_POST['postID'] . ", " . $_POST['user_id'] . ", 3, '" . date('d.m.Y H:i:s') . "');");
    }

}
