<?php
class Institute extends Model
{
    private $code;
    private $name;
    private $address;
    public $university;

    function Institute()
    {
        parent::Model();
    }

    function code() {if (is_null($this->code)) $this->set(); return $this->code; }
    function name() {if (is_null($this->name)) $this->set(); return $this->name; }
    function address() {if (is_null($this->address)) $this->set(); return $this->address; }
    function university() {if (is_null($this->university)) $this->set(); return $this->university; }

    function getInstituteById($instituteId)
    {
		$institute = new Institute();
        $result = $institute->db->where('code', $instituteId)->get('institutes');
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Institute');
        }
        $institute->set($result->row_object());
        $result->free_result();
        return $institute;
    }

    static function getInstituteByName($instituteName)
    {
		$institute = new Institute();
        $result = $institute->db->where('name', $instituteName)->get('institutes');
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Institute');
        }
        $institute->set($result->row_object());
        $result->free_result();
        return $institute;
    }

    private function set($data = null)
    {
        if (is_null($data))
        {
            $data = $this->db->get('institutes')->where('code', $this->code)->result_object();
        }

        $this->code = $data->code;
        $this->name = $data->name;
        $this->address = $data->address;
        $this->university = University::getUniversity($data->university);
    }

    function searchInstitutes()
    {
        $query = $this->db->limit(10)->get('institutes');
        $result = array();
        $count = 0;
        foreach($query->result_object() as $row)
        {
            $result[$count] = new Institute();
            $result[$count]->set($row);
            $count++;
        }
        
        return $result;
    }
}
?>
