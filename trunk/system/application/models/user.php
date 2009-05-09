<?php
class User extends Model
{
    private $id;
    private $username;
    private $mobile;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $status;
    private $CETMarks;
    private $CETRank;
    private $AIEEEMarks;
    private $AIEEERank;
    private $homeUni;
    private $lastTx;

    function User()
    {
        parent::Model();
    }

    function id() {if (is_null($this->id)) $this->set(); return $this->id; }
    function username() {if (is_null($this->username)) $this->set(); return $this->username; }
    function mobile() {if (is_null($this->mobile)) $this->set(); return $this->mobile; }
    function firstName() {if (is_null($this->firstName)) $this->set(); return $this->firstName; }
    function lastName() {if (is_null($this->lastName)) $this->set(); return $this->lastName; }
    function emailAddress() {if (is_null($this->emailAddress)) $this->set(); return $this->emailAddress; }
    function status() {if (is_null($this->status)) $this->set(); return $this->status; }
    function CETMarks() {if (is_null($this->CETMarks)) $this->set(); return $this->CETMarks; }
    function CETRank() {if (is_null($this->CETRank)) $this->set(); return $this->CETRank; }
	function AIEEEMarks() {if (is_null($this->AIEEEMarks)) $this->set(); return $this->AIEEEMarks; }
    function AIEEERank() {if (is_null($this->AIEEERank)) $this->set(); return $this->AIEEERank; }
    function homeUni() {if (is_null($this->homeUni)) $this->set(); return $this->homeUni; }
    function lastTx() {if (is_null($this->lastTx)) $this->set(); return $this->lastTx; }

	function getStatuses()
	{
		return array (	'NTB'=>'NTB',
						'NTC'=>'NTC',
						'NTD'=>'NTD',
						'OBC'=>'OBC',
						'SC'=>'SC',
						'ST'=>'ST',
						'VJ'=>'VJ',
						'SBC'=>'SBC',
						'SBC/OB'=>'SBC/OB',
						'SBC/ST'=>'SBC/ST');
	}
	
    static function getUserByUserId($user_id)
    {
        $user = new User();
        $result = $user->db->where('id', $user_id)->get('users');
        if ($result->num_rows() <> 1)
        {
            throw new Exception('Invalid User');
        }
        $user->set($result->row_object());
        $result->free_result();
        return $user;
    }

    static function getUserByAuthentication($username, $password)
    {
        $user = new User();
        $result = $user->db->where('username', $username)->where('password', $password)->get('users');
        if ($result->num_rows() <> 1)
        {
            throw new Exception('Invalid User');
        }
        $user->set($result->row_object());
        $result->free_result();
        return $user;
    }
    
    private function set($data = null)
    {
    	$this->load->model('university');
        if (is_null($data))
        {
            $data = $this->db->where('id', $this->id)->get('users')->result_object();
        }

	    $this->id = $data->id;
	    $this->username = $data->username;
	    $this->mobile = $data->mobile;
	    $this->firstName = $data->first_name;
	    $this->lastName = $data->last_name;
	    $this->emailAddress = $data->email;
	    $this->status = $data->status;
	    $this->CETMarks = $data->cet_marks;
	    $this->CETRank = $data->cet_rank;
	    $this->lastTx = $this->db->where('user_id', $this->id)->order_by('id')
	    						->limit(1)->get('payment_log')->row();
	    try {$this->homeUni = University::getUniversity($data->home_uni);}catch(Exception $e){}
    }

    function create_user($email, $mobile, $password)
    {    	
    	$this->db->trans_start();
    	$this->db->insert('users', array('id'=>0, 'username'=>$email, 'email'=>$email, 'mobile'=>$mobile, 'password'=>$password));
		$user_id = $this->db->insert_id();
		do {
			$code = substr(md5($email . $mobile . time()), 5, 10);
		} while ($this->db->where('code', $code)->where('status', 'pending')->count_all_results('payment_log'));
		
    	$this->db->set('created_on', 'NOW()', FALSE)->insert('payment_log', array('user_id'=>$user_id, 'code' => $code, 'channel'=>'cashdeposit'));
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
		    throw new Exception('Could not create account!');
		} 
    	return $user_id;
    	
    }
    
    function activate($code)
    {
	    if ($this->status() <> 'registered' or $this->lastTx()->status <> 'pending' or $this->lastTx()->code <> $code)
	    {
	    	throw new Exception ('Invalid Code');
	    }
	    
	    $this->db->trans_start();
    	$this->db->where('id', $this->id)->update('users', array('status'=>'premium'));
    	$this->db->set('paid_on', 'NOW()', FALSE)->set('applied_on', 'NOW()', FALSE)
    				->where('id', $this->lastTx->id)->update('payment_log', array('status'=>'applied'));
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
		    throw new Exception('Could not activate account!');
		} 
    	
    }
    
    function update_details($params)
    {
    	$password	= $this->db->escape(@$params['password']);
        $fname		= $this->db->escape(@$params['fname']);
        $lname		= $this->db->escape(@$params['lname']);
        $ai3eappno	= $this->db->escape(@$params['ai3eappno']);
        $ai3erank	= $this->db->escape(@$params['ai3erank']);
        $cetappno	= $this->db->escape(@$params['cetappno']);
        $cetrank	= $this->db->escape(@$params['cetrank']);
        $homeuni	= $this->db->escape(@$params['homeuni']);
        $category	= $this->db->escape(@$params['category']);
            	
    	$query = "UPDATE users SET
				    	first_name = IF ($fname IS NULL, first_name, $fname),
				    	last_name = IF ($lname IS NULL, last_name, $lname),
				    	password = IF ($password IS NULL, password, $password),
				    	aieee_rank = IF (aieee_rank IS NULL, $ai3erank, aieee_rank),
				    	aieee_appno = IF (aieee_appno IS NULL, $ai3eappno, aieee_appno),
				    	cet_rank =  IF (cet_rank IS NULL, $cetrank, cet_appno),
				    	cet_appno =  IF (cet_appno IS NULL, $cetappno, cet_appno),
				    	home_uni =  IF (home_uni IS NULL, $homeuni, home_uni),
				    	category =  IF (category IS NULL, $category, category)
			    	WHERE id = $this->id";
    	$this->db->query($query);
    }
    
    function reset_password()
    {
    	$range = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234566890';
    	$newpassword = '';
    	for($count = 0; $count<5; $count++)
    	{
    		$newpassword .= $range[rand(0, strlen($range))]; 
    	}
    	$this->update_details(array('password' => $newpassword));
    	return $newpassword;
    }
}
?>