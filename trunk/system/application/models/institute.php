<?php
class Institute extends Model
{  
	public $code;
	public $name;
	public $university;
	public $status;
	public $address;
	public $city;
	public $district;
	public $state;
	public $pincode;
	public $stdcode;
	public $phone;
	public $fax;
	public $emailAddress;
	public $url;
	public $establishedIn;
	public $closestBusstop;
	public $closestRailwayStation;
	public $closestAirport;
/*	public $library;
	public $building;
	public $classrooms;
	public $landAvailability;
	public $computers;
	public $laboratory;
	public $boysHostel;
	public $girlsHostel;
	public $sactionedIntake;
	public $requiredFaculty;
	public $professors;
	public $asstProfessors;
	public $lecturers;
	public $visitingFaculty;
	public $permanentFaculty;
	public $apporvedFaculty;
	public $adhocFaculty;
*/	
    function Institute()
    {
        parent::Model();
    }

    function code() {if (is_null($this->code)) $this->set(); return $this->code; }
    function name() {if (is_null($this->name)) $this->set(); return $this->name; }
    function address() {if (is_null($this->address)) $this->set(); return $this->address; }
    function university() {if (is_null($this->university)) $this->set(); return $this->university; }
    function status() {if (is_null($this->status)) $this->set(); return $this->status; }
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
		$this->university = $data->university;
		$this->status = $data->status;
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
		$this->closestBusstop = $data->closest_busstop;
		$this->closestRailwayStation = $data->closest_railway_station;
		$this->closestAirport = $data->closest_airport;
        $this->university = University::getUniversity($data->university);
    }
    
    function getAllMinorities()
    {
        $query = $this->db->distinct()->select('minority_status')->order_by('minority_status')->get('institutes');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['minority_status']]=$row['minority_status'];
        ksort($result);
        return array('' => 'No Choice') + $result;
    }

    function getAllAutonomies()
    {
        $query = $this->db->distinct()->select('autonomy_status')->order_by('autonomy_status')->get('institutes');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['autonomy_status']]=$row['autonomy_status'];
        ksort($result);
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