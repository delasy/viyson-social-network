<?php
function format_email($info, $format){
	$root = $_SERVER['DOCUMENT_ROOT'].'/includes/';	
	$template = file_get_contents($root.'/signup_template.'.$format);
	
	$template = preg_replace('{USERNAME}', $info['username'], $template);
	$template = preg_replace('{EMAIL}', $info['email'], $template);
	$template = preg_replace('{KEY}', $info['key'], $template);
	
	$template = preg_replace('{SITEPATH}','viyson.hol.es', $template);
	return $template;
}
function send_email($info){		
	$body = format_email($info,'html');
	$body_plain_txt = format_email($info,'txt');
	$transport = Swift_MailTransport::newInstance();
	$mailer = Swift_Mailer::newInstance($transport);
	$message = Swift_Message::newInstance();
	
	$message ->setSubject('Welcome to ViYSoN!');
	$message ->setFrom(array('root@viyson.hol.es' => 'ViYSoN'));
	
	$message ->setTo(array($info['email'] => $info['username']));	
	$message ->setBody($body_plain_txt);
	$message ->addPart($body, 'text/html');			
	$result = $mailer->send($message);	
	return $result;	
}