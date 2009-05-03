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

    static function getUniversity($universityId)
    {
    	$university = new University();
        $result = $university->db->where('id', $universityId)->get('universities');
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid University');
        }
        $university->set($result->row_object());
        $result->free_result();
        return $university;
    }

    private function set($data = null)
    {
        if (is_null($data))
        {
            $data = $this->db->get('universities')->where('id', $this->id)->result_object();
        }

        $this->id = $data->id;
        $this->name = $data->name;
    }

    function getUniversities()
    {
        $query = $this->db->select('id, name')->order_by('name')->get('universities');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['id']]=$row['name'];
        return array('' => 'All Universities') + $result;
    }
    
    function getDistricts()
    {
    	$query = $this->db->select('districts_under_control')->get('universities');
        $result = array();
        foreach($query->result_object() as $row)
        {
        	$list = explode(',', $row->districts_under_control);
        	foreach($list as $district)
        		$result[$district] = $district;
        }
        ksort($result);
        return array('' => 'Any District') + $result;
    }
}
?>