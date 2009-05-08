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
        $submitjs = "if (document.signupform.password1.value) document.signupform.password1.value=SHA1(document.signupform.password1.value);".
                    "if (document.signupform.password2.value) document.signupform.password2.value=SHA1(document.signupform.password2.value)";
        $fieldFx = "class='med-field' onfocus=\"getElementById(this.name+'-context').style.visibility='visible'\" onblur=\"getElementById(this.name+'-context').style.visibility='hidden'\"";
        $form = array(
            'formOpen'      => form_open('members/signup', array('name'=>'signupform', 'onsubmit'=>$submitjs)),
            'usernameLabel' => form_label('Email address', 'username', array('class'=>'medium-text')),
            'usernameBox'   => form_input('username', $this->input->post('username'), $fieldFx),
            'password1Label'=> form_label('Password', 'password1', array('class'=>'medium-text')),
            'password1Box'  => form_password('password1', null, $fieldFx),
            'password2Label'=> form_label('Retype Password', 'password2', array('class'=>'medium-text')),
            'password2Box'  => form_password('password2', null, $fieldFx),
            'mobileLabel'   => form_label('Mobile', 'mobile', array('class'=>'medium-text')),
            'mobileBox'     => form_input('mobile', $this->input->post('mobile'), $fieldFx),
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
            	$user_id = User::create_user($this->input->post('username'), $this->input->post('mobile'), $this->input->post('password1'));
				$user = User::getUserByUserId($user_id);
				$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName()));
				$this->smarty->assign('titlelink', $this->session->userdata('firstName'));

   		   		$this->smarty->assign('user', $user);
     			$this->email->from('support@collegekhabri.com', 'College Khabri Support');
 				$this->email->to($user->emailAddress());
 				$this->email->bcc('support@collegekhabri.com');
 				$this->email->subject('Your new College Khabri Account: Activation pending.');
 				$this->email->message($this->smarty->fetch('email_signup_details.tpl'));
 				$this->email->send();
 				//echo $this->email->print_debugger();
            	redirect("members/activation/$user_id");
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

    function activation($user_id)
    {
    	if (is_null($user_id) and !$this->session->userdata('userId'))
    	{
    		redirect('/members/login');
        	return;
    	}
    	
    	if(is_null($user_id) and $this->session->userdata('userId'))
    	{
    		$user_id = $this->session->userdata('userId');
    	}
    	else
    	{
    		$this->session->set_userdata(array('userId'=>$user_id));
    	}
    	
    	$user = User::getUserByUserId($user_id);
    	if ($user->status() <> 'registered')
    	{
    		redirect('/members/login');
        	return;
    	}

		$this->load->model('university');
    	
    	$form = array(
            'formOpen'      => form_open("members/activation/$user_id"),
            'codeLabel' 	=> form_label('Your Activation Code', 'code', array('class'=>'medium-text v-thin-line')),
            'codeBox'   	=> form_input('code', null, "class='med-field'"),
	    	'fNameLabel' 	=> form_label('First Name', 'fname', array('class'=>'medium-text v-thin-line')),
            'fNameBox'   	=> form_input('fname', $this->input->post('fname'), "class='med-field'"),
	    	'lNameLabel' 	=> form_label('Surname', 'lname', array('class'=>'medium-text v-thin-line')),
            'lNameBox'   	=> form_input('lname', $this->input->post('lname'), "class='med-field'"),
	    	'homeUniLabel'	=> form_label('Home University', 'homeUni', array('class'=>'medium-text v-thin-line')),
            'homeUniSelect'	=> form_dropdown('homeUni', array('' => 'None') + University::getUniversities(), $this->input->post('homeUni'), "class='med-field'"),
    	   	'categoryLabel'	=> form_label('Your category', 'category', array('class'=>'medium-text v-thin-line')),
            'categorySelect'=> form_dropdown('category', User::getStatuses(), $this->input->post('category'), "class='med-field'"),
	    	'mhtAppNoLabel'	=> form_label('MHT-CET application number', 'cetAppNo', array('class'=>'medium-text v-thin-line')),
            'mhtAppNoBox'  	=> form_input('cetAppNo', $this->input->post('cetAppNo'), "class='med-field'"),
	    	'pCETScoreLabel'=> form_label('Projected CET score', 'pCETScore', array('class'=>'medium-text v-thin-line')),
            'pCETScoreBox'  => form_input('pCETScore', $this->input->post('pCETScore'), "class='med-field'"),
	    	'pCETRankLabel' => form_label('Projected CET rank', 'pCETRank', array('class'=>'medium-text v-thin-line')),
            'pCETRankBox'   => form_input('pCETRank', $this->input->post('pCETRank'), "class='med-field'"),
	    	'ai3eAppNoLabel'=> form_label('AIEEE application number', 'ai3eAppNo', array('class'=>'medium-text v-thin-line')),
            'ai3eAppNoBox' 	=> form_input('ai3eAppNo', $this->input->post('ai3eAppNo'), "class='med-field'"),
        	'pAI3EScoreLabel'=>form_label('Projected AIEEE score', 'pAI3EScore', array('class'=>'medium-text v-thin-line')),
            'pAI3EScoreBox' => form_input('pAI3EScore', $this->input->post('pAI3EScore'), "class='med-field'"),
	    	'pAI3ERankLabel'=> form_label('Projected AIEEE rank', 'pAI3ERank', array('class'=>'medium-text v-thin-line')),
            'pAI3ERankBox'  => form_input('pAI3ERank', $this->input->post('pAI3ERank'), "class='med-field'"),
        	'submit'        => form_submit('submit', 'Activate my account'),
            'formClose'     => form_close()
        );
    	$rules = array(
        	array('field'=>'code',		'label'=>'Activation code',	'rules'=>'trim|required|exact[10]'),
        	array('field'=>'fname',		'label'=>'First Name',		'rules'=>'trim|required|max_length[255]'),
        	array('field'=>'lname',		'label'=>'Surname',			'rules'=>'trim|required|max_length[255]'),
        	array('field'=>'pCETScore',	'label'=>'CET Score',		'rules'=>'trim|is_natural'),
        	array('field'=>'pCETRank',	'label'=>'CET Rank',		'rules'=>'trim|is_natural'),
        	array('field'=>'pAI3EScore','label'=>'AIEEE Score',		'rules'=>'trim|is_natural'),
        	array('field'=>'pAI3ERank',	'label'=>'AIEEE Rank',		'rules'=>'trim|is_natural'),
        	array('field'=>'cetAppNo',	'label'=>'CET Application No.','rules'=>'trim|required|exact[10]'),
        	array('field'=>'ai3eAppNo',	'label'=>'AIEEE Application No.','rules'=>'trim|required|exact[9]')
    	);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run())
        {
        	try
        	{
	        	$params = array(
	        		'fname' => $this->input->post('fname'),
	        		'lname' => $this->input->post('lname'),
		        	'homeUni' => $this->input->post('homeUni'),
	        		'category' => $this->input->post('category'),
	        		'pCETScore' => $this->input->post('pCETScore'),
		        	'pCETRank' => $this->input->post('pCETRank'),
		        	'pAI3EScore' => $this->input->post('pAI3EScore'),
		        	'pAI3ERank' => $this->input->post('pAI3ERank'),
	        		'cetAppNo' => $this->input->post('cetAppNo'),
	        		'ai3eAppNo' => $this->input->post('ai3eAppNo'));
	    		$user->activate($this->input->post('code'));
	    		$user->update_details($params);
	    		$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName()));
	    		redirect('members/profile');
	    		return;
        	}
        	catch(Exception $e)
        	{
        		$form['formErrors'] = 'Invalid code entered.';
        	}
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
            'formOpen'      => form_open('members/login', array('name'=>'loginform', 'onsubmit'=>'if (document.loginform.password.value) document.loginform.password.value=SHA1(document.loginform.password.value)')),
            'usernameLabel' => form_label('College Khabri username (your email address)', 'username', array('class'=>'medium-text')),
            'usernameBox'   => form_input('username', $this->input->post('username'), "class='med-field'"),
            'passwordLabel' => form_label('Your Password', 'password', array('class'=>'medium-text')),
            'passwordBox'   => form_password('password', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Login', "class='medium-button'"),
            'formClose'     => form_close()
        );
        $rules = array(
        	array('field'=>'username' , 'label'=>'Username', 'rules'=>'trim|required|valid_email|max_length[255]'),
        	array('field'=>'password1', 'label'=>'Password', 'rules'=>'trim|required|exact[40]')
        );
        $this->form_validation->set_rules($rules);
        
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
        $user = User::getUserByUserId($this->session->userdata('userId'));

         $form = array(
            'formOpen'		=> form_open('members/profile'),
            'password1Label'=> form_label('New password:', 'password1'),
            'password1Box'	=> form_input('password1'),
            'password2Label'=> form_label('New password again:', 'password2'),
            'password2Box'	=> form_input('password2'),
            'fnameLabel'	=> form_label('First Name:', 'fname'),
            'fnameBox'		=> form_input('fname'),
            'lnameLabel'	=> form_label('Last Name:', 'lname'),
            'lnameBox'		=> form_input('lname'),
            'ai3eAppLabel'	=> form_label('AIEEE application no:', 'ai3eappno'),
            'ai3eAppBox'	=> form_input('ai3eappno'),
            'ai3eRankLabel'	=> form_label('AIEEE Rank:', 'ai3erank'),
            'ai3eRankBox'	=> form_input('ai3erank'),
            'cetAppLabel'	=> form_label('CET Application no:', 'cetappno'),
            'cetAppBox'		=> form_input('cetappno'),
            'cetRankLabel'	=> form_label('MHTCET Rank:', 'cetrank'),
            'cetRankBox'	=> form_input('cetrank'),
            'submit'		=> form_submit('submit', 'Update my profile'),
            'formClose'		=> form_close()
        );
        $rules = array(
        	array('field'=>'password1' ,'label'=>'Password',		'rules'=>'trim|exact[40]'),
        	array('field'=>'password2', 'label'=>'Retype Password',	'rules'=>'trim|matches[password1]'),
        	array('field'=>'fname', 	'label'=>'First Name',		'rules'=>'trim|required|matches[password1]'),
        	array('field'=>'lname',		'label'=>'Last Name',		'rules'=>'trim|required|matches[password1]'),
        	array('field'=>'ai3eapno',	'label'=>'AIEEE App No',	'rules'=>'trim|required|exact[10]'),
        	array('field'=>'ai3erank',	'label'=>'AIEEE Rank',		'rules'=>'trim|required|matches[password1]'),
        	array('field'=>'cetappno',	'label'=>'CET App No',		'rules'=>'trim|required|exact[9]'),
        	array('field'=>'cetrank',	'label'=>'CET Rank',		'rules'=>'trim|required|matches[password1]'));
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run())
        {
            try
            {
            	$params = array(
            		'password'	=> $this->input->post('password1'),
            		'fname'		=> $this->input->post('fname'),
            		'lname'		=> $this->input->post('lname'),
            		'ai3eappno'	=> $this->input->post('ai3eappno'),
            		'ai3erank'	=> $this->input->post('ai3erank'),
            		'cetappno'	=> $this->input->post('cetappno'),
            		'cetrank'	=> $this->input->post('cetrank'));
            	$user->update_details($params);
        		$this->smarty->display('template.html');
            	return;
            }
            catch(Exception $e)
            {
            	$form['formErrors'] = 'Error updating your details';
            }
        }
        else $form['formErrors'] = validation_errors();

		$this->smarty->assign('user', $user);
        $this->smarty->assign('profileForm', $form);
        $this->smarty->assign('template', 'profile.html');
    	$this->smarty->display('template.html');
    }

    function forgot_password()
    {
         $form = array(
            'formOpen'      => form_open('members/forgot_password'),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username', $this->input->post('username')),
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
 				$this->email->subject('Your New College Khabri Account Password');
 				$this->email->message($this->smarty->fetch('email_reset_password.tpl'));
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