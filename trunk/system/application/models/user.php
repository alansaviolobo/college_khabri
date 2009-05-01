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
	function lastTx() {if (is_null($this->lastTx)) $this->set(); return $this->lastTx; }
    
    static function getUserByUserId($userId)
    {
        $user = new User();
        $result = $user->db->where('id', $userId)->get('users');
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
        if (is_null($data))
        {
            $data = $this->db->where('id', $this->id)->get('users')->result_object();
        }

	    $this->userId = $data->id;
	    $this->username = $data->username;
	    $this->mobile = $data->mobile;
	    $this->firstName = $data->first_name;
	    $this->lastName = $data->last_name;
	    $this->emailAddress = $data->email;
	    $this->status = $data->status;
	    $this->CETMarks = $data->cet_marks;
	    $this->CETRank = $data->cet_rank;
	    $this->homeUni = $data->home_uni;
	    $this->lastTx = $this->db->where('user_id', $this->userId)->order_by('id')
	    						->limit(1)->get('payment_log')->result_object();
    }

    function create_user($email, $mobile, $password)
    {    	
    	$this->db->trans_start();
    	$this->db->insert('users', array('id'=>0, 'username'=>$email, 'email'=>$email, 'mobile'=>$mobile, 'password'=>$password));
		$userId = $this->db->insert_id();
    	$this->db->set('created_on', 'NOW()', FALSE)->insert('payment_log', array('user_id'=>$userId, 'channel'=>'cashdeposit'));
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
		    throw new Exception('Could not create account!');
		} 
    	return $userId;
    	
    }
    
    function activate($code)
    {
	    if ($user->status() <> 'registered' or $user->lastTx()->status <> 'pending' or $user->lastTx()->code <> $code)
	    {
	    	throw new Exception ('Invalid Code');
	    }
	    
	    $this->db->trans_start();
    	$this->db->where('id', $this->id)->update(array('status'=>'premium'));
    	$this->db->set('paid_on', 'NOW()', FALSE)->set('applied_on', 'NOW()', FALSE)
    				->where('id', $this->lastTx->id)->update(array('status'=>'applied'));
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
		    throw new Exception('Could not activate account!');
		} 
    	
    }
}
?>