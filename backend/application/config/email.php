<?php
$config['protocol'] = 'sendmail';
$config['smtp_host'] = 'smtp.hostinger.com'; //change this
$config['smtp_crypto']  = 'tls';
$config['smtp_port'] = '465';
$config['smtp_user'] = 'support@payrollease.in'; //change this // also please do change in constants.php -- MAIL_SENDER
$config['smtp_pass'] = 'P@$$w0rd123'; //change this
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
