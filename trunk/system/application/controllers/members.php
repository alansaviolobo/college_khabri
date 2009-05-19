<?php

class Members extends Controller {

    function Members()
    {
        parent::Controller();
    	$this->load->library('email');
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->smarty->assign('titlelink', array('fn'=>$this->session->userdata('firstName'),'un'=>$this->session->userdata('username')));
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
        	'tosCheckLabel'	=> form_label("I agree to the everything mentioned in the ".anchor('info/terms_of_use','terms of use.'), 'tosaccept'),
        	'tosCheckBox'	=> form_checkbox(array('name' => 'tosaccept', 'value' => 'accept', 'onclick' => 'document.signupform.submit.disabled=!this.checked')),
            'submit'        => form_submit('submit', 'Send me the activation code', array('disabled'=>true)),
            'formClose'     => form_close()
        );
        $rules = array(
        	array('field'=>'username' , 'label'=>'Username',		'rules'=>'trim|required|valid_email|max_length[255]'),
        	array('field'=>'password1', 'label'=>'Password',		'rules'=>'trim|required|exact_length[40]'),
        	array('field'=>'password2', 'label'=>'Retype Password', 'rules'=>'trim|required|matches[password1]'),
        	array('field'=>'mobile'   , 'label'=>'Mobile',			'rules'=>'trim|required|exact_length[10]|is_natural')
        );
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run())
        {
        	try 
        	{
            	$user_id = User::create_user($this->input->post('username'), $this->input->post('mobile'), $this->input->post('password1'));
				$user = User::getUserByUserId($user_id);
				$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName(), 'username'=>$user->username()));
				$this->smarty->assign('titlelink', array('fn'=>$this->session->userdata('firstName'),'un'=>$this->session->userdata('username')));

   		   		$this->smarty->assign('user', $user);
     			$this->email->from('support@collegekhabri.com', 'College Khabri Support');
 				$this->email->to($user->emailAddress());
 				$this->email->bcc('support@collegekhabri.com');
 				$this->email->subject('Your new College Khabri Account: Activation pending.');
 				$this->email->message($this->smarty->fetch('email_signup_details.tpl'));
 				$this->email->send();
            	redirect("members/activation/$user_id");
            	return;
        	}
        	catch(Exception $e)
        	{
        		$form['formErrors'] = "<div class='error'>{$e->getMessage()}</div>";
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
		$universityList = array('' => 'Select One', '-1' => 'Outside State / AIEEE Candidate') + University::getUniversities();
    	
    	$form = array(
            'formOpen'      => form_open("members/activation/$user_id"),
            'codeLabel' 	=> form_label('Your Activation Code', 'code', array('class'=>'medium-text v-thin-line')),
            'codeBox'   	=> form_input('code', $this->input->post('code'), "class='med-field'"),
            'fNameLabel' 	=> form_label('First Name', 'fname', array('class'=>'medium-text v-thin-line')),
            'fNameBox'   	=> form_input('fname', $this->input->post('fname'), "class='med-field'"),
            'lNameLabel' 	=> form_label('Surname', 'lname', array('class'=>'medium-text v-thin-line')),
            'lNameBox'   	=> form_input('lname', $this->input->post('lname'), "class='med-field'"),
            'homeUniLabel'	=> form_label('Home University', 'homeUni', array('class'=>'medium-text v-thin-line')),
            'homeUniSelect'	=> form_dropdown('homeUni', $universityList, $this->input->post('homeUni'), "class='med-field'"),
            'categoryLabel'	=> form_label('Your category', 'category', array('class'=>'medium-text v-thin-line')),
            'categorySelect'=> form_dropdown('category', User::getStatuses(), $this->input->post('category'), "class='med-field'"),
            'maleLabel'		=> form_label('Male', 'gender'),
            'maleRadio'		=> form_radio('gender','male',$this->input->post('gender')=='male'),
            'femaleLabel'	=> form_label('Female', 'gender'),
        	'femaleRadio'	=> form_radio('gender','female',$this->input->post('gender')=='female'),
        	'mhtAppNoLabel'	=> form_label('MHT-CET roll no', 'cetAppNo', array('class'=>'medium-text v-thin-line')),
            'mhtAppNoBox'  	=> form_input('cetAppNo', $this->input->post('cetAppNo'), "class='med-field'"),
            'pCETScoreLabel'=> form_label('Projected CET score', 'pCETScore', array('class'=>'medium-text v-thin-line')),
            'pCETScoreBox'  => form_input('pCETScore', $this->input->post('pCETScore'), "class='med-field'"),
            'CETScoreLabel'=> form_label('CET score', 'cetScore', array('class'=>'medium-text v-thin-line')),
            'CETScoreBox'  => form_input('cetScore', $this->input->post('cetScore'), "class='med-field'"),
            'CETRankLabel' => form_label('CET rank', 'cetRank', array('class'=>'medium-text v-thin-line')),
            'CETRankBox'   => form_input('cetRank', $this->input->post('cetRank'), "class='med-field'"),
            'ai3eAppNoLabel'=> form_label('AIEEE roll no', 'ai3eAppNo', array('class'=>'medium-text v-thin-line')),
            'ai3eAppNoBox' => form_input('ai3eAppNo', $this->input->post('ai3eAppNo'), "class='med-field'"),
            'pAI3EScoreLabel'=>form_label('Projected AIEEE score', 'pAI3EScore', array('class'=>'medium-text v-thin-line')),
            'pAI3EScoreBox' => form_input('pAI3EScore', $this->input->post('pAI3EScore'), "class='med-field'"),
            'AI3EScoreLabel'=>form_label('AIEEE score', 'ai3eScore', array('class'=>'medium-text v-thin-line')),
            'AI3EScoreBox' => form_input('ai3eScore', $this->input->post('ai3eScore'), "class='med-field'"),
            'AI3ERankLabel'=> form_label('AIEEE rank', 'ai3eRank', array('class'=>'medium-text v-thin-line')),
            'AI3ERankBox'  => form_input('ai3eRank', $this->input->post('ai3eRank'), "class='med-field'"),
            'submit'        => form_submit('submit', 'Activate my account'),
            'formClose'     => form_close()
        );
    	$rules = array(
        	array('field'=>'code',		'label'=>'Activation code',	'rules'=>'trim|required|exact_length[5]'),
        	array('field'=>'fname',		'label'=>'First Name',		'rules'=>'trim|required|alpha|max_length[255]'),
        	array('field'=>'lname',		'label'=>'Surname',			'rules'=>'trim|required|alpha|max_length[255]'),
        	array('field'=>'homeUni',	'label'=>'Home University',	'rules'=>'trim|required|integer'),
        	array('field'=>'category',	'label'=>'Category',		'rules'=>'trim|required'),
        	array('field'=>'gender',	'label'=>'Gender',			'rules'=>'trim|required|alpha'),
        	array('field'=>'cetAppNo',	'label'=>'CET roll no.',	'rules'=>'trim|exact_length[10]'),
        	array('field'=>'pCETScore',	'label'=>'Proj CET Score',	'rules'=>'trim|is_natural'),
        	array('field'=>'cetScore',	'label'=>'CET Score',		'rules'=>'trim|is_natural'),
        	array('field'=>'cetRank',	'label'=>'CET Rank',		'rules'=>'trim|is_natural'),
        	array('field'=>'ai3eAppNo',	'label'=>'AIEEE roll no.',	'rules'=>'trim|exact_length[9]'),
        	array('field'=>'pAI3EScore','label'=>'Proj AIEEE Score','rules'=>'trim|is_natural'),
        	array('field'=>'ai3eScore',	'label'=>'AIEEE Score',		'rules'=>'trim|is_natural'),
        	array('field'=>'ai3eRank',	'label'=>'AIEEE Rank',		'rules'=>'trim|is_natural')
    	);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run())
        {
        	try
        	{
        		if (!$this->input->post('cetAppNo') and !$this->input->post('ai3eAppNo'))
        			throw new Exception('Please enter either your AIEEE roll no. or your MHTCET roll no.');

	        	$params = array(
	        		'fname' => $this->input->post('fname'),
	        		'lname' => $this->input->post('lname'),
		        	'homeUni' => $this->input->post('homeUni'),
	        		'category' => $this->input->post('category'),
	        		'gender' => $this->input->post('gender'),
	        		'cetAppNo' => $this->input->post('cetAppNo'),
	        		'pCETScore' => $this->input->post('pCETScore'),
	        		'cetScore' => $this->input->post('cetScore'),
		        	'cetRank' => $this->input->post('cetRank'),
	        		'ai3eAppNo' => $this->input->post('ai3eAppNo'),
		        	'pAI3EScore' => $this->input->post('pAI3EScore'),
	        		'ai3eScore' => $this->input->post('ai3eScore'),
		        	'ai3eRank' => $this->input->post('ai3eRank'));
	    		$user->activate($this->input->post('code'));
	    		$user->update_details($params);
	    		$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName(), 'username'=>$user->username()));
	    		redirect('members/profile');
	    		return;
        	}
        	catch(Exception $e)
        	{
        		$form['formErrors'] = "<div class='error'>{$e->getMessage()}</div>";
        	}
        }
        else $form['formErrors'] = validation_errors();

	    $this->smarty->assign('user', $user);
	    $this->smarty->assign('activationForm', $form);
	    $this->smarty->assign('processStage', $user->processStage);
	    $this->smarty->assign('template', 'activation.html');
        $this->smarty->display('template.html');
    }
    
    function login()
    {
        $loginform = array(
            'formOpen'      => form_open('members/login', array('name'=>'loginform', 'onsubmit'=>'if (document.loginform.password.value) document.loginform.password.value=SHA1(document.loginform.password.value)')),
            'usernameLabel' => form_label('Login ID (your email address)', 'username', array('class'=>'medium-text')),
            'usernameBox'   => form_input('username', $this->input->post('username'), "class='med-field'"),
            'passwordLabel' => form_label('Your Password', 'password', array('class'=>'medium-text')),
            'passwordBox'   => form_password('password', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Login', "class='medium-button'"),
            'formClose'     => form_close()
        );
        $rules = array(
        	array('field'=>'username', 'label'=>'Username', 'rules'=>'trim|required|valid_email|max_length[255]'),
        	array('field'=>'password', 'label'=>'Password', 'rules'=>'trim|required|exact_length[40]')
        );
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run())
        {
        	try
        	{
        		$user = User::getUserByAuthentication($this->input->post('username'), $this->input->post('password'));
        		$this->session->set_userdata(array('userId'=>$user->id(), 'firstName'=>$user->firstName(), 'username'=>$user->username()));
        		$this->smarty->assign('titlelink', array('fn'=>$this->session->userdata('firstName'),'un'=>$this->session->userdata('username')));
	            if ($user->status() == 'registered')
	            {
	            	redirect('members/activation/' . $user->id());
	            }
	            else
	            {
	        		redirect('/members/profile');
	            }
				return;
        	}
        	catch(Exception $e)
        	{
        		$loginform['formErrors'] = '<div class="error">Invalid username or password</div>';
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

        $submitjs = "if (document.profileform.password1.value) document.profileform.password1.value=SHA1(document.profileform.password1.value);".
                    "if (document.profileform.password2.value) document.profileform.password2.value=SHA1(document.profileform.password2.value)";
         $form = array(
            'formOpen'		=> form_open('members/profile', array('name'=>'profileform', 'onsubmit'=>$submitjs)),
            'password1Label'=> form_label('New password:', 'password1'),
            'password1Box'	=> form_password('password1'),
            'password2Label'=> form_label('New password again:', 'password2'),
            'password2Box'	=> form_password('password2'),
            'fnameLabel'	=> form_label('First Name:', 'fname'),
            'fnameBox'		=> form_input('fname', $this->input->post('fname')?$this->input->post('fname'):$user->firstName()),
            'lnameLabel'	=> form_label('Last Name:', 'lname'),
            'lnameBox'		=> form_input('lname', $this->input->post('lname')?$this->input->post('lname'):$user->lastName()),
         	'ai3eAppLabel'	=> form_label('AIEEE roll no:', 'ai3eAppNo'),
            'ai3eAppBox'	=> form_input('ai3eAppNo', $this->input->post('ai3eAppNo')?$this->input->post('ai3eAppNo'):$user->aieeeAppNo()),
            'cetAppLabel'	=> form_label('MHTCET roll no:', 'cetAppNo'),
            'cetAppBox'		=> form_input('cetAppNo', $this->input->post('cetAppNo')?$this->input->post('cetAppNo'):$user->cetAppNo()),
            'pAI3EScoreLabel'=> form_label('Projected AIEEE Score:', 'pAI3EScore'),
            'pAI3EScoreBox'	=> form_input('pAI3EScore', $this->input->post('pAI3EScore')?$this->input->post('pAI3EScore'):$user->projAIEEEScore()),
            'pCETScoreLabel'=> form_label('Projected MHTCET Rank:', 'pCETScore'),
            'pCETScoreBox'	=> form_input('pCETScore', $this->input->post('pCETScore')?$this->input->post('pCETScore'):$user->projCETScore()),
            'ai3eScoreLabel'=> form_label('AIEEE Score:', 'ai3eScore'),
            'ai3eScoreBox'	=> form_input('ai3eScore', $this->input->post('ai3eScore')?$this->input->post('ai3eScore'):$user->AIEEEScore()),
            'cetScoreLabel'	=> form_label('MHTCET Score:', 'cetScore'),
            'cetScoreBox'	=> form_input('cetScore', $this->input->post('cetScore')?$this->input->post('cetScore'):$user->CETScore()),
         	'ai3eRankLabel'	=> form_label('AIEEE Rank:', 'ai3eRank'),
            'ai3eRankBox'	=> form_input('ai3eRank', $this->input->post('ai3eRank')?$this->input->post('ai3eRank'):$user->AIEEERank()),
            'cetRankLabel'	=> form_label('MHTCET Rank:', 'cetRank'),
            'cetRankBox'	=> form_input('cetRank', $this->input->post('cetRank')?$this->input->post('cetRank'):$user->CETRank()),
            'submit'		=> form_submit('submit', 'Update my profile'),
            'formClose'		=> form_close()
        );
        $rules = array(
        	array('field'=>'password1' ,'label'=>'Password',		'rules'=>'trim'),
        	array('field'=>'password2', 'label'=>'Retype Password',	'rules'=>'trim|matches[password1]'),
        	array('field'=>'fname', 	'label'=>'First Name',		'rules'=>'trim|required|max_length[255]'),
        	array('field'=>'lname',		'label'=>'Last Name',		'rules'=>'trim|required|max_length[255]'),
        	array('field'=>'ai3eAppNo',	'label'=>'AIEEE roll no',	'rules'=>'trim|exact_length[10]'),
        	array('field'=>'cetAppNo',	'label'=>'MHTCET roll no',	'rules'=>'trim|exact_length[9]'),
        	array('field'=>'pAI3EScore','label'=>'Proj AIEEE Score','rules'=>'trim|is_natural'),
        	array('field'=>'pCETScore',	'label'=>'Proj MHTCET Score','rules'=>'trim|is_natural'),
        	array('field'=>'ai3eScore',	'label'=>'AIEEE Score',		'rules'=>'trim|is_natural'),
        	array('field'=>'cetScore',	'label'=>'MHTCET Score',	'rules'=>'trim|is_natural'),
        	array('field'=>'ai3eRank',	'label'=>'AIEEE Rank',		'rules'=>'trim|is_natural'),
        	array('field'=>'cetRank',	'label'=>'MHTCET Rank',		'rules'=>'trim|is_natural')
        	);
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run())
        {
            try
            {
            	$params = array(
            		'password'	=> $this->input->post('password1'),
            		'fname'		=> $this->input->post('fname'),
            		'lname'		=> $this->input->post('lname'),
            		'ai3eAppNo'	=> $this->input->post('ai3eAppNo'),
            		'cetAppNo'	=> $this->input->post('cetAppNo'),
            		'pAI3EScore'=> $this->input->post('pAI3EScore'),
            		'pCETScore' => $this->input->post('pCETScore'),
            		'ai3eScore' => $this->input->post('ai3eScore'),
            		'cetScore'	=> $this->input->post('cetScore'),
            		'ai3eRank'	=> $this->input->post('ai3eRank'),
            		'cetRank'	=> $this->input->post('cetRank'));
            	$user->update_details($params);
            	$this->smarty->assign('successMsg', 'Details successfully updated');
            }
            catch(Exception $e)
            {
            	$form['formErrors'] = '<div class="error">Error updating your details</div>';
            }
        }
        else $form['formErrors'] = validation_errors();

		$this->smarty->assign('user', $user);
        $this->smarty->assign('profileForm', $form);
        $this->smarty->assign('processStage', $user->processStage);
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
            	$user = User::getUserByUsername($this->input->post('username'));
	            $newpassword = $user->reset_password();
   		   		$this->smarty->assign('user', $user);
   		   		$this->smarty->assign('newpassword', $newpassword);
     			$this->email->from('support@collegekhabri.com', 'College Khabri Support');
 				$this->email->to($user->emailAddress());
 				$this->email->bcc('support@collegekhabri.com');
 				$this->email->subject('Your New College Khabri Account Password');
 				$this->email->message($this->smarty->fetch('email_reset_password.tpl'));
 				$this->email->send();
 				$this->smarty->assign('pwdreset', 1);
            }
            catch(Exception $e)
            {
            	$form['formErrors'] = '<div class="error">Invalid email address provided</div>';
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
		$this->session->sess_destroy();
		redirect('welcome/index');
    }
    
    function savedsearches()
    {
    	$this->smarty->assign('template', 'savedsearches.html');
    	$this->smarty->display('template.html');     
    }
}

/* End of file members.php */
/* Location: ./system/application/controllers/members.php */