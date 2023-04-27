<?php
    require("person.php");
    require("../../db/dbpg.php");
    $_db = new dataBasePG('CONPG');
    $_user = new person($_db,0);
?>