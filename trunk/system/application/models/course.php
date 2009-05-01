<?php
class Course extends Model
{
    function Course()
    {
        parent::Model();
    }

    function getCourse($courseId)
    {
        parent::Model();

        $result = $this->db->from('courses')->where('id', $courseId);
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Course');
        }
        $this->set($result->row_object());
        $result->free_result();
    }

    function getAllCourses()
    {
        $query = $this->db->select('id, name')->get('courses');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['id']]=$row['name'];
        return $result;
    }
}
?>