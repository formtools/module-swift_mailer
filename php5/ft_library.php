<?php

function swift_php_ver_send_test_email($settings, $info)
{
  global $L;

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
