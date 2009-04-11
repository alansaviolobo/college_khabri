<?php
class University extends Model
{
    private $id;
    private $name;

    function University()
    {
        parent::Model();
    }

    function id() {if (is_null($this->id)) $this->set(); return $this->id; }
    function name() {if (is_null($this->name)) $this->set(); return $this->name; }

    function getUniversity($universityId)
    {
        parent::Model();

        $result = $this->db->where('name', $universityId)->get('universities');
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid University');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

    private function set($data = null)
    {
        if (is_null($data))
        {
            $data = $this->db->get('universities')->where('name', $this->name)->result_object();
        }

        $this->id = $data->id;
        $this->name = $data->name;
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