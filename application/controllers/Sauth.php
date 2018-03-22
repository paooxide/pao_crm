<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Sauth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->library('email', NULL, 'ci_email');
        $this->load->helper(array('url', 'language'));
        // $this->load->model('gitmodel');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('sauth/login', 'refresh');
        } elseif ($this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the administrator dash
            // $this->$this->load->view('patients_dash');
            redirect('admin/dash', 'refresh');
        } elseif ($this->ion_auth->in_group('members')) { // remove this elseif if you want to enable this for
            // redirect them to the patients dash
            // $this->$this->load->view('patients_dash');
            // redirect('client/dash', 'refresh');
        }
        else {
            // redirect them to back to the login page
            // return show_error('You must be Logged In to view this page.');
            redirect('client/dash', 'refresh');
        }
    }

    public function login()
    {
        // $this->data['title'] = $this->lang->line('login_heading');

        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('sauth', 'refresh');
                // echo "you are logged in";
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('client/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );

            $this->load->view('clients/login', $this->data);
            // $this->_render_page('access/login', $this->data);
      // echo "you are not logged in";
        }
    }

    public function logout()
    {
        // $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('sauth/login', 'refresh');
    }

    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('sauth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === false) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            // render
            $this->_render_page('access/changepass', $this->data);
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('sauth/change_password', 'refresh');
            }
        }
    }


    public function create_user()
    {

  		// validate form input
  		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
  		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
  		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
  		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
  		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
  		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
  		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        // $this->form_validation->set_rules('group', 'required');

        if ($this->form_validation->run() === true) {
            $email = strtolower($this->input->post('email'));
            $identity = $email;
            $password = $this->input->post('password');
            // $group = $this->input->post('group');
            $group = array($this->input->post('group'));

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );
        }
        $group = 2;
        if ($this->form_validation->run() === true && $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("sauth", 'refresh');
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->_render_page('clients/signup', $this->data);
        }
    }
    public function signup()
    {
        $this->load->view('clients/signup');
    }
    public function edit_user($id)
    {

        $this->data['title'] = $this->lang->line('edit_user_heading');


        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === true) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                );

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }

                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    // Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {
                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        redirect('sauth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    if ($this->ion_auth->is_admin()) {
                        redirect('sauth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }

        // display the edit user form
        // $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name'  => 'company',
            'id'    => 'company',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id'   => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id'   => 'password_confirm',
            'type' => 'password'
        );

        $this->_render_page('clients/profilepage', $this->data);
    }

    public function _render_page($view, $data = null, $returnhtml = false)//I think this makes more sense
    {
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        // This will return html on 3rd argument being true
        if ($returnhtml) {
            return $view_html;
        }
    }



    /**
  	 * Forgot password
  	 */
  	public function forgot_password()
  	{
  		// setting validation rules by checking whether identity is username or email
  		if ($this->config->item('identity', 'ion_auth') != 'email')
  		{
  			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
  		}
  		else
  		{
  			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
  		}


  		if ($this->form_validation->run() === FALSE)
  		{
  			$this->data['type'] = $this->config->item('identity', 'ion_auth');
  			// setup the input
  			$this->data['identity'] = array('name' => 'identity',
  				'id' => 'identity',
  			);

  			if ($this->config->item('identity', 'ion_auth') != 'email')
  			{
  				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
  			}
  			else
  			{
  				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
  			}

  			// set any errors and display the form
  			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
  			$this->_render_page('access/forgot_pass', $this->data);
  		}
  		else
  		{
  			$identity_column = $this->config->item('identity', 'ion_auth');
  			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

  			if (empty($identity))
  			{

  				if ($this->config->item('identity', 'ion_auth') != 'email')
  				{
  					$this->ion_auth->set_error('forgot_password_identity_not_found');
  				}
  				else
  				{
  					$this->ion_auth->set_error('forgot_password_email_not_found');
  				}

  				$this->session->set_flashdata('message', $this->ion_auth->errors());
  				redirect("sauth/forgot_password", 'refresh');
  			}

  			// run the forgotten password method to email an activation code to the user
  			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
        $userid = $identity->{$this->config->item('identity', 'ion_auth')} ;

        //write db method to fetch code
        $res = $this->gitmodel->getcode($userid);
        $code = $res->forgotten_password_code;
        $aemail = $res->email;
        $data['link'] = 'http://client.osecnigeria.com.ng/index.php/sauth/reset/'.$code;

        $message = $this->load->view('email_forgpass', $data, TRUE);

        $this->ci_email->set_mailtype('html');
        $this->ci_email->from('info@osecnigeria.com.ng', 'OSEC');
        $this->ci_email->to($aemail);
        $this->ci_email->subject('Password Reset Confirmation');
        $this->ci_email->message($message);
        $this->ci_email->send();

  			if ($forgotten)
  			{
  				// if there were no errors
  				$this->session->set_flashdata('message', $this->ion_auth->messages());

          #########//we should display a confirmation page here instead of the login page
          redirect("user/reset", 'refresh');
  			}
  			else
  			{
  				$this->session->set_flashdata('message', $this->ion_auth->errors());
  				redirect("sauth/forgot_password", 'refresh');
  			}
  		}
  	}



    public function reset()
    {
      $code = $this->uri->segment(3);

      if (!$code)
      {
        show_404();
      }

      $user = $this->ion_auth->forgotten_password_check($code);

      if ($user)
      {
        // if the code is valid then display the password reset form

        $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

        if ($this->form_validation->run() === FALSE)
        {
          // display the form

          // set the flash data error message if there is one
          $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

          $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
          $this->data['new_password'] = array(
            'name' => 'new',
            'id' => 'new',
            'type' => 'password',
            'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
          );
          $this->data['new_password_confirm'] = array(
            'name' => 'new_confirm',
            'id' => 'new_confirm',
            'type' => 'password',
            'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
          );
          $this->data['user_id'] = array(
            'name' => 'user_id',
            'id' => 'user_id',
            'type' => 'hidden',
            'value' => $user->id,
          );
          // $this->data['csrf'] = $this->_get_csrf_nonce();
          $this->data['code'] = $code;

          // render
          $this->_render_page('access/reset', $this->data);
        }
        else
        {
          // do we have a valid request?
          if ( $user->id != $this->input->post('user_id'))
          {

            // something fishy might be up
            $this->ion_auth->clear_forgotten_password_code($code);

            // show_error($this->lang->line('error_csrf'));

          }
          else
          {
            // finally change the password
            $identity = $user->{$this->config->item('identity', 'ion_auth')};

            $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

            if ($change)
            {
              // if the password was successfully changed
              $this->session->set_flashdata('message', $this->ion_auth->messages());
              redirect("sauth/login", 'refresh');
            }
            else
            {
              $this->session->set_flashdata('message', $this->ion_auth->errors());
              redirect('user/forgot_pass/', 'refresh');
            }
          }
        }
      }
      else
      {
        // if the code is invalid then send them back to the forgot password page
        $this->session->set_flashdata('message', $this->ion_auth->errors());
        redirect("user/forgot_pass
        ", 'refresh');
      }
    }


public function test()
{
    $this->load->view('access/reset');
}



}
