<?php

class Attendance_model extends CI_Model
{
    
    
    function __consturct()
    {
        parent::__construct();
        
    }
    public function Add_AttendanceData($data)
    {
        $this->db->insert('attendance', $data);
    }
    public function bulk_insert($data)
    {
        $this->db->insert_batch('attendance', $data);
    }
    public function em_attendance()
    {
        $sql    = "SELECT `attendance`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `attendance`
      LEFT JOIN `employee` ON `attendance`.`emp_id`=`employee`.`em_code` WHERE `attendance`.`status` = 'A' ORDER BY `attendance`.`id` DESC";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function em_attendanceFor($id)
    {
      $sql    = "SELECT `attendance`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `attendance`
      LEFT JOIN `employee` ON `attendance`.`emp_id`=`employee`.`em_code` 
      WHERE `attendance`.`id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Update_AttendanceData($id, $attdate, $data)
    {
        $this->db->where('emp_id', $id);
        $this->db->where('atten_date', $attdate);
        $this->db->update('attendance', $data);
    }
    public function Copy_AttendanceData($source_emp_id, $destination_emp_id, $month_year)
    {
        // 1. Fetch the attendance data for the given employee ID and month-year
        $this->db->select('*');
        $this->db->from('attendance');
        $this->db->where('emp_id', $source_emp_id);
        $this->db->where("DATE_FORMAT(atten_date, '%Y-%m') =", $month_year);
        $query = $this->db->get();
        
        // 2. Prepare and insert the data
        $attendance_data = $query->result_array();
        foreach ($attendance_data as &$row) {
            unset($row['id']); // Remove the 'id' field to avoid auto-increment conflicts
            $row['emp_id'] = $destination_emp_id; // Set the new employee ID
        }
        
      // 3. Check if data for the new employee ID already exists
      if (!empty($attendance_data)) {
        $this->db->select('1'); // We just need to check existence, so select a single column
        $this->db->from('attendance');
        $this->db->where('emp_id', $destination_emp_id);
        $this->db->where("DATE_FORMAT(atten_date, '%Y-%m') =", $month_year);
        $existing_query = $this->db->get();

        if ($existing_query->num_rows() == 0) {
            // Data does not exist, perform the insertion
            $this->db->insert_batch('attendance', $attendance_data);
        } else {
            return "Attendance Already Exists";
        }
    }
  }
    

    public function bulk_Update($emid,$date,$data)
    {
        $this->db->where('emp_id', $emid);
        $this->db->where('atten_date', $date);
        $this->db->update('attendance', $data);
    }

    public function getPINFromID($employee_ID) {
      $sql = "SELECT `em_code` FROM `employee`
      WHERE `em_id`='$employee_ID'";
      $query=$this->db->query($sql);
      $result = $query->row();
      return $result;
    }

    public function getDuplicateVal($emid,$date) {
      $sql = "SELECT * FROM `attendance`
      WHERE `emp_id`='$emid' AND `atten_date`='$date'";
      $query=$this->db->query($sql);
      $result = $query->row();
      return $result;
    }

    public function getAttendanceDataByID($employee_id, $date_from, $date_to)
    {
      $sql    = "SELECT `attendance`.*,
      `employee`.`em_id`, CONCAT(`first_name`, ' ', `last_name`) AS name,`em_code`, TRUNCATE((ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )))/3600, 1) AS Hours
      FROM `attendance`
      LEFT JOIN `employee` ON `attendance`.`emp_id` = `employee`.`em_code` 
      WHERE (`attendance`.`emp_id` = '$employee_id') AND (`atten_date` BETWEEN '$date_from' AND '$date_to') AND (`attendance`.`status` = 'A')";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getTotalAttendanceDataByID($employee_PIN, $date_from, $date_to)
    {
      $sql = "SELECT TRUNCATE((SUM(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )))/3600), 1) AS Hours FROM `attendance` WHERE (`attendance`.`emp_id`='$employee_PIN') AND (`atten_date` BETWEEN '$date_from' AND '$date_to') AND (`attendance`.`status` = 'A')";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllAttendance()
    {
      $sql = "SELECT `attendance`.`id`, `emp_id`, `atten_date`, `signin_time`, `signout_time`,  TRUNCATE(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )/3600), 1) AS Hours,
        CONCAT(`first_name`, ' ', `last_name`) AS name
       FROM `attendance`
        LEFT JOIN `employee` ON `attendance`.`emp_id` = `employee`.`em_code`
        WHERE `attendance`.`status` = 'A'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllAttendanceMonth($month, $employee_id)
    {
        $sql = "SELECT `attendance`.`id`, `attendance`.`emp_id`, `atten_date`, `signin_time`, `signout_time`, `break`,
                working_hour AS Hours, `emp_salary`.`total`,`emp_salary`.`hourly_bonus`,`emp_salary`.`hourly_bonus2`,`emp_salary`.`daily_bonus`,`emp_salary`.`off_day`,
                CONCAT(`first_name`, ' ', `last_name`) AS name, 
                `emp_salary`.`work_hours`
                FROM `attendance`
                LEFT JOIN `employee` ON `attendance`.`emp_id` = `employee`.`em_code`
                LEFT JOIN `emp_salary` ON `attendance`.`emp_id` = `emp_salary`.`emp_code`
                WHERE `attendance`.`status` = 'A' 
                AND (`attendance`.`emp_id` = '$employee_id')
                AND DATE_FORMAT(atten_date, '%Y-%m') = ?";
        $query  = $this->db->query($sql, array($month));
        $result = $query->result();
        return $result;
    }
}



?>