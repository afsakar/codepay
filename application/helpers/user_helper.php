<?php

function get_active_user()
{
    $t = &get_instance();
    $user = $t->session->userdata("user");
    if ($user) {
        return $user;
    } else {
        return false;
    }
}

function permission($url, $action)
{
    $user = get_active_user();
    $permission = json_decode($user->permissions, true);
    if (isset($permission[$url][$action])) {
        return true;
    } else {
        return false;
    }
}

function check_session_time()
{
    $t = &get_instance();
    $user = $t->session->userdata("user");
    $time = time();
    $user_time = $user->log_time + (30);
    if ($time > $user_time) {
        $mail = $user->email;
        $img = $user->img_url;
        $t->session->unset_userdata("user");

        $viewData = new stdClass();
        $viewData->usermail = $mail;
        $viewData->userimg = $img;
        $t->load->view("users/lockscreen/index", $viewData);
    }
}