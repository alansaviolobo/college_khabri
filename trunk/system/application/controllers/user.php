<?php

class User extends Controller {

    function User()
    {
        parent::Controller();
        $this->load->library('Smarty');
        $this->smarty->assign('bigheader', true);
    }

    function signup()
    {
        for($count=1, $dates =array(); $count<=31; $dates[]=$count++);
        for($count=1, $months=array(); $count<=12; $months[]=$count++);
        for($count=intval(date('Y'))-25, $years =array(); $count<=intval(date('Y'))-15; $years[]=$count++);
        $submitjs = "document.signupform.password1.value=SHA1(document.signupform.password1.value)".
                    "document.signupform.password2.value=SHA1(document.signupform.password2.value)";
        $form = array(
            'formOpen'      => form_open('welcome/signup', array('name'=>'signupform')),
            'usernameLabel' => form_label('Email address', 'username', array('class'=>'style16')),
            'usernameBox'   => form_input('username', null, "class='med-field'"),
            'password1Label'=> form_label('Password', 'password1', array('class'=>'style16')),
            'password1Box'  => form_password('password1', null, "class='med-field'"),
            'password2Label'=> form_label('Retype Password', 'password2', array('class'=>'style16')),
            'password2Box'  => form_password('password2', null, "class='med-field'"),
            'mobileLabel'   => form_label('Mobile', 'mobile', array('class'=>'style16')),
            'mobileBox'     => form_input('mobile', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Signup', "onclick='$submitjs'"),
            'formClose'     => form_close()
        );
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run())
        {
            //do something
        }
        else $form['formErrors'] = validation_errors();

        $this->smarty->assign('signupForm', $form);
        $this->smarty->assign('template', 'signup.html');
        $this->smarty->display('template.html');
    }

    function login()
    {
        $this->load->library('form_validation');

        $loginform = array(
            'formOpen'      => form_open('user/login', array('name'=>'loginform')),
            'usernameLabel' => form_label('College Khabri username (your email address)', 'username', array('class'=>'style16')),
            'usernameBox'   => form_input('username', null, "class='med-field'"),
            'passwordLabel' => form_label('Your Password', 'password', array('class'=>'style16')),
            'passwordBox'   => form_password('password', null, "class='med-field'"),
            'submit'        => form_submit('submit', 'Login', "onclick='document.loginform.password.value=SHA1(document.loginform.password.value);'"),
            'formClose'     => form_close()
        );
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run())
        {
            //do something
        }
        else $loginform['formErrors'] = validation_errors();

         $forgotform = array(
            'formOpen'      => form_open('user/forgot_password'),
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

    function forgot_password()
    {
        $this->load->library('form_validation');
         $form = array(
            'formOpen'      => form_open('user/forgot_password'),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username'),
            'submit'        => form_submit('submit', 'Reset my password!'),
            'formClose'     => form_close()
        );
        for($count=1, $dates =array(); $count<=31; $dates[]=$count++);
        for($count=1, $months=array(); $count<=12; $months[]=$count++);
        for($count=intval(date('Y'))-25, $years =array(); $count<=intval(date('Y'))-15; $years[]=$count++);
       
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run())
        {
            //do something
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
            'formOpen'      => form_open('welcome/refer_friends'),
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
}

/* End of file user.php */
/* Location: ./system/application/controllers/user.php */