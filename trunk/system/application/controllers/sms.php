<?php

class Sms extends Controller {

    function Sms()
    {
        parent::Controller();
        $this->load->model('user');
    	$this->load->library('email');
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
    	list($firstname, $lastname) = array(1=>'')+array_values($msgparts);
    	$password = substr(md5($email),5,5);

		try
		{
    		$user_id = User::create_user($email, $phone, sha1($password));
			$user = User::getUserByUserId($user_id);
   	   		$this->smarty->assign('user', $user);
     		$this->email->from('support@collegekhabri.com', 'College Khabri Support');
 			$this->email->to($user->emailAddress());
 			$this->email->bcc('support@collegekhabri.com');
 			$this->email->subject('Your new College Khabri Account: Activation pending.');
 			$this->email->message($this->smarty->fetch('email_signup_details.tpl'));
 			$this->email->send();
	    	echo "Thank you for registering with collegekhabri. Your user id is $email,".
    			" your password is $password. Visit www.collegekhabri.com for more information.";
		}
		catch (Exception $e)
		{
			echo "user already exists";
		}
    }
}

/* End of file sms.php */
/* Location: ./system/application/controllers/sms.php */