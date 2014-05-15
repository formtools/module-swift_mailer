<?php

if (isset($_POST["update"]))
  list ($g_success, $g_message) = swift_update_settings($_POST);

$settings = ft_get_module_settings();

$page_vars = array();
$page_vars["page"] = $page;
$page_vars["tabs"] = $tabs;
$page_vars["sm_settings"] = $settings;
$page_vars["php_version"] = phpversion();
$page_vars["head_js"] = "
var rules = [];
rules.push(\"required,swiftmailer_enabled,Please indicate whether the Swift Mailer module is enabled or not.\");
rules.push(\"if:swiftmailer_enabled=yes,required,smtp_server,Please enter the SMTP server name.\");
rules.push(\"if:swiftmailer_enabled=yes,required,port,Please enter the port number.\");
rules.push(\"if:swiftmailer_enabled=yes,required,requires_authentication,Please indicate whether the server requires user authentication or not.\");
rules.push(\"if:swiftmailer_enabled=yes,if:requires_authentication=yes,required,username,Please enter the SMTP username.\");
rules.push(\"if:swiftmailer_enabled=yes,if:requires_authentication=yes,required,password,Please enter the SMTP password.\");
rules.push(\"if:swiftmailer_enabled=yes,if:requires_authentication=yes,required,authentication_procedure,Please indicate the authentication procedure.\");


var page_ns = {};
page_ns.toggle_authentication_fields = function(requires_authentication)
{
  var is_disabled = (requires_authentication == \"yes\") ? false : true;

  $('username').disabled = is_disabled;
  $('password').disabled = is_disabled;
  $('ap1').disabled = is_disabled;
  $('ap2').disabled = is_disabled;
  $('ap3').disabled = is_disabled;
}
";

ft_display_module_page("templates/index.tpl", $page_vars);