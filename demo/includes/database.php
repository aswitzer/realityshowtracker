<?php
mysql_connect ("localhost", "username", "password") or die ('Could not connect to the database because: ' . mysql_error());
mysql_select_db ("database_name");
?>