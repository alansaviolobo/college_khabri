<?php

class Sms extends Controller {

    function Sms()
    {
        parent::Controller();
    }

    function register()
    {/*#   GET Paramaters: 'PhNo', 'Key', 'Phrase', 'Param', 'FullMsg' 
    respectively for Source Phone Number, 1st word, [2nd word], 2nd or 3rd word, Full SMS Text  */
    	var_dump($_GET);
    	//var_dump($this->input->get('PhNo'));
    }
}

/* End of file sms.php */
/* Location: ./system/application/controllers/sms.php */