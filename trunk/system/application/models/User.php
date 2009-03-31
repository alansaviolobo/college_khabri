<?php
class User extends Model
{
    private $userId;
    private $username;
    private $firstName;
    private $lastName;
    private $mobile;
    private $address1;
    private $address2;
    private $pincode;

    function User()
    {
        parent::Model();
    }

    function User($username, $password)
    {
        parent::Model();

        $result = $this->db->from('users')->where('username', $username)->where('password', $password);
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Username or Password');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

    function User($userId)
    {
        parent::Model();

        $result = $this->db->from('users')->where('user_id', $user_id);
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Username or Password');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

    private function set($data)
    {
        $this->username = $data->user_id;
        $this->firstName = $data->first_name;
        $this->lastName = $data->last_name;
        $this->address1 = $data->address1;
        $this->address2 = $data->address2;
        $this->pincode = $data->pincode;
        $this->mobile = $data->mobile;
    }


}
?>