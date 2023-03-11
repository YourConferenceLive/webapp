<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common {

    private $_CI;

    function __construct() {
        $this->_CI = & get_instance();
    }

    function set_timezone() {
        date_default_timezone_set("US/Eastern"); //America/Dawson_Creek or Asia/Kolkata or America/Los_Angeles
    }

    function sendEmail($from, $to, $subject, $message, $name = NULL) {
        $from = "admin@yourconference.live";
        $config = Array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $this->_CI->load->library('email', $config);
        $this->_CI->email->set_newline("\r\n");
        $this->_CI->email->from($from, $name);
        $this->_CI->email->to($to);
        $this->_CI->email->subject($subject);
        $this->_CI->email->message($message);
        if ($this->_CI->email->send()) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function sendSmtpEmail($toEmail, $emailSubject, $emailBody)
    {
        $this->_CI->load->config('email_config', TRUE);
        // echo "<pre>"; print_r($this->_CI->config); echo "</pre>";
        // exit();
        if (!$this->_CI->config->config['email_config']['smtp_user'])
        {
            $response = array(
                'status' => 'failed',
                'msg' => "Send email option is not configured, please contact developer or system administrator."
            );

            echo json_encode($response);

            return;
        }


        $config = Array(
            'protocol' => $this->_CI->config->config['email_config']['email_protocol'],
            'smtp_host' => $this->_CI->config->config['email_config']['smtp_host'],
            'smtp_port' => $this->_CI->config->config['email_config']['smtp_port'],
            'smtp_user' => $this->_CI->config->config['email_config']['smtp_user'],
            'smtp_pass' => $this->_CI->config->config['email_config']['smtp_pass'],
            'mailtype' => $this->_CI->config->config['email_config']['mailtype'],
            'charset' => $this->_CI->config->config['email_config']['charset'],
            'smtp_crypto'   => 'ssl'
            // 'smtp_port' => $this->config->item('smtp_port', 'email_config'),
            // 'smtp_user' => $this->config->item('smtp_user', 'email_config'),
            // 'smtp_pass' => $this->config->item('smtp_pass', 'email_config'),
            // 'mailtype'  => $this->config->item('mailtype', 'email_config'),
            // 'charset'   => $this->config->item('charset', 'email_config')
        );
        $this->_CI->load->library('email', $config);

        $this->_CI->email->from('no-reply@yourconference.live', 'Your Conference Live');
        $this->_CI->email->to($toEmail); // To email here
        //$this->email->cc('athullive@gmail.com');
        //$this->email->bcc('athullive@gmail.com');

        $this->_CI->email->subject($emailSubject);

        $this->_CI->email->message($emailBody);

        $result = $this->_CI->email->send();

        if ($result)
        {
           return true;
        }else{

          return false;
        }

        return;
    }


}
