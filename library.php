<?php


/**
 * Updates the Swift Mailer settings.
 *
 * @param array $info
 * @return array [0] T/F<br />
 *               [1] Success / error message
 */
function swift_update_settings($info)
{
  global $L;

  $settings = array(
    "swiftmailer_enabled"     => $info["swiftmailer_enabled"],
    "smtp_server"             => $info["smtp_server"],
    "port"                    => $info["port"],
    "requires_authentication" => $info["requires_authentication"]
      );

  if (isset($info["username"]))
    $settings["username"] = $info["username"];
  if (isset($info["password"]))
    $settings["password"] = $info["password"];
  if (isset($info["authentication_procedure"]))
    $settings["authentication_procedure"] = $info["authentication_procedure"];

  ft_set_module_settings($settings);

  return array(true, $L["notify_settings_updated"]);
}


/**
 * Called on the test tab. It sends one of the three test emails: plain text, HTML and multi-part
 * using the SMTP settings configured on the settings tab.
 *
 * @param array $info
 * @return array [0] T/F<br />
 *               [1] Success / error message
 */
function swift_send_test_email($info)
{
  global $L;

  // find out what version of PHP we're running
  $version = phpversion();
  $version_parts = explode(".", $version);

  $main_version = $version_parts[0];

  if ($main_version == "5")
    $php_version_folder = "php5";
  else
    return array(false, $L["notify_php_version_not_found_or_invalid"]);


  // include the main files
  $current_folder = dirname(__FILE__);
  require_once("$current_folder/$php_version_folder/Swift.php");
  require_once("$current_folder/$php_version_folder/Swift/Connection/SMTP.php");


  $settings = ft_get_module_settings();

  // if we're requiring authentication, include the appropriate authenticator file
  if ($settings["requires_authentication"] == "yes")
  {
    switch ($settings["authentication_procedure"])
    {
      case "LOGIN":
        require_once("$current_folder/$php_version_folder/Swift/Authenticator/LOGIN.php");
        break;
      case "PLAIN":
        require_once("$current_folder/$php_version_folder/Swift/Authenticator/PLAIN.php");
        break;
      case "CRAMMD5":
        require_once("$current_folder/$php_version_folder/Swift/Authenticator/CRAMMD5.php");
        break;
    }
  }

  $smtp_server = $settings["smtp_server"];
  $port        = $settings["port"];

  $success = true;
  $message = "The email was successfully sent.";

  try {
    if (empty($port))
      $smtp =& new Swift_Connection_SMTP($smtp_server);
    else
      $smtp =& new Swift_Connection_SMTP($smtp_server, $port);

    if ($settings["requires_authentication"] == "yes")
    {
      $smtp->setUsername($settings["username"]);
      $smtp->setPassword($settings["password"]);
    }

    $swift =& new Swift($smtp);

    // now send the appropriate email
    switch ($info["test_email_format"])
    {
      case "text":
        $email =& new Swift_Message($L["phrase_test_plain_text_email"], "Plain text email successfully sent.");
        break;
      case "html":
        $email =& new Swift_Message($L["phrase_test_html_email"], "<b>HTML</b> email successfully sent.", "text/html");
        break;
      case "multipart":
        $email =& new Swift_Message($L["phrase_test_multipart_email"]);
        $email->attach(new Swift_Message_Part("Multipart email (text portion)"));
        $email->attach(new Swift_Message_Part("Multipart email (<b>HTML</b> portion)", "text/html"));
        break;
    }

    $swift->send($email, $info["recipient_email"], $info["from_email"]);
  }
  catch (Swift_ConnectionException $e)
  {
    $success = false;
    $message = "There was a problem communicating with SMTP: " . $e->getMessage();
  }
  catch (Swift_Message_MimeException $e)
  {
    $success = false;
    $message = "There was an unexpected problem building the email:" . $e->getMessage();
  }

  return array($success, $message);
}


