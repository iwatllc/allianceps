<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller
{
	// Used for adding users
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('DX_Auth');
		$this->load->library('user_agent');
		// $this->load->library('Oauth2_lib');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
	}
	
	function index()
	{
		$this->users();
	}


	function nationbuilder()
	{
		$this->load->model('configsys/configsys_model');

		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author'),
			'page_title' => 'Manage NationBuilder Integration',
		);
		$data['page_data'] = $view_vars;

		// handle form submission
		if ($this->input->post('save'))
		{
			// Store form input
			$this->configsys_model->set_value('nationbuilder_enabled', $this->input->post('nb_enabled'));
			$this->configsys_model->set_value('nationbuilder_slug', $this->input->post('slug'));
			$this->configsys_model->set_value('nationbuilder_client_id', $this->input->post('client_id'));
			$this->configsys_model->set_value('nationbuilder_client_secret', $this->input->post('client_secret'));
		}

		// Retreive form values
		$form_vars = array(
			'enabled' => $this->configsys_model->get_value('nationbuilder_enabled'),
			'slug' => $this->configsys_model->get_value('nationbuilder_slug'),
			'client_id' => $this->configsys_model->get_value('nationbuilder_client_id'),
			'client_secret' => $this->configsys_model->get_value('nationbuilder_client_secret'),
			'token_success' => false,
			'access_token' => $this->configsys_model->get_value('nationbuilder_access_token'),
			'auth_url' => '#'
		);

		require_once 'vendor/adoy/oauth2/src/OAuth2/Client.php';
		require_once 'vendor/adoy/oauth2/src/OAuth2/GrantType/IGrantType.php';
		require_once 'vendor/adoy/oauth2/src/OAuth2/GrantType/AuthorizationCode.php';

		// Create the OAuth2 client
		$client = new OAuth2\Client($form_vars['client_id'], $form_vars['client_secret']);

		// Generate the auth url
		$redirectUrl    = base_url() . 'security/backend/nationbuilder';
		$authorizeUrl   = 'https://' . $form_vars['slug'] . '.nationbuilder.com/oauth/authorize';
		$authUrl = $client->getAuthenticationUrl($authorizeUrl, $redirectUrl);
		$form_vars['auth_url'] = $authUrl;

		// handle oauth callback
		if ($this->input->get('code'))
		{
			// Grab the code param and use it to request a token
			$code = $this->input->get('code');
			$accessTokenUrl = 'https://' . $form_vars['slug'] . '.nationbuilder.com/oauth/token';
			$params = array('code' => $code, 'redirect_uri' => $redirectUrl);
			$response = $client->getAccessToken($accessTokenUrl, 'authorization_code', $params);

			// Store the access token if response was valid
			if($response['code'] == 200) {
				$this->configsys_model->set_value('nationbuilder_access_token', $response['result']['access_token']);
				$form_vars['access_token'] = $response['result']['access_token'];
				$form_vars['token_success'] = true;
			}
			// TODO: handle response code other than 200.
		}

		$data['form_vars'] = $form_vars;
		
		// Load view
		$this->load->view('backend/nationbuilder', $data);
	}
	
	function users()
	{
		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author'),
			'page_title' => 'Manage Users'
		);
		$data['page_data'] = $view_vars;

		$this->load->model('users', 'users');			
		
		// Search checkbox in post array
		foreach ($_POST as $key => $value)
		{
			// If checkbox found
			if (substr($key, 0, 9) == 'checkbox_')
			{
				// If ban button pressed
				if (isset($_POST['ban']))
				{
					// Ban user based on checkbox value (id)
					$this->users->ban_user($value);
				}
				// If unban button pressed
				else if (isset($_POST['unban']))
				{
					// Unban user
					$this->users->unban_user($value);
				}
                // If delete button pressed
                else if (isset($_POST['delete_user']))
                {
                    // Unban user
                    $this->users->delete_user($value);
                }
				else if (isset($_POST['reset_pass']))
				{
					// Set default message
					$data['reset_message'] = 'Reset password failed';
				
					// Get user and check if User ID exist
					if ($query = $this->users->get_user_by_id($value) AND $query->num_rows() == 1)
					{		
						// Get user record				
						$user = $query->row();
						
						// Create new key, password and send email to user
						if ($this->dx_auth->forgot_password($user->username))
						{
							// Query once again, because the database is updated after calling forgot_password.
							// $query = $this->users->get_user_by_id($value);
							// Get user record
							// $user = $query->row();
														
							// Reset the password
							// if ($this->dx_auth->reset_password($user->username, $user->newpass_key))
							// {
							// 	$data['reset_message'] = 'Reset password success';
							// }
						}
					}
				}
			}				
		}
		
		/* Showing page to user */
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 10;
		
		// Get all users
		$data['users'] = $this->users->get_all($offset, $row_count)->result();
		
		// Pagination config
		$p_config['base_url'] = '/backend/users/';
		$p_config['uri_segment'] = 3;
		$p_config['num_links'] = 2;
		$p_config['total_rows'] = $this->users->get_all()->num_rows();
		$p_config['per_page'] = $row_count;
				
		// Init pagination
		$this->pagination->initialize($p_config);		
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links();
		
		// Load view
		$this->load->view('backend/users', $data);
	}
	
	function unactivated_users()
	{
		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author')
		);
		$data['page_data'] = $view_vars;

		$this->load->model('user_temp', 'user_temp');
		
		/* Database related */
		
		// If activate button pressed
		if ($this->input->post('activate'))
		{
			// Search checkbox in post array
			foreach ($_POST as $key => $value)
			{
				// If checkbox found
				if (substr($key, 0, 9) == 'checkbox_')
				{
					// Check if user exist, $value is username
					if ($query = $this->user_temp->get_login($value) AND $query->num_rows() == 1)
					{
						// Activate user
						$this->dx_auth->activate($value, $query->row()->activation_key);
					}
				}				
			}
		}
		
		/* Showing page to user */
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 10;
		
		// Get all unactivated users
		$data['users'] = $this->user_temp->get_all($offset, $row_count)->result();
		
		// Pagination config
		$p_config['base_url'] = '/backend/unactivated_users/';
		$p_config['uri_segment'] = 3;
		$p_config['num_links'] = 2;
		$p_config['total_rows'] = $this->user_temp->get_all()->num_rows();
		$p_config['per_page'] = $row_count;
				
		// Init pagination
		$this->pagination->initialize($p_config);		
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links();
		
		// Load view
		$this->load->view('backend/unactivated_users', $data);
	}
	
	function roles()
	{
		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author')
		);
		$data['page_data'] = $view_vars;

		$this->load->model('roles', 'roles');
		
		/* Database related */
					
		// If Add role button pressed
		if ($this->input->post('add'))
		{
			// Create role
			$this->roles->create_role($this->input->post('role_name'), $this->input->post('role_parent'));
		}
		else if ($this->input->post('delete'))
		{				
			// Loop trough $_POST array and delete checked checkbox
			foreach ($_POST as $key => $value)
			{
				// If checkbox found
				if (substr($key, 0, 9) == 'checkbox_')
				{
					// Delete role
					$this->roles->delete_role($value);
				}				
			}
		}

		/* Showing page to user */
	
		// Get all roles from database
		$data['roles'] = $this->roles->get_all()->result();
		
		// Load view
		$this->load->view('backend/roles', $data);
	}
	
	function uri_permissions()
	{
		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author')
		);
		$data['page_data'] = $view_vars;

		function trim_value(&$value) 
		{ 
			$value = trim($value); 
		}
	
		$this->load->model('roles', 'roles');
		$this->load->model('permissions', 'permissions');
		
		if ($this->input->post('save'))
		{
			// Convert back text area into array to be stored in permission data
			$allowed_uris = explode("\n", $this->input->post('allowed_uris'));
			
			// Remove white space if available
			array_walk($allowed_uris, 'trim_value');
		
			// Set URI permission data
			// IMPORTANT: uri permission data, is saved using 'uri' as key.
			// So this key name is preserved, if you want to use custom permission use other key.
			$this->permissions->set_permission_value($this->input->post('role'), 'uri', $allowed_uris);
		}
		
		/* Showing page to user */		
		
		// Default role_id that will be showed
		$role_id = $this->input->post('role') ? $this->input->post('role') : 1;
		
		// Get all role from database
		$data['roles'] = $this->roles->get_all()->result();
		// Get allowed uri permissions
		$data['allowed_uris'] = $this->permissions->get_permission_value($role_id, 'uri');
		
		// Load view
		$this->load->view('backend/uri_permissions', $data);
	}
	
	function custom_permissions()
	{
		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author')
		);
		$data['page_data'] = $view_vars;

		// Load models
		$this->load->model('roles', 'roles');
		$this->load->model('permissions', 'permissions');
	
		/* Get post input and apply it to database */
		
		// If button save pressed
		if ($this->input->post('save'))
		{
			// Note: Since in this case we want to insert two key with each value at once,
			// it's not advisable using set_permission_value() function						
			// If you calling that function twice that means, you will query database 4 times,
			// because set_permission_value() will access table 2 times, 
			// one for get previous permission and the other one is to save it.
			
			// For this case (or you need to insert few key with each value at once) 
			// Use the example below
		
			// Get role_id permission data first. 
			// So the previously set permission array key won't be overwritten with new array with key $key only, 
			// when calling set_permission_data later.
			$permission_data = $this->permissions->get_permission_data($this->input->post('role'));
		
			// Set value in permission data array
			$permission_data['edit'] = $this->input->post('edit');
			$permission_data['delete'] = $this->input->post('delete');
			
			// Set permission data for role_id
			$this->permissions->set_permission_data($this->input->post('role'), $permission_data);
		}
	
		/* Showing page to user */		
		
		// Default role_id that will be showed
		$role_id = $this->input->post('role') ? $this->input->post('role') : 1;
		
		// Get all role from database
		$data['roles'] = $this->roles->get_all()->result();
		// Get edit and delete permissions
		$data['edit'] = $this->permissions->get_permission_value($role_id, 'edit');
		$data['delete'] = $this->permissions->get_permission_value($role_id, 'delete');
	
		// Load view
		$this->load->view('backend/custom_permissions', $data);
	}

	function add_user()
	{
		$view_vars = array(
			'title' => $this->config->item('Company_Title'),
			'heading' => $this->config->item('Company_Title'),
			'description' => $this->config->item('Company_Description'),
			'company' => $this->config->item('Company_Name'),
			'logo' => $this->config->item('Company_Logo'),
			'author' => $this->config->item('Company_Author')
		);
		$data['page_data'] = $view_vars;

		if ( $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
		{
			$val = $this->form_validation;

			// Set form validation rules
			// Takes three parameters as input:
			// 1. field name
			// 2. human name - inserted into the error message
			// 3. validation rules
			$val->set_rules('username', 'Username', 'trim|required|min_length['.$this->min_username.']|max_length['.$this->max_username.']|alpha_dash');
			$val->set_rules('password', 'Password', 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
			$val->set_rules('confirm_password', 'Confirm Password', 'trim|required');
			$val->set_rules('email', 'Email', 'trim|required|valid_email');

			// Is registration using captcha
			if ($this->dx_auth->captcha_registration)
			{
				// Set recaptcha rules.
				// IMPORTANT: Do not change 'recaptcha_response_field' because it's used by reCAPTCHA API,
				// This is because the limitation of reCAPTCHA, not DX Auth library
				$val->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|required|callback_recaptcha_check');
			}


			// Run form validation and register user if it's pass the validation
			if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email')))
			{

				// Set success message accordingly
				if ($this->dx_auth->email_activation)
				{
					$data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
				}
				else
				{
					$data['auth_message'] = 'You have successfully registered. '.anchor(site_url($this->dx_auth->login_uri), 'Login');

					$pass = str_repeat('*', strlen ($val->set_value('password')));

					$data['add_user'] = 'You have successfully added the following user:<br/> '.
						'<br/>Username: ' . $val->set_value('username').
						'<br/>Email: ' . $val->set_value('email').
						'<br/>Password: ' . $pass;
				}

				// Load registration success page
//				$this->load->view($this->dx_auth->register_success_view, $data);

				$this->load->view('security/backend/add_user', $data);
			}
			else
			{
				// Load registration page
				$this->load->view('security/backend/add_user', $data);
			}
		}
		elseif ( ! $this->dx_auth->allow_registration)
		{
			$data['auth_message'] = 'Registration has been disabled.';
			$this->load->view($this->dx_auth->register_disabled_view, $data);
		}
		else
		{
			$data['auth_message'] = 'You have to logout first, before registering.';
			$this->load->view($this->dx_auth->logged_in_view, $data);
		}
	}
}