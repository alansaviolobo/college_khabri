<?php
class Institute extends Model
{  
	private $code;
	private $name;
	private $uni;
	private $status;
	private $address;
	private $city;
	private $district;
	private $state;
	private $pincode;
	private $stdcode;
	private $phone;
	private $fax;
	private $emailAddress;
	private $url;
	private $establishedIn;
	private $courses;
	private $fees;
	private $boysHostel;
	private $boysHostel1styear;
	private $girlsHostel;
	private $girlsHostel1styear;
	private $closestBusstop;
	private $closestRailwayStation;
	private $closestAirport;
	
    function Institute()
    {
        parent::Model();
    }

    function code() {if (is_null($this->code)) $this->set(); return $this->code; }
    function name() {if (is_null($this->name)) $this->set(); return $this->name; }
    function address() {if (is_null($this->address)) $this->set(); return $this->address; }
    function university() {if (is_null($this->uni)) $this->set(); return $this->uni; }
	function aidStatus() {if (is_null($this->aidStatus)) $this->set(); return $this->aidStatus; }
	function minorityStatus() {if (is_null($this->minorityStatus)) $this->set(); return $this->minorityStatus; }
    function autonomyStatus() {if (is_null($this->autonomyStatus)) $this->set(); return $this->autonomyStatus; }
    function city() {if (is_null($this->city)) $this->set(); return $this->city; }
	function district() {if (is_null($this->district)) $this->set(); return $this->district; }
    function state() {if (is_null($this->state)) $this->set(); return $this->state; }
    function pincode() {if (is_null($this->pincode)) $this->set(); return $this->pincode; }
    function stdcode() {if (is_null($this->stdcode)) $this->set(); return $this->stdcode; }
    function phone() {if (is_null($this->phone)) $this->set(); return $this->phone; }
    function fax() {if (is_null($this->fax)) $this->set(); return $this->fax; }
    function emailAddress() {if (is_null($this->emailAddress)) $this->set(); return $this->emailAddress; }
    function url() {if (is_null($this->url)) $this->set(); return $this->url; }
    function establishedIn() {if (is_null($this->establishedIn)) $this->set(); return $this->establishedIn; }
	function fees() {if (is_null($this->fees)) $this->set(); return $this->fees; }
	function courses() {if (is_null($this->courses)) $this->courses(); return $this->courses; }
    function boysHostel() {if (is_null($this->boysHostel)) $this->set(); return $this->boysHostel; }
    function girlsHostel() {if (is_null($this->girlsHostel)) $this->set(); return $this->girlsHostel; }
    function boysHostel1styear() {if (is_null($this->boysHostel1styear)) $this->set(); return $this->boysHostel1styear; }
    function girlsHostel1styear() {if (is_null($this->girlsHostel1styear)) $this->set(); return $this->girlsHostel1styear; }
    function closestBusstop() {if (is_null($this->closestBusstop)) $this->set(); return $this->closestBusstop; }
    function closestRailwayStation() {if (is_null($this->closestRailwayStation)) $this->set(); return $this->closestRailwayStation; }
    function closestAirport() {if (is_null($this->closestAirport)) $this->set(); return $this->closestAirport; }
        
    static function getInstituteById($instituteId)
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

    static static function getInstituteByName($instituteName)
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
            $data = $this->db->where('code', $this->code)->get('institutes')->result_object();
        }

        $this->code = $data->code;
        $this->name = $data->name;
        $this->address = $data->address;
		$this->aidStatus = $data->aid_status;
		$this->minorityStatus = $data->minority_status;
		$this->autonomyStatus = $data->autonomy_status;
		$this->city = $data->city;
		$this->district = $data->district;
		$this->state = $data->state;
		$this->pincode = $data->pincode;
		$this->stdcode = $data->stdcode;
		$this->phone = $data->phone;
		$this->fax = $data->fax;
		$this->emailAddress = $data->email;
		$this->url = $data->url;
		$this->establishedIn = $data->established_in;
		$this->boysHostel = $data->boys_hostel;
		$this->boysHostel1styear = $data->boys_hostel_1styear;
		$this->girlsHostel = $data->girls_hostel;
		$this->girlsHostel1styear = $data->girls_hostel_1styear;
		$this->closestBusstop = $data->closest_busstop;
		$this->closestRailwayStation = $data->closest_railway_station;
		$this->closestAirport = $data->closest_airport;
        $this->uni = University::getUniversity($data->university_id);
        $this->fees = $this->db->where('institute_code', $this->code)->get('fees')->row();
        $courses = $this->db->where('institute_code', $this->code)->get('choice_codes')->result_object();
        foreach($courses as $course) { $this->courses[] = Course::getCourse($course->course_code); }
    }
    
    function getDistricts()
    {
    	$query = $this->db->distinct()->select('district')->order_by('district')->get('institutes');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['district']]=$row['district'];
        return array('' => 'Any District') + $result;
    }
    
    function getAllMinorities()
    {
        $query = $this->db->distinct()->select('minority_status')->order_by('minority_status')->get('institutes');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['minority_status']]=$row['minority_status'];
        return array('' => 'No Choice') + $result;
    }

    function getAllAutonomies()
    {
        $query = $this->db->distinct()->select('autonomy_status')->order_by('autonomy_status')->get('institutes');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['autonomy_status']]=$row['autonomy_status'];
        return array('' => 'Any') + $result;
    }
    
    function getAllAidStatus()
    {
        $query = $this->db->distinct()->select('aid_status')->order_by('aid_status')->get('institutes');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['aid_status']]=$row['aid_status'];
        ksort($result);
        return array('' => 'Any') + $result;
    }
}
?>