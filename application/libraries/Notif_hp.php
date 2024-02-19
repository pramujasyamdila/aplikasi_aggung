<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Notif_hp
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('Auth_model');
        $this->ci->load->model('Global/Global_model');
        $this->ci->load->helper('string');
    }

    public function notif_hp($id_user, $pesan)
    {
        $get_user =  $this->ci->Global_model->get_user($id_user);
        $token_user = $get_user['token_notif'];
        // Firebase Cloud Messaging Authorization Key
        define('FCM_AUTH_KEY', 'AAAAUwcZ87I:APA91bE-MGJNBeOYpFEZIOefHbUi1ItS1_EUCGVSaXyz7K9Qx_AK9A-Tqr8_k2L0Xo7UgVX75UNV-81bd0fdJIp2VLsOXi96jMULHY_RzeGpbkK1bPgqmv0pgQEBPfiI4IEJbS_8s1Lt');

        function sendPush($to, $title, $body, $icon, $url)
        {
            $postdata = json_encode(
                [
                    'notification' =>
                    [
                        'title' => $title,
                        'body' => $body,
                        'icon' => $icon,
                        'click_action' => $url
                    ],
                    'to' => $to
                ]
            );

            $opts = array(
                'http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json' . "\r\n"
                        . 'Authorization: key=' . FCM_AUTH_KEY . "\r\n",
                    'content' => $postdata
                )
            );

            $context  = stream_context_create($opts);
            $result = file_get_contents('https://fcm.googleapis.com/fcm/send', false, $context);
            if ($result) {
                return json_decode($result);
            } else return false;
        }
        sendPush($token_user, 'INFORMASI!!', $pesan, 'https://cdn1-production-images-kly.akamaized.net/GThpK29xMOyzhJMHajflep4CF9E=/1200x1200/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/1439641/original/042027300_1482131661-reddit.jpg', 'https://openthissiteonclick.com');
    }
}
