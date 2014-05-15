<?php

if (isset($_POST["update"]))
  list ($g_success, $g_message) = swift_update_settings($_POST);

$settings = ft_get_module_settings();

$remember_advanced_settings = false;
if (isset($_SESSION["ft"]["swift_mailer"]["remember_advanced_settings"]))
  $remember_advanced_settings = $_SESSION["ft"]["swift_mailer"]["remember_advanced_settings"];

$page_vars = array();
$page_vars["page"] = $page;
$page_vars["tabs"] = $tabs;
$page_vars["remember_advanced_settings"] = $remember_advanced_settings;
$page_vars["sm_settings"] = $settings;
$page_vars["text_settings_desc"] = ft_eval_smarty_string($L["ft_eval_smarty_string"], array("php_version"=> phpversion()));
$page_vars["head_js"] =<<<EOF
var rules = [];
rules.push("if:swiftmailer_enabled=yes,required,smtp_server,{$L["validation_no_smtp_server"]}");
rules.push("if:requires_authentication=yes,required,username,{$L["validation_no_username"]}");
rules.push("if:requires_authentication=yes,required,password,{$L["validation_no_password"]}");
rules.push("if:requires_authentication=yes,required,authentication_procedure,{$L["validation_no_authentication_procedure"]}");
rules.push("if:use_encryption=yes,required,encryption_type,{$L["validation_no_encryption_type"]});

var page_ns = {};
page_ns.toggle_enabled_fields = function(is_checked)
{
  $('smtp_server').disabled = !is_checked;
  $('port').disabled = !is_checked;
}

page_ns.toggle_authentication_fields = function(is_checked)
{
  $('username').disabled = !is_checked;
  $('password').disabled = !is_checked;
  $('ap1').disabled = !is_checked;
  $('ap2').disabled = !is_checked;
  $('ap3').disabled = !is_checked;
}

page_ns.toggle_encryption_fields = function(is_checked)
{
  $('et1').disabled = !is_checked;
  $('et2').disabled = !is_checked;
}

page_ns.toggle_antiflooding_fields = function(is_checked)
{
  $('anti_flooding_email_batch_size').disabled = !is_checked;
  $('anti_flooding_email_batch_wait_time').disabled = !is_checked;
}

page_ns.toggle_advanced_settings = function()
{
  var display_setting = $('advanced_settings').getStyle('display');
  var is_visible = false;

  if (display_setting == 'none')
  {
    Effect.BlindDown($('advanced_settings'));
    is_visible = true;
  }
  else
    Effect.BlindUp($('advanced_settings'));

  var page_url = g.root_url + "/modules/swift_mailer/actions.php";
  new Ajax.Request(page_url, {
    parameters: { action: "remember_advanced_settings", remember_advanced_settings: is_visible },
    method: 'post'
  });

	return false;
}
EOF;

ft_display_module_page("templates/index.tpl", $page_vars);