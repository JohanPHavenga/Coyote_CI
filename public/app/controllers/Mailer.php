<?php
// public mailer class to get list from mailques table and send it out
class Mailer extends Frontend_Controller {
    
    private $ini_array = [];

    public function __construct() {
        parent::__construct();
        $this->load->model('emailque_model');
        $this->ini_array = parse_ini_file("server_config.ini", true);
    }
    
    public function process_que() {
        $mail_que=$this->fetch_mail_que($this->ini_array['emailque']['que_size']);
        if ($mail_que) {
            foreach ($mail_que as $mail_id=>$mail_data) {
                $mail_sent=$this->send_mail($mail_data);
                echo $mail_id." ".$mail_sent."<br>";
            }
            $msg="mail send";
        } else {
            $msg="no mail to send";
        }
        wts($mail_que);
        die($msg);
    }

    private function fetch_mail_que($top=0) {

        $emailque = $this->emailque_model->get_emailque_list($top,true);
        return $emailque;
    }

    private function send_mail($data = "") {
        $this->load->library('email');

        $config['mailtype'] = 'html';
        $config['smtp_host'] = $this->ini_array['email']['smtp_server'];
        $config['smtp_port'] = $this->ini_array['email']['smtp_port'];
        $config['smtp_crypto'] = $this->ini_array['email']['smtp_crypto'];
        $config['charset'] = $this->ini_array['email']['email_charset'];
        $this->email->initialize($config);

        $this->email->from($data['emailque_from_address'], $data['emailque_from_name']);
        $this->email->to($data['emailque_to_address'], $data['emailque_to_name']);
        if ($data['emailque_cc_address']) { $this->email->bcc($data['emailque_cc_address']); }
        if ($data['emailque_bcc_address']) { $this->email->bcc($data['emailque_bcc_address']); }

        $this->email->subject($data['emailque_subject']);
        $this->email->message($data['emailque_body']);

        $send=$this->email->send();

        return $send;
    }

}
