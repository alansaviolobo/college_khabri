<?php
class Choicecode extends Model
{
	private $code;
	private $college;
	private $course;
	private $popularity;
	private $facultySanctionedIntake;
	private $facultyRequired;
	private $facultyGraduate;
	private $facultyPostGraduate;
	private $facultyDoctorate;
	private $facultyTeachingExp;
	private $facultyIndustryExp;
	private $facultyResearchExp;
	private $facultyPermanentFacultyStudentRatio;
	private $facultyFacultyStudentRatio;
	private $placementTotalPassing;
	private $placementTotalPlaced;
	private $placementMinSalary;
	private $placementMaxSalary;
	private $placementAvgSalary;
	private $placementMedianSalary;
	private $placementYear;
	
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
    function facultySanctionedIntake() {if (is_null($this->facultySanctionedIntake)) $this->set(); return $this->facultySanctionedIntake; }
	function facultyRequired() {if (is_null($this->facultyRequired)) $this->set(); return $this->facultyRequired; }
	function facultyGraduate() {if (is_null($this->facultyGraduate)) $this->set(); return $this->facultyGraduate; }
	function facultyPostGraduate() {if (is_null($this->facultyPostGraduate)) $this->set(); return $this->facultyPostGraduate; }
	function facultyDoctorate() {if (is_null($this->facultyDoctorate)) $this->set(); return $this->facultyDoctorate; }
	function facultyTeachingExp() {if (is_null($this->facultyTeachingExp)) $this->set(); return $this->facultyTeachingExp; }
	function facultyIndustryExp() {if (is_null($this->facultyIndustryExp)) $this->set(); return $this->facultyIndustryExp; }
	function facultyResearchExp() {if (is_null($this->facultyResearchExp)) $this->set(); return $this->facultyResearchExp; }
	function facultyPermanentFacultyStudentRatio() {if (is_null($this->facultyPermanentFacultyStudentRatio)) $this->set(); return $this->facultyPermanentFacultyStudentRatio; }
	function facultyFacultyStudentRatio() {if (is_null($this->facultyFacultyStudentRatio)) $this->set(); return $this->facultyFacultyStudentRatio; }
	function placementTotalPassing() {if (is_null($this->placementTotalPassing)) $this->set(); return $this->placementTotalPassing; }
	function placementTotalPlaced() {if (is_null($this->placementTotalPlaced)) $this->set(); return $this->placementTotalPlaced; }
	function placementMinSalary() {if (is_null($this->placementMinSalary)) $this->set(); return $this->placementMinSalary; }
	function placementMaxSalary() {if (is_null($this->placementMaxSalary)) $this->set(); return $this->placementMaxSalary; }
	function placementAvgSalary() {if (is_null($this->placementAvgSalary)) $this->set(); return $this->placementAvgSalary; }
	function placementMedianSalary() {if (is_null($this->placementMedianSalary)) $this->set(); return $this->placementMedianSalary; }
	function placementYear() {if (is_null($this->placementYear)) $this->set(); return $this->placementYear; }
	
    static function getChoicecode($id)
    {
		$choicecode = new Choicecode();
        $result = $choicecode->db->from('choice_codes')
        						->join('faculty', 'choice_codes.code = faculty.choice_code', 'left outer')
        						->join('placements', 'choice_codes.code = placements.choice_code', 'left outer')
        						->where('code', $id)->get();
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
            $data = $this->db->from('choice_codes')
            				->join('faculty', 'choice_codes.code = faculty.choice_code', 'left outer')
            				->join('placemen1ts', 'choice_codes.code = placements.choice_code', 'left outer')
            				->where('code', $this->code)->result_object();
        }

        $this->choice = $data->code;
        $this->popularity = $data->popularity;
        $this->college = Institute::getInstituteById($data->institute_code);
        $this->course =  Course::getCourse($data->course_code);
        $this->facultySanctionedIntake = $data->sanctioned_intake;
		$this->facultyRequired = $data->required_faculty;
		$this->facultyGraduate = $data->graduate;
		$this->facultyPostGraduate = $data->post_graduate;
		$this->facultyDoctorate = $data->doctorate;
		$this->facultyTeachingExp = $data->teaching_experience;
		$this->facultyIndustryExp = $data->industry_experience;
		$this->facultyResearchExp = $data->research_experience;
		$this->facultyPermanentFacultyStudentRatio = $data->permanent_faculty_student_ratio;
		$this->facultyFacultyStudentRatio = $data->faculty_student_ratio;
		$this->placementTotalPassing = $data->total_passing;
		$this->placementTotalPlaced = $data->total_placed;
		$this->placementMinSalary = $data->min_salary;
		$this->placementMaxSalary = $data->max_salary;
		$this->placementAvgSalary = $data->avg_salary;
		$this->placementMedianSalary = $data->median_salary;
		$this->placementYear = $data->year;
    }    
}
?>