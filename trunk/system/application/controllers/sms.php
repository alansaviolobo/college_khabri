<?php

class Sms extends Controller {

    function Sms()
    {
        parent::Controller();
    }

    function register()
    {
    	$phone = $this->input->get('PhNo');
    	$key = $this->input->get('Key');
    	$phrase = $this->input->get('Phrase');
    	$param = $this->input->get('param');
    	$message = $this->input->get('FullMsg');

    	if (strtolower($key) <> 'khabri')
    	{
    		echo 'You have reached the wrong place!';
			return;
    	}

    	$message = substr($message, strlen($key)+1);
    	$msgparts = explode(',', $message);
    	if(count($msgparts)<4) $msgparts = explode(' ', $message);
    	$cetappno = '';
    	for($count=0; strlen($msgparts[$count].$cetappno)<=9; $count++)
    	{
    		$cetappno .= $msgparts[$count]; 
    		unset($msgparts[$count]);
    	}
    	$city = $msgparts[max(array_keys($msgparts))];
    	unset($msgparts[max(array_keys($msgparts))]);
    	$email = $msgparts[max(array_keys($msgparts))];
    	unset($msgparts[max(array_keys($msgparts))]);
    	list($firstname, $lastname) = array_values($msgparts);
    	$password = substr(md5($email),5,10);

    	$this->load->model('user');
    	$user_id = User::create_user($email, $phone, sha1($password));
    	
    	var_dump( "Thank you for registering with collegekhabri. Your user id is $email,".
    		" your password is $password. Visit www.collegekhabri.com for more information.");
    }
}

/* End of file sms.php */
/* Location: ./system/application/controllers/sms.php */