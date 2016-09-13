<?php
/**
 * Created by PhpStorm.
 * User: robertfulcher
 * Date: 11/17/15
 * Time: 6:50 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));

    }

    public function index()
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
        $data['upload_success'] = '';
        $data['error'] = NULL;
        $this->load->view('fileupload', $data);
    }

    public function do_upload()
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

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'csv|txt';
        $config['max_size']             = 100000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $data['upload_success'] = '';
            $data['error'] = array('error' => $this->upload->display_errors());
            $this->load->view('fileupload', $data);
        }
        else
        {
            $data['upload_success'] = 'Your file was successfully uploaded!';
            $this->load->view('fileupload', $data);
        }
    }

    public function file_list($data = NULL)
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

        $this->load->helper('directory');
        $data['map'] = directory_map('./uploads/', 1, TRUE);

        $this->load->view('filelist', $data);

    }

    public function file_import()
    {

        $this->load->model('fileupload_model', 'fileupload');
        $filename = $this->uri->segment(3);
        $fileeolcharacters = $this->detectFileEOL($file_path = FCPATH.'/uploads/'. $filename);
        $data['message'] = $this->fileupload->import_file($filename, $fileeolcharacters);

        $this->file_list($data);
    }

    public function file_delete(){
        $filename = $this->uri->segment(3);
        $file_path = FCPATH.'/uploads/'. $filename;
        $result = unlink($file_path);

        if($result == FALSE){
            $data['message'] = array('message' => 'Delete Faild');
        } else {
            $data['message'] = array('message' => 'File Deletion Was Successful');
        }

        $this->file_list($data);

    }

    /**
    Newline characters in different Operating Systems
    The names given to the different sequences are:
    ============================================================================================
    NewL  Chars       Name     Description
    ----- ----------- -------- ------------------------------------------------------------------
    LF    0x0A        UNIX     Apple OSX, UNIX, Linux
    CR    0x0D        TRS80    Commodore, Acorn BBC, ZX Spectrum, TRS-80, Apple II family, etc
    LFCR  0x0A 0x0D   ACORN    Acorn BBC and RISC OS spooled text output.
    CRLF  0x0D 0x0A   WINDOWS  Microsoft Windows, DEC TOPS-10, RT-11 and most other early non-Unix
    and non-IBM OSes, CP/M, MP/M, DOS (MS-DOS, PC DOS, etc.), OS/2,
    ----- ----------- -------- ------------------------------------------------------------------
     */
    //    const EOL_UNIX    = 'lf';        // Code: \n
    //    const EOL_TRS80   = 'cr';        // Code: \r
    //    const EOL_ACORN   = 'lfcr';      // Code: \n \r
    //    const EOL_WINDOWS = 'crlf';      // Code: \r \n
    const EOL_ACORN   = "\\n\\r";  // 0x0A - 0x0D - acorn BBC
    const EOL_WINDOWS = "\\r\\n";  // 0x0D - 0x0A - Windows, DOS OS/2
    const EOL_UNIX    = "\\n";    // 0x0A -      - Unix, OSX
    const EOL_TRS80   = "\\r";    // 0x0D -      - Apple ][, TRS80



    /**
    Detects the EOL of an file by checking the first line.
    @param string  $fileName    File to be tested (full pathname).
    @return boolean false | Used key = enum('cr', 'lf', crlf').
    @uses detectEOL
     */
    public static function detectFileEOL($fileName) {
        if (!file_exists($fileName)) {
            return false;
        }

        // Gets the line length
        $handle = @fopen($fileName, "r");
        if ($handle === false) {
            return false;
        }
        $line = fgets($handle);
        $key = "";
        Fileupload::detectEOL($line, $key);

   return $key;
    }  // detectFileEOL




    /**
    Detects the end-of-line character of a string.
    @param string $str      The string to check.
    @param string $key      [io] Name of the detected eol key.
    @return string The detected EOL, or default one.
     */
    public static function detectEOL($str, &$key) {
        static $eols = array(
            Fileupload::EOL_ACORN   => "\n\r",  // 0x0A - 0x0D - acorn BBC
            Fileupload::EOL_WINDOWS => "\r\n",  // 0x0D - 0x0A - Windows, DOS OS/2
            Fileupload::EOL_UNIX    => "\n",    // 0x0A -      - Unix, OSX
            Fileupload::EOL_TRS80   => "\r",    // 0x0D -      - Apple ][, TRS80
        );

        $key = "";
        $curCount = 0;
        $curEol = '';
        foreach($eols as $k => $eol) {
            if( ($count = substr_count($str, $eol)) > $curCount) {
                $curCount = $count;
                $curEol = $eol;
                $key = $k;
            }
        }
        return $curEol;
    }  // detectEOL




}