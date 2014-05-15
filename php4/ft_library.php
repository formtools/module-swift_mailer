<?php

$g_swift_error = "";

function swift_php_ver_send_test_email($settings, $info)
{
  global $L, $g_swift_error;

  $smtp_server = $settings["smtp_server"];
  $port        = $settings["port"];

	// default return values (optimistic, huh?)
  $success = true;
  $message = "The email was successfully sent.";

  $old_error_handler = set_error_handler("swift_error_handler");

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

	if (!empty($g_swift_error))
	{
	  return array(false, "There was a problem sending the test email: " . $g_swift_error);
	}
	
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

	if (!empty($g_swift_error))
	{
	  return array(false, "There was a problem sending the test email: " . $g_swift_error);
	}

	restore_error_handler();
	
  return array($success, $message);
}


function swift_error_handler($errno, $errstr, $errfile, $errline)
{
  global $g_swift_error;

  switch ($errno)
	{
    case E_USER_ERROR:
  		$g_swift_error = "[$errno] $errstr<Br />
                        Fatal error on line $errline in file $errfile";
      break;
/*
    case E_USER_WARNING:
  		$g_swift_error = "<b>WARNING</b> [$errno] $errstr";
      break;
    
    case E_USER_NOTICE:
  		$g_swift_error = "<b>NOTICE</b> [$errno] $errstr";		
      break;
    
    default:
  		$g_swift_error = "[$errno] $errstr";
      break;		
*/	
  }

  // don't execute PHP internal error handler
  return true;	
}
