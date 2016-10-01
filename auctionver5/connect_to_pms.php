<?php
	session_start();
    mysql_connect('localhost', 'root') OR DIE (mysql_error());
    mysql_select_db ('pms') OR DIE ("Unable to select db" .mysql_error());
?>