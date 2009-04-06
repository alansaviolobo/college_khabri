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

    function getInstitute($instituteId)
    {
        parent::Model();

        $result = $this->db->where('code', $instituteId)->get('institutes');
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Institute');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

    function set($data = null)
    {
        if (is_null($data))
        {
            $data = $this->db->get('institutes')->where('code', $this->code)->result_object();
        }
        
        $this->code = $data->code;
        $this->name = $data->name;
        $this->address = $data->address;
        $this->university = $data->university;
    }

    function getAllInstitutes()
    {
        $query = $this->db->get('institutes');
        $result = array();
        foreach($query->result_object() as $row)
        {
            $inst = new Institute();
            $inst->set($row);
            $result[] = $inst;
        }
        
        return $result;
    }
}
?>
