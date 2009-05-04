<?php

class Members extends Controller {

    function Members()
    {
        parent::Controller();
    	$this->load->library('email');
    	$this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->smarty->assign('titlelink', $this->session->userdata('firstName'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    function signup()
    {
        $submitjs = "document.signupform.password1.value=SHA1(document.signupform.password1.value);".
                    "document.signupform.password2.value=SHA1(document.signupform.password2.value)";
        $fieldFx = "class='med-field' onfocus=\"getElementById(this.name+'-context').style.visibility='visible'\" onblur=\"getElementById(this.name+'-context').style.visibility='hidden'\"";
        $form = array(
            'formOpen'      => form_open('members/signup', array('name'=>'signupform', 'onsubmit'=>$submitjs)),
            'usernameLabel' => form_label('Email address', 'username', array('class'=>'medium-text')),
            'usernameBox'   => form_input('username', set_value('username'), $fieldFx),
            'password1Label'=> form_label('Password', 'password1', array('class'=>'medium-text')),
            'password1Box'  => form_password('password1', null, $fieldFx),
            'password2Label'=> form_label('Retype Password', 'password2', array('class'=>'medium-text')),
            'password2Box'  => form_password('password2', null, $fieldFx),
            'mobileLabel'   => form_label('Mobile', 'mobile', array('class'=>'medium-text')),
            'mobileBox'     => form_input('mobile', null, $fieldFx),
            'submit'        => form_submit('submit', 'Send me the activation code'),
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
				$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName()));
				$this->smarty->assign('titlelink', $this->session->userdata('firstName'));

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
    	if(is_null($username) and $this->session->userdata('userId'))
    	{
    		$user = User::getUserByuserId($this->session->userdata('userId'));
    	}
    	else
    	{
    		$user = User::getUserByUsername($username);
    	}

    	$form = array(
            'formOpen'      => form_open('members/activation'),
            'codeLabel' 	=> form_label('Your Activation Code', 'code', array('class'=>'medium-text v-thin-line')),
            'codeBox'   	=> form_input('code', null, "class='med-field'"),
	    	'fNameLabel' 	=> form_label('First Name', 'fname', array('class'=>'medium-text v-thin-line')),
            'fNameBox'   	=> form_input('fname', null, "class='med-field'"),
	    	'lNameLabel' 	=> form_label('Surname', 'lname', array('class'=>'medium-text v-thin-line')),
            'lNameBox'   	=> form_input('lname', null, "class='med-field'"),
	    	'categoryLabel'	=> form_label('Your category', 'category', array('class'=>'medium-text v-thin-line')),
            'categorySelect'=> form_dropdown('category', array(), "class='med-field'"),
	    	'mhtAppNoLabel'	=> form_label('MHT-CET application number', 'mhtcetAppNo', array('class'=>'medium-text v-thin-line')),
            'mhtAppNoBox'  	=> form_input('mhtcetAppNo', null, "class='med-field'"),
	    	'pCETScoreLabel'=> form_label('Projected CET score', 'pCETScore', array('class'=>'medium-text v-thin-line')),
            'pCETScoreBox'  => form_input('pCETScore', null, "class='med-field'"),
	    	'pCETRankLabel' => form_label('Projected CET rank', 'pCETRank', array('class'=>'medium-text v-thin-line')),
            'pCETRankBox'   => form_input('pCETRank', null, "class='med-field'"),
	    	'ai3eAppNoLabel'=> form_label('AIEEE application number', 'ai3eAppNo', array('class'=>'medium-text v-thin-line')),
            'ai3eAppNoBox' 	=> form_input('ai3eAppNo', null, "class='med-field'"),
        	'pAI3EScoreLabel'=> form_label('Projected AIEEE score', 'pAI3EScore', array('class'=>'medium-text v-thin-line')),
            'pAI3EScoreBox' => form_input('pAI3EScore', null, "class='med-field'"),
	    	'pAI3ERankLabel'=> form_label('Projected AIEEE rank', 'pAI3ERank', array('class'=>'medium-text v-thin-line')),
            'pAI3ERankBox'  => form_input('pAI3ERank', null, "class='med-field'"),
        	'submit'        => form_submit('submit', 'Activate my account'),
            'formClose'     => form_close()
        );
    	
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|max_length[255]');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|exact[10]');

        if (!is_null($code) or $this->form_validation->run())
        {
    		$user->activate($code);
    		return;
        }
        else $form['formErrors'] = validation_errors();

	    $this->smarty->assign('user', $user);
	    $this->smarty->assign('activationForm', $form);
	    $this->smarty->assign('template', 'activation.html');
        $this->smarty->display('template.html');
    }
    
    function login()
    {
        $loginform = array(
            'formOpen'      => form_open('members/login', array('name'=>'loginform', 'onsubmit'=>'document.loginform.password.value=SHA1(document.loginform.password.value)')),
            'usernameLabel' => form_label('College Khabri username (your email address)', 'username', array('class'=>'medium-text')),
            'usernameBox'   => form_input('username', null, "class='med-field'"),
            'passwordLabel' => form_label('Your Password', 'password', array('class'=>'medium-text')),
            'passwordBox'   => form_password('password', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Login', "class='medium-button'"),
            'formClose'     => form_close()
        );
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run())
        {
        	try
        	{
        		$user = User::getUserByAuthentication($this->input->post('username'), $this->input->post('password'));
        		$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName()));
        		$this->smarty->assign('titlelink', $this->session->userdata('firstName'));
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
            'usernameLabel' => form_label('College Khabri Username:', 'username', array('class'=>'medium-text')),
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
        if (!$this->session->userdata('userId'))
        {
        	redirect('/members/login');
        	return;
        }

        $this->load->model('search');
        $this->smarty->assign('searchForm', Search::search_form());
        $this->smarty->assign('template', 'profile.html');
    	$this->smarty->display('template3column.html');
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

    function logout()
    {
		$this->session->unset_userdata(array('userId'=>'', 'firstName'=>''));
    }
    
    function savedsearches()
    {
    	$this->smarty->assign('template', 'savedsearches.html');
    	$this->smarty->display('template.html');     
    }
}

/* End of file members.php */
/* Location: ./system/application/controllers/members.php */