<?php
class Choicecode extends Model
{
	private $code;
	private $college;
	private $course;
	private $popularity;
	
    function Choicecode()
    {
        parent::Model();
	    $this->load->model('institute');
	    $this->load->model('university');
    }

    function code() {if (is_null($this->code)) $this->set(); return $this->code; }
    function popularity() {if (is_null($this->popularity)) $this->set(); return $this->popularity; }
    function institute() {if (is_null($this->college)) $this->set(); return $this->college; }
    function course() {if (is_null($this->course)) $this->set(); return $this->course; }
    
    static function getChoicecode($id)
    {
		$choicecode = new Choicecode();
        $result = $choicecode->db->where('code', $id)->get('choice_codes');
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Choice code');
        }
        $choicecode->set($result->row_object());
        $result->free_result();
        return $choicecode;
    }
    
    private function set($data = null)
    {
        if (is_null($data))
        {
            $data = $this->db->where('code', $this->choicecode)->get('choice_codes')->result_object();
        }

        $this->choice = $data->code;
        $this->popularity = $data->popularity;
        $this->college = Institute::getInstituteById($data->institute_code);
        $this->course =  Course::getCourse($data->course_code);
    }    
}
?>