<?php

function get_language_list()
{
    $ci = &get_instance();
    $ci->db->where('isActive', 1);
    return $ci->db->get('languages')->result_array();
}

function get_lang_short_code($id)
{
    $ci = &get_instance();
    $ci->db->where('id', $id);
    return $ci->db->get('languages')->row_array()['code'];
}

function get_lang_name_by_id($id)
{
    $ci = &get_instance();
    $ci->db->where('id', $id);
    return $ci->db->get('languages')->row_array()['title'];
}

function trans($string)
{
    $ci = &get_instance();
    if (($ci->session->userdata('site_lang')) == 0) {
        $id = $ci->db->where(array("id" => settings("current_language_id")))->get("languages")->row_array()["folder_name"];
    } else {
        $id = $ci->db->where(array("id" => $ci->session->userdata('site_lang')))->get("languages")->row_array()["folder_name"];
    }
    $code = ($ci->session->userdata('site_lang') == '') ? settings("language") : $ci->session->userdata('site_lang');
    $ci->lang->load('site', $id);
    return $ci->lang->line($string);
}