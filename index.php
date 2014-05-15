<?php

require_once("../../global/library.php");
ft_init_module_page();

$folder = dirname(__FILE__);
require_once("$folder/library.php");

$page = ft_load_module_field("swift_mailer", "page", "tab", "settings");

// define the Image Manager tabs
$tabs = array(
  "settings" => array(
      "tab_label" => $LANG["word_settings"],
      "tab_link" => "{$_SERVER["PHP_SELF"]}?page=settings"
        ),
  "test" => array(
      "tab_label" => $L["word_test"],
      "tab_link" => "{$_SERVER["PHP_SELF"]}?page=test"
        ),
    );

// ------------------------------------------------------------------------------------------------

// load the appropriate code page
switch ($page)
{
	case "settings":
		require("tab_settings.php");
		break;
	case "test":
		require("tab_test.php");
		break;
	default:
		require("tab_settings.php");
		break;
}