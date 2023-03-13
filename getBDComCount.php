<?php

require_once('config/dbFunc.class.php');
        
        $db = new dbFunc();
        $db = $db->dbConn();
$count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_comment"));
echo $count[0];