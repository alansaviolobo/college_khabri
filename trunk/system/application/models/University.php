<?php
class University extends Model
{
    function University()
    {
        parent::Model();
    }

    function getUniversity($universityId)
    {
        parent::Model();

        $result = $this->db->from('universities')->where('id', $universityId);
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Username or Password');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

    function getAllUniversities()
    {
        $query = $this->db->select('id, name')->get('universities');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['id']]=$row['name'];
        return $result;
    }
}
?>