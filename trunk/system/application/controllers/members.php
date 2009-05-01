<?php

class Members extends Controller {

    function Members()
    {
        parent::Controller();
    	$this->load->library('email');
    	$this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->smarty->assign('bigheader', true);
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    function signup()
    {
        $submitjs = "document.signupform.password1.value=SHA1(document.signupform.password1.value);".
                    "document.signupform.password2.value=SHA1(document.signupform.password2.value)";
        $form = array(
            'formOpen'      => form_open('members/signup', array('name'=>'signupform', 'onsubmit'=>$submitjs)),
            'usernameLabel' => form_label('Email address', 'username', array('class'=>'style16')),
            'usernameBox'   => form_input('username', set_value('username'), "class='med-field'"),
            'password1Label'=> form_label('Password', 'password1', array('class'=>'style16')),
            'password1Box'  => form_password('password1', null, "class='med-field'"),
            'password2Label'=> form_label('Retype Password', 'password2', array('class'=>'style16')),
            'password2Box'  => form_password('password2', null, "class='med-field'"),
            'mobileLabel'   => form_label('Mobile', 'mobile', array('class'=>'style16')),
            'mobileBox'     => form_input('mobile', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Signup'),
            'formClose'     => form_close()
        );
        $rules = array(
        	array('field'=>'username' , 'label'=>'Username', 'rules'=>'trim|required|valid_email|max_length[255]'),
        	array('field'=>'password1', 'label'=>'Password', 'rules'=>'trim|required|exact[32]'),
        	array('field'=>'password2', 'label'=>'Retype Password', 'rules'=>'trim|required|matches[password1]'),
        	array('field'=>'mobile'   , 'label'=>'Mobile'  , 'rules'=>'trim|required|exact[10]|is_natural')
        );
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run())
        {
        	try 
        	{
            	$userId = User::create_user($this->input->post('username'), $this->input->post('mobile'), $this->input->post('password1'));
				$user = User::getUserByUserId($userId);

   		   		$this->smarty->assign('user', $user);
     			$this->email->from('support@collegekhabri.com', 'College Khabri Support');
 				$this->email->to($user->emailAddress());
 				$this->email->bcc('support@collegekhabri.com');
 				$this->email->subject('Your new College Khabri Account: Activation pending.');
 				$this->email->message($this->smarty->fetch('email_payment_details.tpl'));
 				$this->email->send();
            	$this->activation();
            	return;
        	}
        	catch(Exception $e)
        	{
        		$form['formErrors'] = 'Account could not be created!';
        	}
        }
        else $form['formErrors'] = validation_errors();

        $this->smarty->assign('signupForm', $form);
        $this->smarty->assign('template', 'signup.html');
        $this->smarty->display('template.html');
    }

    function activation($username = null, $code = null)
    {
        if (!is_null($username) and !is_null($code))
    	{
    		try
    		{
    			$user = User::getUserByUsername($username);
    			$user->activate($code);
    			$this->profile();
    			return;
    		}
    		catch (Exception $e)
    		{
    			$form['formErrors'] = "Could not activate account.";
    		} 
    	}
    	
    	$form = array(
            'formOpen'      => form_open('members/activation'),
            'usernameLabel' => form_label('College Khabri username (your email address)', 'username', array('class'=>'style16')),
            'usernameBox'   => form_input('username', null, "class='med-field'"),
            'codeLabel' 	=> form_label('Your Activation Code', 'code', array('class'=>'style16')),
            'codeBox'   	=> form_input('code', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Activate my account'),
            'formClose'     => form_close()
        );
    	
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|max_length[255]');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|exact[10]');

        if ($this->form_validation->run())
        {
    		$user = User::getUserByUsername($username);
    		$user->activate($code);
    		$this->profile();
    		return;
        }
        else $form['formErrors'] = validation_errors();

    	$this->smarty->assign('template', 'activation.html');
        $this->smarty->display('template.html');
    }
    
    function login()
    {
        $loginform = array(
            'formOpen'      => form_open('members/login', array('name'=>'loginform', 'onsubmit'=>'document.loginform.password.value=SHA1(document.loginform.password.value)')),
            'usernameLabel' => form_label('College Khabri username (your email address)', 'username', array('class'=>'style16')),
            'usernameBox'   => form_input('username', null, "class='med-field'"),
            'passwordLabel' => form_label('Your Password', 'password', array('class'=>'style16')),
            'passwordBox'   => form_password('password', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Login'),
            'formClose'     => form_close()
        );
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run())
        {
        	try
        	{
        		$user = User::getUserByAuthentication($this->input->post('username'), $this->input->post('password'));
	            if ($user->status() == 'registered')
	            {
	            	$this->activation();
	            }
	            else
	            {
	        		$this->profile();
	            }
				return;
        	}
        	catch(Exception $e)
        	{
        		$loginform['formErrors'] = 'Invalid username or password';
        	}
        }
        else $loginform['formErrors'] = validation_errors();

        $forgotform = array(
            'formOpen'      => form_open('members/forgot_password'),
            'usernameLabel' => form_label('College Khabri Username:', 'username', array('class'=>'style16')),
            'usernameBox'   => form_input('username'),
            'submit'        => form_submit('submit', 'Send me my password'),
            'formClose'     => form_close()
        );
        $this->smarty->assign('loginForm', $loginform);
        $this->smarty->assign('forgotForm', $forgotform);
        $this->smarty->assign('template', 'login.html');
        $this->smarty->display('template.html');
    }
    
    function profile()
    {
    	$this->smarty->display('profile.html');
    	
    }

    function forgot_password()
    {
         $form = array(
            'formOpen'      => form_open('members/forgot_password'),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username', set_value('username')),
            'submit'        => form_submit('submit', 'Reset my password!'),
            'formClose'     => form_close()
        );       
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|max_length[255]');

        if ($this->form_validation->run())
        {
            try
            {
            	$user = User::getUserByAuthentication($this->input->post('username'), $this->input->post('password'));
	            $newpassword = $user->reset_password();
   		   		$this->smarty->assign('user', $user);
   		   		$this->smarty->assign('new_password', $newpassword);
     			$this->email->from('support@collegekhabri.com', 'College Khabri Support');
 				$this->email->to($user->emailAddress());
 				$this->email->bcc('support@collegekhabri.com');
 				$this->email->subject('Your new College Khabri Account: Activation pending.');
 				$this->email->message($this->smarty->fetch('email_payment_details.tpl'));
 				$this->email->send();
 				$this->smarty->assign('pwdreset', 1);
 				$this->smarty->assign('template', 'forgotpassword.html');
        		$this->smarty->display('template.html');
            	return;
            }
            catch(Exception $e)
            {
            	$form['formErrors'] = 'Invalid email address provided.';
            }
        }
        else $form['formErrors'] = validation_errors();

        $this->smarty->assign('resetPwdForm', $form);
        $this->smarty->assign('template', 'forgotpassword.html');
        $this->smarty->display('template.html');
    }

    function refer_friends()
    {
        $this->load->library('openinviter');
        $form = array(
            'formOpen'      => form_open('members/refer_friends'),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username'),
            'passwordLabel' => form_label('Password', 'password'),
            'passwordBox'   => form_input('password'),
            'serviceLabel'  => form_dropdown('Service', 'service'),
            'serviceSelect' => form_dropdown('service', $providers),
            'submit'        => form_submit('submit', 'Reset my password!'),
            'formClose'     => form_close()
        );
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run())
        {
            //do something
        }
        else $form['formErrors'] = validation_errors();

        $this->smarty->assign('referForm', $form);
        $this->smarty->assign('template', 'forgotpassword.html');
        $this->smarty->display('template.html');
    }
    
    function feedback()
    {
    	
    }
}

/* End of file members.php */
/* Location: ./system/application/controllers/members.php */