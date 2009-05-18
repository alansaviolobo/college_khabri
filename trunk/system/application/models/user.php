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
    private $gender;
    private $projCETScore;
    private $CETScore;
    private $CETRank;
    private $CETAppNo;
    private $projAIEEEScore;
    private $AIEEEScore;
    private $AIEEERank;
    private $AIEEEAppNo;
    private $category;
    private $homeUni;
    private $lastTx;

    public $processStage = 'pre-result'; //possible values = pre-result, result-score, result-rank

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
	function gender() {if (is_null($this->gender)) $this->set(); return $this->gender; }
	function projCETScore() {if (is_null($this->projCETScore)) $this->set(); return $this->projCETScore; }
    function CETScore() {if (is_null($this->CETScore)) $this->set(); return $this->CETScore; }
    function CETRank() {if (is_null($this->CETRank)) $this->set(); return $this->CETRank; }
	function CETAppNo() {if (is_null($this->CETAppNo)) $this->set(); return $this->CETAppNo; }
	function projAIEEEScore() {if (is_null($this->projAIEEEScore)) $this->set(); return $this->projAIEEEScore; }
    function AIEEEScore() {if (is_null($this->AIEEEScore)) $this->set(); return $this->AIEEEScore; }
    function AIEEERank() {if (is_null($this->AIEEERank)) $this->set(); return $this->AIEEERank; }
    function AIEEEAppNo() {if (is_null($this->AIEEEAppNo)) $this->set(); return $this->AIEEEAppNo; }
	function category() {if (is_null($this->category)) $this->set(); return $this->category; }
    function homeUni() {if (is_null($this->homeUni)) $this->set(); return $this->homeUni; }
    function lastTx() {if (is_null($this->lastTx)) $this->set(); return $this->lastTx; }

	function getStatuses()
	{
		return array (	'Open'=>'Open',
						'NTB'=>'NTB',
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

    static function getUserByUsername($username)
    {
        $user = new User();
        $result = $user->db->where('username', $username)->get('users');
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
            $data = $this->db->where('id', $this->id)->get('users')->row();
        }

	    $this->id = $data->id;
	    $this->username = $data->username;
	    $this->mobile = $data->mobile;
	    $this->firstName = $data->first_name;
	    $this->lastName = $data->last_name;
	    $this->emailAddress = $data->email;
	    $this->status = $data->status;
	    $this->gender = $data->gender;
	    $this->projCETScore = $data->projected_cet_score;
	    $this->CETScore = $data->cet_score;
	    $this->CETRank = $data->cet_rank;
	    $this->CETAppNo = $data->cet_appno;
	    $this->projAIEEEScore = $data->projected_aieee_score;
	    $this->AIEEEScore = $data->aieee_score;
	    $this->AIEEERank = $data->aieee_rank;
	    $this->AIEEEAppNo = $data->aieee_appno;
	    $this->category = $data->category;
	    $this->lastTx = $this->db->where('user_id', $this->id)->order_by('id')
	    						->limit(1)->get('payment_log')->row();
	    try
	    {
	    	$this->homeUni = University::getUniversity($data->home_uni);
	    }
	    catch(Exception $e)
	    {
	    	$this->homeUni = new University();
	    }
    }

    function create_user($email, $mobile, $password)
    {    	
    	if($this->db->where('username', $email)->get('users')->num_rows())
    		throw new Exception('Account already exists!');
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
    	$params = array_filter($params);
        $fname		= $this->db->escape(@$params['fname']);
        $lname		= $this->db->escape(@$params['lname']);
        $password	= $this->db->escape(@$params['password']);
        $homeUni	= $this->db->escape(@$params['homeUni']);
        $category	= $this->db->escape(@$params['category']);
        $gender		= $this->db->escape(@$params['gender']);
        $cetAppNo	= $this->db->escape(@$params['cetAppNo']);
        $pCETScore	= $this->db->escape(@$params['pCETScore']);
        $cetScore	= $this->db->escape(@$params['cetScore']);
        $cetRank	= $this->db->escape(@$params['cetRank']);
        $ai3eAppNo	= $this->db->escape(@$params['ai3eAppNo']);
        $pAI3EScore	= $this->db->escape(@$params['pAI3EScore']);
        $ai3eScore	= $this->db->escape(@$params['ai3eScore']);
        $ai3eRank	= $this->db->escape(@$params['ai3eRank']);
            	
    	$query = "UPDATE users SET
				    	first_name = $fname,
				    	last_name = $lname,
				    	password = IF($password IS NOT NULL, $password, password),
				    	home_uni = IF (home_uni IS NULL, $homeUni, home_uni),
				    	category =  IF (category IS NULL, $category, category),
				    	gender = IF (gender IS NULL, $gender, gender),
				    	cet_appno = IF (cet_appno IS NULL, $cetAppNo, cet_appno),
				    	projected_cet_score = $pCETScore,
				    	cet_score = IF (cet_score IS NULL, $cetScore, cet_score),
				    	cet_rank = IF (cet_rank IS NULL, $cetRank, cet_rank),
				    	aieee_appno = IF (aieee_appno IS NULL, $ai3eAppNo, aieee_appno),
				    	projected_aieee_score = $pAI3EScore,
				    	aieee_score = IF (aieee_score IS NULL, $ai3eScore, aieee_score),
				    	aieee_rank = IF (aieee_rank IS NULL, $ai3eRank, aieee_rank)
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
    	$this->db->where('id', $this->id)->update('users', array('password' => sha1($newpassword)));
    	return $newpassword;
    }
}
?>