<?php

if (isset($_POST["send"]))
  list($g_success, $g_message) = swift_send_test_email($_POST);

$settings = ft_get_module_settings();
$test_email_format = ft_load_module_field("swift_mailer", "test_email_format", "test_email_format", "text");
$recipient_email   = ft_load_module_field("swift_mailer", "recipient_email", "recipient_email", $_SESSION["ft"]["account"]["email"]);
$from_email        = ft_load_module_field("swift_mailer", "from_email", "from_email", $_SESSION["ft"]["account"]["email"]);

$page_vars = array();
$page_vars["page"] = $page;
$page_vars["tabs"] = $tabs;
$page_vars["test_email_format"] = $test_email_format;
$page_vars["recipient_email"] = $recipient_email;
$page_vars["from_email"] = $from_email;
$page_vars["sm_settings"] = $settings;
$page_vars["php_version"] = phpversion();
$page_vars["js"] = "
var rules = [];
rules.push(\"required,email_recipient,Please enter the recipient email address.\");
rules.push(\"required,email_from,Please enter the email address of the sender.\");
";

ft_display_module_page("templates/index.tpl", $page_vars);