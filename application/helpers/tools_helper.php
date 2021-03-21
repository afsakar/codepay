<?php

function settings($name)
{
    $settings = array();
    require __DIR__ . '/settings.php';
    return isset($settings[$name]) ? $settings[$name] : false;
}

function logo($item)
{
    $t = &get_instance();
    $t->load->model('settings_model');
    $logos = $t->settings_model->get();
    return base_url("uploads/settings/") . $logos->$item;
}

function copyright()
{
    return 'Coded with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="http://www.afsakar.com" target="_blank">Azad Furkan ŞAKAR</a>';
}