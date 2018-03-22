<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('clientmodel');
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->library('email', null, 'ci_email');
        $this->load->helper(array('url', 'language'));
        $this->lang->load('auth');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('sauth/login', 'refresh');
        }
    }

    public function index()
    {
        $this->load->view('clients/header');
        $this->load->view('clients/dash');
        $this->load->view('clients/footer');
    }
    public function profilepage()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $profile_isset = $this->clientmodel->issetprofile($user_id);
      if ($profile_isset == false) {
        $this->load->view('clients/header',$data);
        $this->load->view('clients/profilepage',$data);
        $this->load->view('clients/footer');
      } else {

        $data['profile'] = $this->clientmodel->viewprofile($user_id);
        $this->load->view('clients/header',$data);
        $this->load->view('clients/profileview',$data);
        $this->load->view('clients/footer');


      }
    }
    public function selectedprofile()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;
      $data['profile'] = $this->clientmodel->viewprofile($user_id);
      $this->load->view('clients/header',$data);
      $this->load->view('clients/profileview',$data);
      $this->load->view('clients/footer');

    }


    public function createprofile()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $this->form_validation->set_rules('first_name', 'First name', 'required');
      $this->form_validation->set_rules('last_name', 'Last name', 'required');
      $this->form_validation->set_rules('phone', 'Phone Number', 'required');
      $this->form_validation->set_rules('company', 'Company Name', 'required');
      $this->form_validation->set_rules('address', 'Address', 'required');

      if ($this->form_validation->run() === false) {
          // $this->session->set_flashdata('message', $this->ion_auth->errors());
          $data['message'] = $this->ion_auth->errors();
          $this->load->view('clients/header',$data);
          $this->load->view('clients/profilepage',$data);
          $this->load->view('clients/footer');
      } else {

        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'user_id' => $user->id,
        );
        var_dump($data);
        if ($this->clientmodel->creatprof($data)) {

          $this->session->set_flashdata('message', 'change is successful');
          redirect('client/profilepage', 'refresh');

        } else {
              $this->session->set_flashdata('message', 'change is not successful');
                redirect('client/profilepage', 'refresh');
            }


      }

    }

    public function updateprofile()
    {
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('company', 'Company Name', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect('client/profilepage','refresh');
        } else {

          $data = array(
              'first_name' => $this->input->post('first_name'),
              'last_name' => $this->input->post('last_name'),
              'company' => $this->input->post('company'),
              'phone' => $this->input->post('phone'),
              'address' => $this->input->post('address'),
          );

          if ($this->clientmodel->updateclient($user->id, $data)) {

              if ($this->ion_auth->is_admin()) {
                $this->session->set_flashdata('message', 'change is successful');
                  redirect('client/profilepage', 'refresh');
              } else {
                  redirect('sauth', 'refresh');
              }
          } else {
              // redirect them back to the admin page if admin, or to the base url if non admin
              if ($this->ion_auth->is_admin()) {
                $this->session->set_flashdata('message', 'change is not successful');
                  redirect('client/profilepage', 'refresh');
              } else {
                  redirect('sauth', 'refresh');
              }
          }

        }



    }
    public function login()
    {
        $this->load->view('client/login');
    }

    public function dash()
    {
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;
        $data['user'] = $user;
        $data['mission'] = $this->clientmodel->viewmision($user_id);
        $this->load->view('clients/header',$data);
        $this->load->view('clients/dash',$data); // page for dashboard
        $this->load->view('clients/footer');
    }
    public function dash2()
    {
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;
        $data['user'] = $user;
        $data['mission'] = $this->clientmodel->viewallmision();
        $this->load->view('clients/header',$data);
        $this->load->view('clients/dash2',$data); // page for dashboard
        $this->load->view('clients/footer');
    }

    public function addprofile()
    {
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;
        $data['user'] = $user;

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === false) {
            $this->load->view('clients/header');
            $this->load->view('clients/'); //page to show profile
            $this->load->view('clients/footer');
        } else {
            $this->load->view('clients/header');
            $this->load->view('clients/'); //page to view profile
            $this->load->view('clients/footer');
        }
    }

    public function viewprofile()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $this->load->view('clients/header');
      $this->load->view('clients/'); //page to show profile
      $this->load->view('clients/footer');
    }
    public function makereq()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;
      $this->load->view('clients/header', $data);
      $this->load->view('clients/makereq', $data); //page to view profile
      $this->load->view('clients/footer');
    }

    public function makerequest()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $this->form_validation->set_rules('subject', 'Subject', 'required');
      $this->form_validation->set_rules('body', 'Body', 'required');
      $this->form_validation->set_rules('mission', 'Mission', 'required');

      if ($this->form_validation->run() === false) {
          $this->load->view('clients/header', $data);
          $this->load->view('clients/makereq' ,$data); //page to show profile
          $this->load->view('clients/footer');
      } else {
          // $subject = $this->input->post('subject');
          // $body = $this->input->post('body');
          // $mission = $this->input->post('mission');
          $date = date("Y-m-d h:i:sa");
          $nwreq = array(
            'subject' => $this->input->post('subject'),
            'body' => $this->input->post('body'),
            'mission' => $this->input->post('mission'),
            'user_id' => $user_id,
            'create_time' => $date,
          );

          $req = $this->clientmodel->createmision($nwreq);
          if($req == TRUE){
            $data['message'] = "Your request has been created, We will get in touch with you";
            $this->load->view('clients/header', $data);
            $this->load->view('clients/makereq', $data); //page to view profile
            $this->load->view('clients/footer');
          }
          else {
            $data['message'] = "Your request cannot be created at this time, please try again";
            $this->load->view('clients/header', $data);
            $this->load->view('clients/makereq', $data); //page to view profile
            $this->load->view('clients/footer');
          }

      }

    }

    public function updaterequest()
    {
        $req_id = $this->uri->segment(3);
        $user = $this->ion_auth->user()->row();
        $user_id = $user->id;
        $data['user'] = $user;

        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        $this->form_validation->set_rules('mission', 'Mission', 'required');
        // $this->form_validation->set_rules('req_id', 'req_id', 'required');

        if ($this->form_validation->run() === false) {
          $data['message'] = "Your request cannot be Updated at this time, please try again";
            redirect('client/viewrequest','refresh');
        } else {
            // $subject = $this->input->post('subject');
            // $body = $this->input->post('body');
            // $mission = $this->input->post('mission');
            echo $req_id;
            $date = date("Y-m-d h:i:sa");
            $nwreq = array(
              'id'=> $req_id,
              'subject' => $this->input->post('subject'),
              'body' => $this->input->post('body'),
              'mission' => $this->input->post('mission'),
              'user_id' => $user_id,
              'update_time' => $date,
              'create_time' => $date,

            );
            // $data1 = $this->clientmodel->onemision($user_id,$this->input->post('req_id'));
            var_dump($this->input->post('req_id'));
            $req = $this->clientmodel->updatemision($nwreq,$data1);
            if($req == TRUE){
              $data['message'] = "Your request has been Updated, We will get in touch with you";
              redirect('client/viewrequest', 'refresh');
            }
            else {
              $data['message'] = "Your request cannot be Updated at this time, please try again";
              redirect('client/viewrequest', 'refresh');
            }

        }

    }
    public function editrequest()
    {
      $req_id = $this->uri->segment(3);
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $data['mission'] = $this->clientmodel->onemision($user_id,$req_id);

      $this->load->view('clients/header', $data);
      $this->load->view('clients/', $data); //page to show profile
      $this->load->view('clients/footer');
    }

    public function deleterequest()
    {
      $req_id = $this->uri->segment(3);

      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;
      $delmission = $this->clientmodel->deletemision($user_id, $req_id);
      $data['mission'] = $this->clientmodel->viewmision($user_id);

      if ($delmission == TRUE) {
        $data['message'] = "Delete is Successful";
        $this->load->view('clients/header', $data);
        $this->load->view('clients/viewreq', $data); //page to show profile
        $this->load->view('clients/footer');
      } else {
        $data['message'] = "Delete Not Successful";
        $this->load->view('clients/header', $data);
        $this->load->view('clients/viewreq', $data); //page to show profile
        $this->load->view('clients/footer');
      }


    }
    public function onerequest()
    {
      $req_id = $this->uri->segment(3);
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $data['mission'] = $this->clientmodel->onemision($user_id,$req_id);
      // var_dump($data);
      $this->load->view('clients/header', $data);
      $this->load->view('clients/viewonereq', $data); //page to show profile
      $this->load->view('clients/footer');
    }

    public function viewrequest()
    {
      $user = $this->ion_auth->user()->row();
      $user_id = $user->id;
      $data['user'] = $user;

      $data['mission'] = $this->clientmodel->viewmision($user_id);

      // var_dump($data);
      $this->load->view('clients/header', $data);
      $this->load->view('clients/viewreq', $data); //page to show profile
      $this->load->view('clients/footer');
    }

}
