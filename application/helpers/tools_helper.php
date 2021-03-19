<?php

/* Setting */
function settings($name){
    $settings = array();
    require __DIR__ . '/settings.php';
    return isset($settings[$name]) ? $settings[$name] : false;
}

function logo($item){
    $t = &get_instance();
    $t->load->model('settings_model');
    $logos = $t->settings_model->get();
    return base_url("uploads/settings/").$logos->$item;
}
/* Setting */

/* User */
function get_active_user(){
    $t = &get_instance();
    $user = $t->session->userdata("user");
    if($user){
        return $user;
    }else{
        return false;
    }
}

function permission($url, $action){
    $user = get_active_user();
    $permission = json_decode($user->permissions, true);
    if (isset($permission[$url][$action])){
        return true;
    }else{
        return false;
    }
}

function check_session_time(){
    $t = &get_instance();
    $user = $t->session->userdata("user");
    $time = time();
    $user_time = $user->log_time + (30);
    if($time > $user_time){
        $mail = $user->email;
        $img = $user->img_url;
        $t->session->unset_userdata("user");

        $viewData = new stdClass();
        $viewData->usermail = $mail;
        $viewData->userimg = $img;
        $t->load->view("users/lockscreen/index", $viewData);
    }
}

/* User */

/* Language */
function get_language_list()
{
    $ci = & get_instance();
    $ci->db->where('isActive',1);
    return $ci->db->get('languages')->result_array();
}

function get_lang_short_code($id)
{
    $ci = & get_instance();
    $ci->db->where('id',$id);
    return $ci->db->get('languages')->row_array()['code'];
}

function get_lang_name_by_id($id)
{
    $ci = & get_instance();
    $ci->db->where('id',$id);
    return $ci->db->get('languages')->row_array()['title'];
}

function trans($string)
{
    $ci = &get_instance();
    if(($ci->session->userdata('site_lang')) == 0){
        $id = $ci->db->where(array("id" => settings("current_language_id")))->get("languages")->row_array()["folder_name"];
    }else{
        $id = $ci->db->where(array("id" => $ci->session->userdata('site_lang')))->get("languages")->row_array()["folder_name"];
    }
    $code = ($ci->session->userdata('site_lang') == '') ? settings("language") : $ci->session->userdata('site_lang');
    $ci->lang->load('site', $id);
    return $ci->lang->line($string);
}
/* Language */

function getCover($id){
    $t=&get_instance();
    $t->load->model("data_model");
    $cover = $t->data_model->get("project_images", array("isActive" => 1, "project_id" => $id, "isCover" => 1));
    if(empty($cover)){
        $cover = $t->data_model->get("project_images", array("isActive" => 1, "project_id" => $id));
    }
    return !empty($cover) ? $cover->image_url : "";
}

function notification($date = ""){
    $today = date("Y-m-d");
    $t = &get_instance();
    $t->load->model('calendar_model');
    $calendar = $t->calendar_model->getAll(array(
        "start_date >=" => $today,
        "end_date <=" => $today
    ),"");
    return (!empty($calendar)) ? $calendar : false;
}

function copyright(){
    return 'Programming with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="http://www.afsakar.com" target="_blank">Azad Furkan ŞAKAR</a>';
}

function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function stripHTMLtags($str)
{
    $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
    $t = htmlentities($t, ENT_QUOTES, "UTF-8");
    return $t;
}

/* Email */
function send_mail($toEmail = "", $subjectMail = "", $messageMail = ""){
    $t = &get_instance();
    $t->load->model('email_settings_model');
    $emailSettings = $t->email_settings_model->get(array("isActive" => 1));

    $config = array(
        "protocol" => $emailSettings->protocol,
        "smtp_host" => $emailSettings->host,
        "smtp_port" => $emailSettings->port,
        "smtp_user" => $emailSettings->user,
        "smtp_pass" => $emailSettings->password,
        "starttls" => true,
        "charset" => "utf-8",
        "mailtype" => "html",
        "wordwrap" => true,
        "newline" => "\r\n"
    );
    $t->load->library("email", $config);

    $t->email->from($emailSettings->from, $emailSettings->user_name);
    $t->email->to($toEmail);
    $t->email->subject($subjectMail);
    $t->email->message($messageMail);

    return $t->email->send();
}

function comment_mail($subjectMail = "", $messageMail = ""){
    $t = &get_instance();
    $t->load->model('data_model');
    $emailSettings = $t->data_model->get("email_settings", array("isActive" => 1));

    $config = array(
        "protocol" => $emailSettings->protocol,
        "smtp_host" => $emailSettings->host,
        "smtp_port" => $emailSettings->port,
        "smtp_user" => $emailSettings->user,
        "smtp_pass" => $emailSettings->password,
        "starttls" => true,
        "charset" => "utf-8",
        "mailtype" => "html",
        "wordwrap" => true,
        "newline" => "\r\n"
    );
    $t->load->library("email", $config);

    $t->email->from($emailSettings->from, $emailSettings->user_name);
    $t->email->to($emailSettings->user);
    $t->email->subject("Yeni yorum yapıldı: ".$subjectMail);
    $t->email->message($messageMail);

    return $t->email->send();
}

function contact_mail($name = "", $fromMail = "", $phoneMail = "", $subjectMail = "", $messageMail = ""){
    $t = &get_instance();
    $t->load->model('data_model');
    $emailSettings = $t->data_model->get("email_settings", array("isActive" => 1));

    $config = array(
        "protocol" => $emailSettings->protocol,
        "smtp_host" => $emailSettings->host,
        "smtp_port" => $emailSettings->port,
        "smtp_user" => $emailSettings->user,
        "smtp_pass" => $emailSettings->password,
        "starttls" => true,
        "charset" => "utf-8",
        "mailtype" => "html",
        "wordwrap" => true,
        "newline" => "\r\n"
    );
    $t->load->library("email", $config);

    $mesaj1 = str_replace("myName", "$name", htmlspecialchars_decode(settings("contact_template")));
    $mesaj2 = str_replace("myPhone", "$phoneMail", htmlspecialchars_decode($mesaj1));
    $mesaj3 = str_replace("myMail", "$fromMail", htmlspecialchars_decode($mesaj2));
    $mesaj4 = str_replace("myMessage", "$messageMail", htmlspecialchars_decode($mesaj3));
    $mesaj = str_replace("myLogo", logo("logo"), htmlspecialchars_decode($mesaj4));

    $t->email->from($fromMail, $name);
    $t->email->to($emailSettings->user);
    $t->email->subject($subjectMail);
    $t->email->message($mesaj);

    return $t->email->send();
}

function rand_password($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}
/* Email */

function currencyFormat($price){

    if(settings("money_status") == "after"){
        $format = number_format($price, 2)." ".settings("currency");
    }else{
        $format = settings("currency")." ".number_format($price, 2);
    }
    return $format;
}