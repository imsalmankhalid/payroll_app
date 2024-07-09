<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
    }

    public function index() {
        # Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $data = array();
        #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
        $this->load->view('login');
    }

    public function All_notice() {
        if ($this->session->userdata('user_login_access') != False) {
            $data['notice'] = $this->notice_model->GetNotice();
            $this->load->view('backend/notice', $data);
        } else {
            redirect(base_url(), 'refresh');
        }        
    }

    public function Published_Notice() {
        if($this->session->userdata('user_login_access') != False) {    
            $title = $this->input->post('title');
            $text = $this->input->post('text');
            $date = $this->input->post('nodate');

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('title', 'title', 'trim|required|min_length[25]|max_length[150]|xss_clean');
            $this->form_validation->set_rules('text', 'text', 'trim|required|min_length[25]|max_length[500]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array(
                    'title' => $title,
                    'text' => $text,
                    'date' => $date
                );

                if (!empty($_FILES['file_url']['name'])) {
                    $config = array(
                        'upload_path' => "./assets/images/notice",
                        'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx",
                        'overwrite' => False,
                        'max_size' => "50720000"
                    );

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file_url')) {
                        $path = $this->upload->data();
                        $data['file_url'] = $path['file_name'];
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                $this->notice_model->Published_Notice($data);
                echo "Successfully Added";
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Update_Notice() {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $text = $this->input->post('text');
            $date = $this->input->post('nodate');
            $file_url = $_FILES['file_url']['name'];

            if ($file_url) {
                $file_name = $_FILES['file_url']['name'];
                $config = array(
                    'file_name' => $file_name,
                    'upload_path' => "./assets/images/notice",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx",
                    'overwrite' => False,
                    'max_size' => "50720000"
                );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);                
                if (!$this->upload->do_upload('file_url')) {
                    echo $this->upload->display_errors();
                    #redirect("notice/All_notice");
                } else {
                    $path = $this->upload->data();
                    $file_url = $path['file_name'];
                }
            }

            $data = array(
                'title' => $title,
                'date' => $date,
                'text' => $text,
                'file_url' => $file_url
            );

            $this->notice_model->Update_Notice($id, $data);
            echo "Notice updated successfully";
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Delete_Notice($id) {
        if ($this->session->userdata('user_login_access') != False) {
            $this->notice_model->Delete_Notice($id);
            echo "Notice deleted successfully";
            redirect("notice/All_notice");
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
