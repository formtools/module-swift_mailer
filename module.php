<?php

/**
 * Module file: Swift Mailer
 *
 * This module lets the user enter their server's SMTP settings for Swift Mailer, letting them
 * override the default mail() functionality used by the default script.
 */

$MODULE["author"]          = "Encore Web Studios";
$MODULE["author_email"]    = "formtools@encorewebstudios.com";
$MODULE["author_link"]     = "http://www.encorewebstudios.com";
$MODULE["version"]         = "1.0.0-beta-20081229";
$MODULE["date"]            = "2008-12-29";
$MODULE["origin_language"] = "en_us";
$MODULE["supports_ft_versions"] = "2.0.0";

// define the module navigation - the keys are keys defined in the language file. This lets
// the navigation - like everything else - be customized to the users language
$MODULE["nav"] = array(
  "module_name" => array("index.php", false)
    );