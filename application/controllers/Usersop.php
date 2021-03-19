<?php

class Usersop extends CI_Controller
{

    public $viewFolder = "";
    public $tableName = "users";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'users';
        $this->load->model('users_model');
        $this->load->database();
        $this->load->helper('cookie');
    }

    public function login()
    {
        if (get_active_user()) {
            redirect(base_url());
        }

        $viewData = new stdClass();
        $this->load->library("form_validation");

        //Tablodan verilerin çekilmesi.
        //$items = $this->users_model->getAll(array(),"");

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "login";
        //$viewData->items = $items;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function doLogin()
    {
        if (get_active_user()) {
            redirect(base_url());
        }

        $email = $this->input->post('user_email');
        $password = md5($this->input->post('user_password'));
        $remember_me = $this->input->post('remember_me');

        $this->load->library("form_validation");
        $this->form_validation->set_rules("user_email", trans("email"), "required|valid_email|trim");
        $this->form_validation->set_rules("user_password", trans("password"), "required|min_length[8]|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "min_length" => trans("min_length")
        ));

        //Form validation çalıştır
        if ($this->form_validation->run() == FALSE) {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "login";
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        } else {

            $user = $this->users_model->get(array("email" => $email, "password" => $password));
            if ($user) {
                if ($user->isActive != 1) {
                    $alert = array(
                        "title" => trans("login_error"),
                        "text" => trans("login_member_inactive"),
                        "type" => "error",
                        "position" => "top-center"
                    );
                    $this->session->set_flashdata("alert", $alert);
                    redirect(base_url('login'));
                    die();
                } else {
                    $this->users_model->update(array("id" => $user->id), array("isOnline" => 1, "log_time" => time()));
                    $alert = array(
                        "title" => trans("login_success_title"),
                        "text" => trans("login_success_text") . "<b>$user->user_name</b>",
                        "type" => "success",
                        "position" => "top-center"
                    );

                    $this->session->set_userdata("user", $user);
                    $this->session->set_flashdata("alert", $alert);

                    if ($remember_me == "on") {
                        $remember = array(
                            "email" => $email
                        );
                        set_cookie("remember_me", json_encode($remember), time() + 60 * 60 * 24 * 30);
                    } else {
                        delete_cookie("remember_me");
                    }
                    redirect(base_url());
                }
            } else {
                $alert = array(
                    "title" => trans("login_error"),
                    "text" => trans("login_error_text"),
                    "type" => "error",
                    "position" => "top-center"
                );
                $this->session->set_flashdata("alert", $alert);
                redirect(base_url('login'));
                die();
            }

        }
    }

    public function logout()
    {
        $user = get_active_user();
        $this->users_model->update(array("id" => $user->id), array("isOnline" => 0));
        $this->session->unset_userdata("user");
        redirect(base_url('login'));
    }

    public function forget_password()
    {
        if (get_active_user()) {
            redirect(base_url());
        }

        $viewData = new stdClass();
        $this->load->library("form_validation");

        //Tablodan verilerin çekilmesi.
        //$items = $this->users_model->getAll(array(),"");

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "forget_password";
        //$viewData->items = $items;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function reset_password()
    {
        if (get_active_user()) {
            redirect(base_url());
        }

        $this->load->library("form_validation");
        $this->form_validation->set_rules("email", trans("email"), "required|valid_email|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email")
        ));

        if ($this->form_validation->run() === FALSE) {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "forget_password";
            $this->session->set_flashdata("form_error", $viewData->form_error = true);

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        } else {
            $email = $this->input->post("email");

            $user = $this->users_model->get(array("isActive" => 1, "email" => $email));

            if ($user) {

                $random_pass = rand_password(8);

                /* Call Email Template */
                require APPPATH . "views/email_templates/templates/forget_password.php";
                $this->load->model('email_templates_model');
                $fpTemplate = $this->email_templates_model->get(array("url" => "forget-password"));
                $login_link = base_url("login");

                $new_template = str_replace("{TITLE}", $fpTemplate->title, $template);
                $content = str_replace("{FULLNAME}", $user->full_name, $fpTemplate->body);
                $content = str_replace("{LOGIN_LINK}", $login_link, $content);
                $content = str_replace("{NEW_PASS}", $random_pass, $content);
                $new_template = str_replace("{CONTENT}", $content, $new_template);
                /* Call Email Template */

                $this->users_model->update(array("email" => $email), array("password" => md5($random_pass)));

                $send = send_mail($email, $fpTemplate->subject, $new_template);

                if ($send) {
                    $alert = array(
                        "title" => trans("has_success"),
                        "text" => trans("reset_pass_success"),
                        "type" => "success",
                        "position" => "top-center"
                    );
                    $this->session->set_flashdata("alert", $alert);
                    redirect(base_url('login'));
                    die();
                } else {
                    echo $this->email->print_debugger();
                }
            } else {
                $alert = array(
                    "title" => trans("has_error"),
                    "text" => trans("reset_pass_error"),
                    "type" => "error",
                    "position" => "top-center"
                );
                $this->session->set_flashdata("alert", $alert);
                redirect(base_url('forget_password'));
                die();
            }
        }

    }

}