function swift_send_email($email_components)
{
  // find out what version of PHP we're running
  $version = phpversion();
  $version_parts = explode(".", $version);
  $main_version = $version_parts[0];

  if ($main_version == "5")
    $php_version_folder = "php5";
  else
    return array(false, $L["notify_php_version_not_found_or_invalid"]);


  // include the main files
  $current_folder = dirname(__FILE__);
  require_once("$current_folder/$php_version_folder/Swift.php");
  require_once("$current_folder/$php_version_folder/Swift/Connection/SMTP.php");


  $settings = ft_get_module_settings("", "swift_mailer");

  // if we're requiring authentication, include the appropriate authenticator file
  if ($settings["requires_authentication"] == "yes")
  {
    switch ($settings["authentication_procedure"])
    {
      case "LOGIN":
        require_once("$current_folder/$php_version_folder/Swift/Authenticator/LOGIN.php");
        break;
      case "PLAIN":
        require_once("$current_folder/$php_version_folder/Swift/Authenticator/PLAIN.php");
        break;
      case "CRAMMD5":
        require_once("$current_folder/$php_version_folder/Swift/Authenticator/CRAMMD5.php");
        break;
    }
  }

  $smtp_server = $settings["smtp_server"];
  $port        = $settings["port"];

  $success = true;
  $message = "The email was successfully sent.";

  if (empty($port))
    $smtp =& new Swift_Connection_SMTP($smtp_server);
  else
    $smtp =& new Swift_Connection_SMTP($smtp_server, $port);

  if ($settings["requires_authentication"] == "yes")
  {
    $smtp->setUsername($settings["username"]);
    $smtp->setPassword($settings["password"]);
  }

  $swift =& new Swift($smtp);

  // now send the appropriate email
  if (!empty($email_components["text_content"]) && !empty($email_components["html_content"]))
  {
    $email =& new Swift_Message($email_components["subject"]);
    $email->attach(new Swift_Message_Part($email_components["text_content"]));
    $email->attach(new Swift_Message_Part($email_components["html_content"], "text/html"));
  }
  else if (!empty($email_components["text_content"]))
    $email =& new Swift_Message($email_components["subject"], $email_components["text_content"]);
  else if (!empty($email_components["html_content"]))
    $email =& new Swift_Message($email_components["subject"], $email_components["html_content"], "text/html");

  // now compile the recipient list
  $recipients =& new Swift_RecipientList();

  foreach ($email_components["to"] as $to)
  {
    if (!empty($to["name"]) && !empty($to["email"]))
      $recipients->addTo($to["email"], $to["name"]);
    else if (!empty($to["email"]))
      $recipients->addTo($to["email"]);
  }

  foreach ($email_components["cc"] as $cc)
  {
    if (!empty($cc["name"]) && !empty($cc["email"]))
      $recipients->addCc($cc["email"], $cc["name"]);
    else if (!empty($cc["email"]))
      $recipients->addCc($cc["email"]);
  }

  foreach ($email_components["bcc"] as $bcc)
  {
    if (!empty($bcc["name"]) && !empty($bcc["email"]))
      $recipients->addBcc($bcc["email"], $bcc["name"]);
    else if (!empty($bcc["email"]))
      $recipients->addBcc($bcc["email"]);
  }

  if (!empty($email_components["from"]["name"]) && !empty($email_components["from"]["email"]))
    $from =	new Swift_Address($email_components["from"]["email"], $email_components["from"]["name"]);
  else if (!empty($bcc["email"]))
    $from =	new Swift_Address($email_components["from"]["email"]);

  if (!empty($email_components["from"]["name"]) && !empty($email_components["from"]["email"]))
    $from =	new Swift_Address($email_components["from"]["email"], $email_components["from"]["name"]);
  else if (!empty($bcc["email"]))
    $from =	new Swift_Address($email_components["from"]["email"]);

  $swift->send($email, $recipients, $from);


  return array($success, $message);
}