<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MX_Controller
{
    public function __construct()
    {
        if (!$this->dx_auth->is_logged_in())
        {
            // redirect to login page
            redirect('security/auth', 'refresh');
        }
        
        parent::__construct();
    }
    
    public function index()
    {
        $this -> load -> model('customer_model', NULL);

        $data['customers'] = $this -> customer_model -> get_customer_listing();
        
        $view_vars = array(
            'title' => $this->config->item('Company_Title'),
            'heading' => $this->config->item('Company_Title'),
            'description' => $this->config->item('Company_Description'),
            'company' => $this->config->item('Company_Name'),
            'logo' => $this->config->item('Company_Logo'),
            'author' => $this->config->item('Company_Author')
        );

        $data['page_data'] = $view_vars;

        $this -> load -> view('customer', $data);
    }

    public function load_add_customer()
    {
        $this -> load -> view('addcustomer');
    }
    
    public function load_edit_customer()
    {
        $this -> load -> model('customer_model', '', TRUE);
        
        $id = $this -> input -> post('id');
        
        $data['customer'] = $this -> customer_model -> get_customer($id);
        
        $this -> load -> view('editcustomer', $data);
    }
    
    public function load_add_logo()
    {
        $this -> load -> view('addlogo');
    }
    
    public function get_customer_header()
    {
        $this -> load -> model('customer_model', '', TRUE);
        
        $id = $this -> input -> post('cid');
        
        $headertext = $this -> customer_model -> get_customer($id) -> headertext;
        
        echo $headertext;
    }
    
    public function update_customer_header()
    {
        $this -> load -> model('customer_model', '', TRUE);
        
        $id = $this -> input -> post('cid');
        $data['headertext'] = $this -> input -> post('headertext');
        
        $this -> customer_model -> update_customer($id, $data);
    }

    public function get_customer_footer()
    {
        $this -> load -> model('customer_model', '', TRUE);

        $id = $this -> input -> post('cid');

        $footertext = $this -> customer_model -> get_customer($id) -> footertext;

        echo $footertext;
    }

    public function update_customer_footer()
    {
        $this -> load -> model('customer_model', '', TRUE);

        $id = $this -> input -> post('cid');
        $data['footertext'] = $this -> input -> post('footertext');

        $this -> customer_model -> update_customer($id, $data);
    }
    
    public function upload_image()
    {
        $this -> load -> model('customer_model', '', TRUE);

        if (!empty($_FILES))
        {
            // Rename the image to the customer ID followed by its extension
            $cid = $this -> input -> post('cid');
            $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            $uploadDir = 'client/uploads/';
            if (!file_exists($uploadDir))
            {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = $cid.".".$fileExtension;

            // Delete if file already exists in directory
            $mask = $uploadDir.$cid.'.*';
            array_map('unlink', glob($mask));

            // Move the file to the client/uploads/ directory
            move_uploaded_file($_FILES["file"]["tmp_name"],$uploadDir.$fileName);

            // Save the filename to the database
            $this -> customer_model -> update_logo_name($cid, $fileName);
        }
    }
    
    public function ajax_add_customer()
    {
        $this -> load -> model('customer_model', '', TRUE);

        // run form validation
        $this -> form_validation -> set_rules('customername', 'Customer Name', 'required|max_length[50]');
        $this -> form_validation -> set_rules('slug', 'Slug Name', 'required|max_length[50]');
        $this -> form_validation -> set_rules('cf1name', 'Custom Field 1 Name', 'max_length[50]');
        $this -> form_validation -> set_rules('cf2name', 'Custom Field 2 Name', 'max_length[50]');
        $this -> form_validation -> set_rules('cf3name', 'Custom Field 3 Name', 'max_length[50]');
        $this -> form_validation -> set_rules('emailaddresses', 'Email Addresses');
        $this -> form_validation -> set_rules('tid', 'Merchant TID', 'required|max_length[12]');
        $this -> form_validation -> set_rules('key', 'Key', 'required|max_length[24]');
        $this -> form_validation -> set_rules('token', 'Token', 'required|max_length[72]');
        $this -> form_validation -> set_rules('cfpercentage', 'Convenience Fee', 'numeric');

        if ($this -> form_validation -> run() == FALSE
            || $this -> customer_exists(NULL, $this->input->post('customername')) == FALSE
            || $this -> slug_exists(NULL, $this->input->post('slug')) == FALSE
            || $this -> fields_disabled($this->input->post('cf3enabled'), $this->input->post('allowach')) == FALSE
            || $this -> fields_enabled($this->input->post('allowcc'), $this->input->post('allowach')) == FALSE)
        {
            $errors = array();
            if ($this -> form_validation -> run('customername') == FALSE)
                $errors['error_customername'] = form_error('customername');
            if ($this -> customer_exists(NULL, $this -> input -> post('customername')))
                $errors['error_customername'] = '<p> Customer Name already exists in the system. Please choose a different name. </p>';
            if ($this -> form_validation -> run('slug') == FALSE)
                $errors['error_slug'] = form_error('slug');
            if ($this -> slug_exists(NULL, $this -> input -> post('slug')))
                $errors['error_slug'] = '<p> Slug Name already exists in the system. Please choose a different name. </p>';
            if ($this -> form_validation -> run('cf1name') == FALSE)
                $errors['error_cf1name'] = form_error('cf1name');
            if ($this -> form_validation -> run('cf2name') == FALSE)
                $errors['error_cf2name'] = form_error('cf2name');
            if ($this -> form_validation -> run('cf3name') == FALSE)
                $errors['error_cf3name'] = form_error('cf3name');
            if ($this -> form_validation -> run('emailaddresses') == FALSE)
                $errors['error_emails'] = form_error('emailaddresses');
            if ($this -> form_validation -> run('tid') == FALSE)
                $errors['error_tid'] = form_error('tid');
            if ($this -> form_validation -> run('key') == FALSE)
                $errors['error_key'] = form_error('key');
            if ($this -> form_validation -> run('token') == FALSE)
                $errors['error_token'] = form_error('token');
            if ($this -> form_validation -> run('cfpercentage') == FALSE)
                $errors['error_cfpercentage'] = form_error('cfpercentage');
            if ($this -> fields_disabled($this->input->post('cf3enabled'), $this->input->post('allowach')) == FALSE)
            {
                $errors['error_cf3'] = '<p> Custom Field 3 is not available when ACH is Allowed. </p>';
                $errors['error_allowach'] = '<p> ACH is not available when Custom Field 3 is Enabled. </p>';
            }
            if ($this -> fields_enabled($this->input->post('allowcc'), $this->input->post('allowach')) == FALSE)
            {
                $errors['error_allowcc'] = '<p> Either Credit Card or ACH transactions are required. </p>';
                $errors['error_allowach'] = '<p> Either Credit Card or ACH transactions are required. </p>';
            }


            echo json_encode($errors);

            return; // if form validation fails, exit to ajax success message
        }

        $customername   = $this -> input -> post('customername');
        $slugname       = $this -> input -> post('slug');

        $showname       = ($this -> input -> post('showname') == NULL ? 0 : 1);
        $showlogo       = ($this -> input -> post('showlogo') == NULL ? 0 : 1);

        $cf1enabled     = ($this -> input -> post('cf1enabled') == NULL ? 0 : 1);
        $cf2enabled     = ($this -> input -> post('cf2enabled') == NULL ? 0 : 1);
        $cf3enabled     = ($this -> input -> post('cf3enabled') == NULL ? 0 : 1);

        $cf1required    = ($this -> input -> post('cf1required') == NULL ? 0 : 1);
        $cf2required    = ($this -> input -> post('cf2required') == NULL ? 0 : 1);
        $cf3required    = ($this -> input -> post('cf3required') == NULL ? 0 : 1);

        $cf1name        = $this -> input -> post('cf1name');
        $cf2name        = $this -> input -> post('cf2name');
        $cf3name        = $this -> input -> post('cf3name');

        $allowach       = ($this -> input -> post('allowach') == NULL ? 0 : 1);
        $allowcc        = ($this -> input -> post('allowcc') == NULL ? 0 : 1);

        $emailcustomer  = ($this -> input -> post('emailcustomer') == NULL ? 0 : 1);
        $emailmerchant  = ($this -> input -> post('emailmerchant') == NULL ? 0 : 1);

        $emailaddresses = $this -> input -> post('emailaddresses');

        $tid            = $this -> input -> post('tid');
        $key            = $this -> input -> post('key');
        $token          = $this -> input -> post('token');

        $conveniencefee = ($this -> input -> post('conveniencefee') == NULL ? 0 : 1);
        $cfpercentage   = $this -> input -> post('cfpercentage');


        $this -> load -> helper('date');
        $datestring = "%Y-%m-%d %H:%i:%s";
        $time = time();
        $createddate = mdate($datestring, $time);

        $data = array(
            'customername'  => $customername,
            'cf1enabled'    => $cf1enabled,
            'cf1required'   => $cf1required,
            'cf1name'       => $cf1name,
            'cf2enabled'    => $cf2enabled,
            'cf2required'   => $cf2required,
            'cf2name'       => $cf2name,
            'cf3enabled'    => $cf3enabled,
            'cf3required'   => $cf3required,
            'cf3name'       => $cf3name,
            'allowach'      => $allowach,
            'allowcc'       => $allowcc,
            'emailcustomer' => $emailcustomer,
            'emailmerchant' => $emailmerchant,
            'emailaddresses'=> $emailaddresses,
            'slugname'      => $slugname,
            'showname'      => $showname,
            'showlogo'      => $showlogo,
            'tid'           => $tid,
            'jp_key'        => $key,
            'jp_token'      => $token,
            'conveniencefee'=> $conveniencefee,
            'cfpercentage'  => $cfpercentage,
            'created'       => $createddate
        );

        // insert data to database, return the id of the row that was inserted
        $id = $this -> customer_model -> add_customer($data);

        // get row that was just inserted
        $row = $this -> customer_model -> get_customer($id);

        $data = array();

        // go back to ajax to print data
        echo json_encode($data);
    }
    
    public function ajax_update_customer()
    {
        $this -> load -> model('customer_model', '', TRUE);

        // run form validation
        $this -> form_validation -> set_rules('customername', 'Customer Name', 'required|max_length[50]');
        $this -> form_validation -> set_rules('slug', 'Slug Name', 'required|max_length[50]');
        $this -> form_validation -> set_rules('cf1name', 'Custom Field 1 Name', 'max_length[50]');
        $this -> form_validation -> set_rules('cf2name', 'Custom Field 2 Name', 'max_length[50]');
        $this -> form_validation -> set_rules('cf3name', 'Custom Field 3 Name', 'max_length[50]');
        $this -> form_validation -> set_rules('emailaddresses', 'Email Addresses');
        $this -> form_validation -> set_rules('tid', 'Merchant TID', 'required|max_length[12]');
        $this -> form_validation -> set_rules('key', 'Key', 'required|max_length[24]');
        $this -> form_validation -> set_rules('token', 'Token', 'required|max_length[72]');
        $this -> form_validation -> set_rules('cfpercentage', 'Convenience Fee', 'numeric');

        $customer_exists = $this -> customer_exists_update($this->input->post('customerid'), $this->input->post('customername'));
        $slug_exists = $this -> slug_exists_update($this->input->post('customerid'), $this->input->post('slug'));
        $fields_disabled = $this -> fields_disabled($this->input->post('cf3enabled'), $this->input->post('allowach'));
        $form_validation = $this -> form_validation -> run();

        if ($this -> form_validation -> run() == FALSE
            || $this -> customer_exists_update($this->input->post('customerid'), $this->input->post('customername')) == FALSE
            || $this -> slug_exists_update($this->input->post('customerid'), $this->input->post('slug')) == FALSE
            || $this -> fields_disabled($this->input->post('cf3enabled'), $this->input->post('allowach')) == FALSE
            || $this -> fields_enabled($this->input->post('allowcc'), $this->input->post('allowach')) == FALSE)
        {
            $errors = array();
            if ($this -> form_validation -> run('customername') == FALSE)
                $errors['error_customername'] = form_error('customername');
            if ($this -> customer_exists_update($this->input->post('customerid'), $this -> input -> post('customername')) == FALSE)
                $errors['error_customername'] = '<p> Customer Name already exists in the system. Please choose a different name. </p>';
            if ($this -> form_validation -> run('slug') == FALSE)
                $errors['error_slug'] = form_error('slug');
            if ($this -> slug_exists_update($this->input->post('customerid'), $this -> input -> post('slug')) == FALSE)
                $errors['error_slug'] = '<p> Slug Name already exists in the system. Please choose a different name. </p>';
            if ($this -> form_validation -> run('cf1name') == FALSE)
                $errors['error_cf1name'] = form_error('cf1name');
            if ($this -> form_validation -> run('cf2name') == FALSE)
                $errors['error_cf2name'] = form_error('cf2name');
            if ($this -> form_validation -> run('cf3name') == FALSE)
                $errors['error_cf3name'] = form_error('cf3name');
            if ($this -> form_validation -> run('emailaddresses') == FALSE)
                $errors['error_emails'] = form_error('emailaddresses');
            if ($this -> form_validation -> run('tid') == FALSE)
                $errors['error_tid'] = form_error('tid');
            if ($this -> form_validation -> run('key') == FALSE)
                $errors['error_key'] = form_error('key');
            if ($this -> form_validation -> run('token') == FALSE)
                $errors['error_token'] = form_error('token');
            if ($this -> form_validation -> run('cfpercentage') == FALSE)
                $errors['error_cfpercentage'] = form_error('cfpercentage');
            if ($this -> fields_disabled($this->input->post('cf3enabled'), $this->input->post('allowach')) == FALSE)
            {
                $errors['error_cf3'] = '<p> Custom Field 3 is not available when ACH is Allowed. </p>';
                $errors['error_allowach'] = '<p> ACH is not available when Custom Field 3 is Enabled. </p>';
            }
            if ($this -> fields_enabled($this->input->post('allowcc'), $this->input->post('allowach')) == FALSE)
            {
                $errors['error_allowcc'] = '<p> Either Credit Card or ACH transactions are required. </p>';
                $errors['error_allowach'] = '<p> Either Credit Card or ACH transactions are required. </p>';
            }

            echo json_encode($errors);

            return; // if form validation fails, exit to ajax success message
        }

        $id             = $this -> input -> post('customerid');
        $customername   = $this -> input -> post('customername');
        $slugname       = $this -> input -> post('slug');

        $showname       = ($this -> input -> post('showname') == NULL ? 0 : 1);
        $showlogo       = ($this -> input -> post('showlogo') == NULL ? 0 : 1);

        $cf1enabled     = ($this -> input -> post('cf1enabled') == NULL ? 0 : 1);
        $cf2enabled     = ($this -> input -> post('cf2enabled') == NULL ? 0 : 1);
        $cf3enabled     = ($this -> input -> post('cf3enabled') == NULL ? 0 : 1);

        $cf1required    = ($this -> input -> post('cf1required') == NULL ? 0 : 1);
        $cf2required    = ($this -> input -> post('cf2required') == NULL ? 0 : 1);
        $cf3required    = ($this -> input -> post('cf3required') == NULL ? 0 : 1);

        $cf1name        = $this -> input -> post('cf1name');
        $cf2name        = $this -> input -> post('cf2name');
        $cf3name        = $this -> input -> post('cf3name');

        $allowach       = ($this -> input -> post('allowach') == NULL ? 0 : 1);
        $allowcc        = ($this -> input -> post('allowcc') == NULL ? 0 : 1);

        $emailcustomer  = ($this -> input -> post('emailcustomer') == NULL ? 0 : 1);
        $emailmerchant  = ($this -> input -> post('emailmerchant') == NULL ? 0 : 1);

        $emailaddresses = $this -> input -> post('emailaddresses');

        $tid            = $this -> input -> post('tid');
        $key            = $this -> input -> post('key');
        $token          = $this -> input -> post('token');

        $conveniencefee = ($this -> input -> post('conveniencefee') == NULL ? 0 : 1);
        $cfpercentage   = $this -> input -> post('cfpercentage');

        $this -> load -> helper('date');
        $datestring = "%Y-%m-%d %H:%i:%s";
        $time = time();
        $modifieddate = mdate($datestring, $time);

        $data = array(
            'customername'  => $customername,
            'cf1enabled'    => $cf1enabled,
            'cf1required'   => $cf1required,
            'cf1name'       => $cf1name,
            'cf2enabled'    => $cf2enabled,
            'cf2required'   => $cf2required,
            'cf2name'       => $cf2name,
            'cf3enabled'    => $cf3enabled,
            'cf3required'   => $cf3required,
            'cf3name'       => $cf3name,
            'allowach'      => $allowach,
            'allowcc'       => $allowcc,
            'emailcustomer' => $emailcustomer,
            'emailmerchant' => $emailmerchant,
            'emailaddresses'=> $emailaddresses,
            'slugname'      => $slugname,
            'showname'      => $showname,
            'showlogo'      => $showlogo,
            'tid'           => $tid,
            'jp_key'        => $key,
            'jp_token'      => $token,
            'conveniencefee'=> $conveniencefee,
            'cfpercentage'  => $cfpercentage,
            'modified'      => $modifieddate
        );

        // insert data to database, return the id of the row that was inserted
        $this -> customer_model -> update_customer($id, $data);

        // get row that was just inserted
        $row = $this -> customer_model -> get_customer($id);

        $data = array();

        // go back to ajax to print data
        echo json_encode($data);
    }

    public function ajax_update_customer_enabled_status()
    {
        $this -> load -> model('customer_model', '', TRUE);

        $id     = $this -> input -> post('id');
        $status = $this -> input -> post('status');
        
        $this -> customer_model -> update_customer_enabled_status($id, $status);

        $row = $this -> customer_model -> get_customer($id);

        $data = array(
            'id'     => $row -> id,
            'status' => $row -> ensabled
        );

        echo json_encode($data);
    }

    public function customer_exists($id, $customername)
    {
        if ($this -> customer_model -> check_customer_exists($id, $customername))
        {
            return true; // already exists
        } else
        {
            return false; // does not exist, we are ok to add/update
        }
    }
    
    public function slug_exists($id, $slugname)
    {
        if ($this -> customer_model -> check_slug_exists($id, $slugname))
        {
            return true; // already exists
        } else
        {
            return false; // does not exist, we are ok to add/update
        }
    }
    
    public function customer_exists_update($id, $customername)
    {
        if ($this -> customer_model -> check_customer_exists($id, $customername))
        {
            return false; // already exists
        } else
        {
            return true; // does not exist, we are ok to add/update
        }
    }
    
    public function slug_exists_update($id, $slugname)
    {
        if ($this -> customer_model -> check_slug_exists($id, $slugname))
        {
            return false; // already exists
        } else
        {
            return true; // does not exist, we are ok to add/update
        }
    }

    public function fields_disabled($field1, $field2)
    {
        if ($field1 == 'on' && $field2 == 'on')
        {
            return false;
        } else
        {
            return true;
        }
    }

    public function fields_enabled($field1, $field2)
    {
        if ($field1 == 'on' || $field2 == 'on')
        {
            return true;
        } else
        {
            return false;
        }
    }
}