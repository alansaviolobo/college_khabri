<?php

class User extends Controller {

    function User()
    {
        parent::Controller();
        $this->load->library('Smarty');
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
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username'),
            'password1Label'=> form_label('Password', 'password1'),
            'password1Box'  => form_password('password1'),
            'password2Label'=> form_label('Retype Password', 'password2'),
            'password2Box'  => form_password('password2'),
            'dobLabel'      => form_label('Date of Birth', 'birthdate[d]'),
            'dobDate'       => form_dropdown('birthdate[d]', $dates),
            'dobMonth'      => form_dropdown('birthdate[m]', $months),
            'dobYear'       => form_dropdown('birthdate[y]', $years),
            'mobileLabel'   => form_label('Mobile', 'mobile'),
            'mobileBox'     => form_input('mobile'),

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

        $form = array(
            'formOpen'      => form_open('welcome/login', array('name'=>'loginform')),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username'),
            'passwordLabel' => form_label('Password', 'password'),
            'passwordBox'   => form_password('password'),
            'submit'        => form_submit('submit', 'Login', "onclick='document.loginform.password.value=SHA1(document.loginform.password.value);'"),
            'formClose'     => form_close()
        );
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run())
        {
            //do something
        }
        else $form['formErrors'] = validation_errors();

        $this->smarty->assign('loginForm', $form);
        $this->smarty->assign('template', 'login.html');
        $this->smarty->display('template.html');
    }

    function forgot_password()
    {
        $this->load->library('form_validation');

        for($count=1, $dates =array(); $count<=31; $dates[]=$count++);
        for($count=1, $months=array(); $count<=12; $months[]=$count++);
        for($count=intval(date('Y'))-25, $years =array(); $count<=intval(date('Y'))-15; $years[]=$count++);
        $form = array(
            'formOpen'      => form_open('welcome/forgot_password'),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username'),
            'dobLabel'      => form_label('Date of Birth', 'birthdate[d]'),
            'dobDate'       => form_dropdown('birthdate[d]', $dates),
            'dobMonth'      => form_dropdown('birthdate[m]', $months),
            'dobYear'       => form_dropdown('birthdate[y]', $years),
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