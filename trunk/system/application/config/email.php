<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['useragent']		= 'CK';				//The "user agent".
$config['protocol']			= 'mail';			//The mail sending protocol(mail, sendmail, or smtp).
$config['mailpath']			= '/var/qmail';		//The server path to Sendmail.
$config['smtp_host']		= 'localhost';		//SMTP Server Address.
$config['smtp_user']		= 'mailuser';		//SMTP Username.
$config['smtp_pass']		= 'mailpwd';		//SMTP Password.
$config['smtp_port']		= 25;				//SMTP Port.
$config['smtp_timeout']		= 5;				//SMTP Timeout (in seconds).
$config['wordwrap']			= TRUE;				//Enable word-wrap(TRUE or FALSE (boolean)).
$config['wrapchars']		= 76;				//Character count to wrap at.
$config['mailtype']			= 'text';			//Type of mail(text or html). If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
$config['charset']			= 'iso-8859-1';		//Character set (utf-8, iso-8859-1, etc.).
$config['validate']			= FALSE;			//Whether to validate the email address(TRUE or FALSE (boolean)).
$config['priority']			= 3;				//Email Priority(1, 2, 3, 4, 5). 1 = highest. 5 = lowest. 3 = normal.
$config['crlf']				= "\n";				//"\r\n" or "\n" or "\r" 	Newline character. (Use "\r\n" to comply with RFC 822).
$config['newline']			= "\n";				//"\r\n" or "\n" or "\r"	Newline character. (Use "\r\n" to comply with RFC 822).
$config['bcc_batch_mode']	= FALSE;			//Enable BCC Batch Mode(TRUE or FALSE (boolean)).
$config['bcc_batch_size']	= 200;				//Number of emails in each BCC batch.
?>