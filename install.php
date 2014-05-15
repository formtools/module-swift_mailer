<?php

/**
 * The Export Manager installation function. This is automatically called by Form Tools on installation.
 */
function swift_mailer__install($module_id)
{
  global $g_table_prefix;

  $queries[] = "
		INSERT INTO {$g_table_prefix}settings (setting_name, setting_value, module)
		VALUES (
		  ";

  foreach ($queries as $query)
  {
  	$result = mysql_query($query);
  }

  return array(true, "");
}
