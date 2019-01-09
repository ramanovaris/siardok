<?php

class Otp_model extends CI_Model
{
    private $token = '785918748:AAFmDZMCNsgouUDtkDOzAJ1fonziabxwmXk';
    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('Asia/singapore');
        $this->now = date("Y-m-d H:i:s");
    }

    public function send_message($chat_id, $otp)
    {
        $telegram_api = "https://api.telegram.org/bot".$this->token;
        $chat_id = $chat_id; 
        $params = [
            'chat_id' => $chat_id, 
            'text' => 'Silahkan masukkan angka berikut ' . $otp,
        ];
        $ch = curl_init($telegram_api . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function broadcast_message($chat_id, $text)
    {
        $telegram_api = "https://api.telegram.org/bot".$this->token;
        $chat_id = $chat_id; 
        $params = [
            'chat_id' => $chat_id, 
            'text' => $text,
        ];
        $ch = curl_init($telegram_api . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        curl_close($ch);
    }

    public function send_invitation_picture($chat_id, $event)
    {
        $bot_url    = "https://api.telegram.org/bot" .$this->token. "/";
        $url        = $bot_url . "sendPhoto?chat_id=" . $chat_id ;

        $photo_fields = array(
            'chat_id'   => $chat_id,
            'caption' => $event['invitation_caption'],
            'photo'     => new CURLFile(realpath("./uploads/" .$event['invitation_picture']))
        );

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $photo_fields); 
        $output = curl_exec($ch);
    }
    public function save_otp($otp, $id_user)
    {
        $otp_expired = date('Y-m-d H:i:s', strtotime('3 minutes'));
        $data = array(
            'otp' => $otp,
            'id_user' => $id_user,
            'otp_expired' => $otp_expired
        );
        $this->db->insert('tbl_otp', $data);
    }

    public function get_user_by_otp($otp)
    {
        $query = $this->db->select('user.*')
            ->from('user')
            ->join('tbl_otp', 'tbl_otp.id_user = user.id_user')
            ->where('tbl_otp.otp', $otp)
            ->get();
        return $query->row_array();
    }

    //one person one otp
    public function check_otp($otp, $id_user)
    {
        $query = $this->db->select('*')
            ->from('tbl_otp')
            ->where('otp', $otp)
            ->where('id_user', $id_user)
            ->get();
        return $query->row_array();
    }

    public function delete_otp($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->delete('tbl_otp');
    }

    public function delete_expired_otp()
    {
        $this->db->where('otp_expired >', $this->now);
        $this->db->delete('tbl_otp');
    }

    public function otp_exists($otp)
    {
        $query = $this->db->select('otp')
            ->from('tbl_otp')
            ->where('otp', $otp)
            ->get();
        if (!empty($query->result_array())) {
            return true;
        } else {
            return false;
        }
    }
}