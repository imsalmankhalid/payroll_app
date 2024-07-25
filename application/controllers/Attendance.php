<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('loan_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('attendance_model');
        $this->load->model('project_model');
        $this->load->library('csvimport');
    }
    
    public function Attendance()
    {
        if ($this->session->userdata('user_login_access') != False) {
            #$data['employee'] = $this->employee_model->emselect();
            $data['attendancelist'] = $this->attendance_model->getAllAttendance();
            $this->load->view('backend/attendance', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function AttendancebyMonth()
    {
        if ($this->session->userdata('user_login_access') != False) {
            #$data['employee'] = $this->employee_model->emselect();
            $month=$this->input->get('month');
            $em_id=$this->input->get('employee_id');
            $data['attendancelist'] = $this->attendance_model->getAllAttendanceMonth($month,  $em_id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Save_Attendance()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselect();
            $id               = $this->input->get('A');
            if (!empty($id)) {
                $data['attval'] = $this->attendance_model->em_attendanceFor($id);
            }
            #$data['attendancelist'] = $this->attendance_model->em_attendance();
            $this->load->view('backend/add_attendance', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Save_Attendance_Month()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselect();
            $id               = $this->input->get('A');
            if (!empty($id)) {
                $data['attval'] = $this->attendance_model->em_attendanceFor($id);
            }
            #$data['attendancelist'] = $this->attendance_model->em_attendance();
            $this->load->view('backend/add_attendance_month', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Attendance_Report()
    {
        if ($this->session->userdata('user_login_access') != False) {
            
            $data['employee'] = $this->employee_model->emselect();
            $id               = $this->input->get('A');
            if (!empty($id)) {
                $data['attval'] = $this->attendance_model->em_attendanceFor($id);
            }
            
            $this->load->view('backend/attendance_report', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function getPINFromID($employee_ID) {
        return $this->attendance_model->getPINFromID($employee_ID);
    }
    
    public function Get_attendance_data_for_report()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $date_from   = $this->input->post('date_from');
            $date_to   = $this->input->post('date_to');
            $employee_id   = $this->input->post('employee_id');
            $employee_PIN = $this->getPINFromID($employee_id)->em_code;
            $attendance_data = $this->attendance_model->getAttendanceDataByID($employee_PIN, $date_from, $date_to);
            $data['attendance'] = $attendance_data;
            $attendance_hours = $this->attendance_model->getTotalAttendanceDataByID($employee_PIN, $date_from, $date_to);
            if(!empty($attendance_data)){
            $data['name'] = $attendance_data[0]->name;
            $data['days'] = count($attendance_data);
            $data['hours'] = $attendance_hours;                
            }
            echo json_encode($data);

            /*foreach ($attendance_data as $row) {
                $row =  
                    "<tr>
                        <td>$numbering</td>
                        <td>$row->first_name $row->first_name</td>
                        <td>$row->atten_date</td>
                        <td>$row->signin_time</td>
                        <td>$row->signout_time</td>
                        <td>$row->working_hour</td>
                        <td>Type</td>
                    </tr>";
            }*/
            
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function Add_Attendance()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id      = $this->input->post('id');
            $em_id   = $this->input->post('emid');
            $attdate = $this->input->post('attdate');
            $signin  = $this->input->post('signin');
            $signout = $this->input->post('signout');
            $place = $this->input->post('place');

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('attdate', 'Date details', 'trim|required|xss_clean');
            $this->form_validation->set_rules('emid', 'Employee', 'trim|required|xss_clean');
            $old_date           = $attdate; // returns Saturday, January 30 10 02:06:34
            $old_date_timestamp = strtotime($old_date);
            $new_date           = date('m/d/Y', $old_date_timestamp);

            // CHANGING THE DATE FORMAT FOR DB UTILITY
            $new_date_changed = date('Y-m-d', strtotime(str_replace('-', '/', $new_date)));
            
            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
                #redirect("loan/View");
            } else {
                $sin  = new DateTime($new_date . $signin);
                $sout = new DateTime($new_date . $signout);
                $hour = $sin->diff($sout);
                $work = $hour->format('%H h %i m');
                if (empty($id)) {
                    $day = date("D", strtotime($new_date_changed));

                        $holiday = $this->leave_model->get_holiday_between_dates($new_date_changed);
                        if($holiday) {                     
                            echo "Holiday on this date";
                        } else {
                        $duplicate = $this->attendance_model->getDuplicateVal($em_id,$new_date_changed);
                        //print_r($duplicate);
                        if(!empty($duplicate)){
                            echo "Duplicate - Already Exist";
                        } else {
                            //$date = date('Y-m-d', $i);
                        
                            $data = array();
                            $data = array(
                                    'emp_id' => $em_id,
                                'atten_date' => $new_date_changed,
                                'signin_time' => $signin,
                                'signout_time' => $signout,
                                'working_hour' => $work,
                                'place' => $place,
                                'status' => 'A'
                                );
                            $this->attendance_model->Add_AttendanceData($data);
                            echo "Successfully added.";
                        }
                    }
                }
            }
        }
    }
    public function Add_Attendance_Month()
    {
            if ($this->session->userdata('user_login_access') != False) {
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters();
                
                // Get data from $_POST array
                $em_id   = $this->input->post('emid');
                $selected_month = $this->input->post('selected_month');
                $place = $this->input->post('place');
                
                // Iterate through each day's attendance data
                foreach ($this->input->post('attendance') as $day => $data) {
                    $attdate = $selected_month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT); // Format the date
                    $signin  = $data['signin'];
                    $signout = $data['signout'];
                    $break = $data['break'];
        
                    // Perform necessary validations
                    $this->form_validation->set_rules('emid', 'Employee ID', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('attendance[' . $day . '][signin]', 'Sign In Time for Day ' . $day, 'trim|required|xss_clean');
                    $this->form_validation->set_rules('attendance[' . $day . '][signout]', 'Sign Out Time for Day ' . $day, 'trim|required|xss_clean');
                    $this->form_validation->set_rules('attendance[' . $day . '][break]', 'Sign Out Time for Day ' . $day, 'trim|required|xss_clean');
                    // Add more rules as needed
        
                    if ($this->form_validation->run() == FALSE) {
                        echo validation_errors();
                        // Handle validation errors
                    } else {
                        // Process the data
                        $sin  = new DateTime($attdate . ' ' . $signin);
                        $sout = new DateTime($attdate . ' ' . $signout);
                       
                        $interval = $sin->diff($sout);  // Get the difference between sign in and sign out times
                        $totalMinutes = ($interval->h * 60) + $interval->i - $break;  // Convert to minutes and subtract break time
                        
                        $hours = floor($totalMinutes / 60);
                        $minutes = $totalMinutes % 60;
                        $interval = new DateInterval('PT' . $hours . 'H' . $minutes . 'M');
                        $work = $interval->format('%H h %I m');
        
                        // Prepare data for insertion into the database
                        $data = array(
                            'emp_id' => $em_id,
                            'atten_date' => $attdate,
                            'signin_time' => $signin,
                            'signout_time' => $signout,
                            'working_hour' => $work,
                            'place' => $place,
                            'status' => 'A' // Assuming 'A' stands for 'Active'
                        );
        
                        // Insert data into the database
                        $this->attendance_model->Add_AttendanceData($data);
        
                        echo "Attendance data added successfully for Day " . $day . ".<br>";
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }    

    }

    public function Add_Attendance_Month2()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            print_r($this->input->post());
            // Get individual input values from the form
            $em_id = $this->input->post('emid');
            $attdate = $this->input->post('attendance_date');
            $signin = $this->input->post('signin_time');
            $signout = $this->input->post('signout_time');
            $place = $this->input->post('place');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
                // Handle validation errors
            } else {
                // Process the data
                $sin  = new DateTime($attdate . ' ' . $signin);
                $sout = new DateTime($attdate . ' ' . $signout);
                $hour = $sin->diff($sout);
                $work = $hour->format('%H h %i m');

                // Prepare data for insertion into the database
                $data = array(
                    'emp_id' => $em_id,
                    'atten_date' => $attdate,
                    'signin_time' => $signin,
                    'signout_time' => $signout,
                    'working_hour' => $work,
                    'place' => $place,
                    'status' => 'A' // Assuming 'A' stands for 'Active'
                );

                // Insert data into the database
                $this->attendance_model->Add_AttendanceData($data);

                echo "Attendance data added successfully.";
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

        
    function import()
    {
        $this->load->library('csvimport');
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        //echo $file_data;
        foreach ($file_data as $row){
            if($row["Check-in at"] > '0:00:00'){
                $date = date('Y-m-d',strtotime($row["Date"]));
                $duplicate = $this->attendance_model->getDuplicateVal($row["Employee No"],$date);
                //print_r($duplicate);
            if(!empty($duplicate)){
            $data = array();
            $data = array(
                'signin_time' => $row["Check-in at"],
                'signout_time' => $row["Check-out at"],
                'working_hour' => $row["Work Duration"],
                'absence' => $row["Absence Duration"],
                'overtime' => $row["Overtime Duration"],
                'status' => 'A',
                'place' => 'office'
            );
            $this->attendance_model->bulk_Update($row["Employee No"],$date,$data);
            } else {
            $data = array();
            $data = array(
                'emp_id' => $row["Employee No"],
                'atten_date' => date('Y-m-d',strtotime($row["Date"])),
                'signin_time' => $row["Check-in at"],
                'signout_time' => $row["Check-out at"],
                'working_hour' => $row["Work Duration"],
                'absence' => $row["Absence Duration"],
                'overtime' => $row["Overtime Duration"],
                'status' => 'A',
                'place' => 'office'
            ); 
                    //echo count($data); 
        $this->attendance_model->Add_AttendanceData($data);          
        }
        }
            else {

            }
        }
         echo "successfully Updated"; 
        }

}
?>
