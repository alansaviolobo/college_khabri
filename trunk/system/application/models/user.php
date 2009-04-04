<?php
class User extends Model
{
    private $userId;
    private $username;
    private $birthDate;
    private $mobile;
    private $firstName;
    private $lastName;
    private $email;
    private $status;
    private $CETMarks;
    private $CETRank;
    private $homeUni;
//    private $;
//    private $;
//    private $;
//    private $;
//    private $;
//    private $;
//    private $;
    
    function User()
    {
        parent::Model();
    }

    function userId() {if (is_null($this->code)) $this->set(); return $this->code; }
    function username() {if (is_null($this->name)) $this->set(); return $this->name; }
    function birthDate() {if (is_null($this->address)) $this->set(); return $this->address; }
    function mobile() {if (is_null($this->university)) $this->set(); return $this->university; }
    function firstName() {if (is_null($this->code)) $this->set(); return $this->code; }
    function lastName() {if (is_null($this->name)) $this->set(); return $this->name; }
    function email() {if (is_null($this->address)) $this->set(); return $this->address; }
    function status() {if (is_null($this->university)) $this->set(); return $this->university; }
    function CETMarks() {if (is_null($this->code)) $this->set(); return $this->code; }
    function CET() {if (is_null($this->name)) $this->set(); return $this->name; }
    function address() {if (is_null($this->address)) $this->set(); return $this->address; }
    function university() {if (is_null($this->university)) $this->set(); return $this->university; }

    function getUser($userId)
    {
        parent::Model();

        $result = $this->db->from('users')->where('id', $courseId);
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid User');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

}
?>
