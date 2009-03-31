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

          $this->smarty->assign('districts', array("All" => "All Districts",
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

    function changestate()
    {


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

    function login()
    {
        $this->load->library('form_validation');

        $form = array(
            'formOpen'      => form_open('welcome/login'),
            'usernameLabel' => form_label('Username', 'username'),
            'usernameBox'   => form_input('username'),
            'passwordLabel' => form_label('Password', 'password'),
            'passwordBox'   => form_password('password'),
            'submit'        => form_submit('submit', 'Login'),
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
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */