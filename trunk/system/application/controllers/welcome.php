<?php

class Welcome extends Controller {

    function Welcome()
    {
        parent::Controller();
        $this->load->library('Smarty');
    }

    function index()
    {
        $this->smarty->assign('universities', University::getAllUniversities());
        $this->smarty->assign('courses', Course::getAllCourses());
        $this->smarty->assign('coursegroups', array(
          '70' => 'Chemical',
          '10' => 'Civil',
          '60' => 'Computers',
          '40' => 'Electrical',
          '50' => 'Electronics',
          '85' => 'General',
          '80' => 'Inter Disciplinary',
          '20' => 'Mechanical',
          '30' => 'Other Management ',
          '04' => 'Textile'));

          $this->smarty->assign('districts', array(
          "Ahmednagar" => "Ahmednagar",
          "Akola" => "Akola",
          "Amravati" => "Amravati",
          "Aurangabad" => "Aurangabad",
          "Beed" => "Beed",
          "Bhandara" => "Bhandara",
          "Bhulhana" => "Bhulhana",
          "Buldhana" => "Buldhana",
          "Chandrapur" => "Chandrapur",
          "Dadra Nagar Haveli" => "Dadra Nagar Haveli",
          "Dhule" => "Dhule",
          "Gondia" => "Gondia",
          "Jalgaon" => "Jalgaon",
          "Jalgoan" => "Jalgoan",
          "Kolhapur" => "Kolhapur",
          "Kolhpur" => "Kolhpur",
          "Latur" => "Latur",
          "Mumbai" => "Mumbai",
          "Nagpur" => "Nagpur",
          "Nanded" => "Nanded",
          "Nandurbar" => "Nandurbar",
          "Nashik" => "Nashik",
          "New Delhi" => "New Delhi",
          "Osmanabad" => "Osmanabad",
          "Parbhani" => "Parbhani",
          "Pune" => "Pune",
          "Raigad" => "Raigad",
          "Raigadh" => "Raigadh",
          "Ratnagiri" => "Ratnagiri",
          "Sangli" => "Sangli",
          "Satara" => "Satara",
          "Solapur" => "Solapur",
          "Thane" => "Thane",
          "Wardha" => "Wardha",
          "Yavatmal" => "Yavatmal"));

        $this->smarty->assign('template', 'index.html');
        $this->smarty->display('template.html');
    }

    function fine_tuning()
    {
        $this->smarty->assign('aid_status', array(
          "Government",
          "Govenment Aided",
          "Government-Government-Aided",
          "Un-Aided",
          "University Managed",
          "University Department",
          "University Managed (UA)"));
        $this->smarty->assign('autonomy', array(
          "Autonomous",
          "Non-Autonomous",
          "Deemed University"));
        $this->smarty->assign('minority', array(
          "Non-minority",
          "Linguistic - Gujarathi",
          "Linguistic - Gujarathi (Kutchhi)",
          "Linguistic - Hindi",
          "Linguistic - Malyalam",
          "Linguistic - Sindhi",
          "Linguistic - Punjabi",
          "Linguistic - South Indian Lang",
          "Religious - Jain",
          "Religious - Muslim",
          "Religious - Roman Catholics",
          "Religious - Christian",
          "Religious - Sikh"));
        $this->smarty->assign('fees', array());
        $this->smarty->assign('hostel', array());
        $this->smarty->assign('template', 'finetuning.html');
        $this->smarty->display('template.html');
    }

    function search_results()
    {
        $this->smarty->assign('results', Institute::getAllInstitutes());
        $this->smarty->assign('template', 'searchresults.html');
        $this->smarty->display('template.html');
    }
    
    function institute_info($instituteId)
    {
        $institute = new Institute();
        $institute->getInstitute($instituteId);
        $this->smarty->assign('institute', $institute);
        $this->smarty->assign('template', 'instituteinfo.html');
        $this->smarty->display('template.html');
    }

    function changestate()
    {
        $this->session->set_userdata(array('residence_state' => $_POST['State']));
    }


    function contact_us()
    {
        $this->smarty->assign('template', 'contactus.html');
        $this->smarty->display('template.html');
    }

    function terms_of_use()
    {
        $this->smarty->assign('template', 'termsofuse.html');
        $this->smarty->display('template.html');
    }

    function privacy_policy()
    {
        $this->smarty->assign('template', 'privacypolicy.html');
        $this->smarty->display('template.html');
    }

    function signup()
    {
        $this->load->library('form_validation');

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

            'submit'        => form_submit('submit', 'Login', "onclick='$submitjs'"),
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
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */