<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_settings extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "email_settings";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'email';
        $this->load->model('email_settings_model');
        $this->load->database();
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("email_settings", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("email_list"), '/email_list');

        $viewData = new stdClass();
        /* Pagination End */

        //Tablodan verilerin çekilmesi.
        $items = $this->email_settings_model->getAll(
            array(),
            ""
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("email_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("email_settings", "add")) {
            redirect(base_url());
        }
        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("email_list"), '/users');
        $this->breadcrumbs->push(trans("email_add"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("email_add");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("email_settings", "add")) {
            redirect(base_url());
        }
        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("email_list"), '/users');
        $this->breadcrumbs->push(trans("email_add"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("protocol", trans("protocol"), "required|trim");
        $this->form_validation->set_rules("host", trans("host"), "required|trim");
        $this->form_validation->set_rules("port", trans("port"), "required|trim");
        $this->form_validation->set_rules("user", trans("email"), "required|trim|valid_email");
        $this->form_validation->set_rules("password", trans("password"), "required|trim");
        $this->form_validation->set_rules("from", trans("from"), "required|trim|valid_email");
        $this->form_validation->set_rules("to", trans("to"), "required|trim|valid_email");
        $this->form_validation->set_rules("user_name", trans("email_title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['user_name'] = $this->input->post('user_name');
            $data['protocol'] = $this->input->post('protocol');
            $data['port'] = $this->input->post('port');
            $data['user'] = $this->input->post('user');
            $data['password'] = $this->input->post('password');
            $data['from'] = $this->input->post('from');
            $data['to'] = $this->input->post('to');
            $data['host'] = $this->input->post('host');

            //Form verilerini kaydet
            $insert = $this->email_settings_model->add($data);
            if ($insert) {
                $alert = array(
                    "title" => trans("has_success"),
                    "text" => trans("success_record"),
                    "type" => "success",
                    "position" => "top-center"
                );
            } else {
                $alert = array(
                    "title" => trans("has_error"),
                    "text" => trans("error_record"),
                    "type" => "error",
                    "position" => "top-center"
                );
            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url('email_settings'));
            die();
        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("email_add");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("email_settings", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("email_list"), '/users');
        $this->breadcrumbs->push(trans("email_edit"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->email_settings_model->get(
            array(
                "id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("email_edit");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("email_settings", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("email_list"), '/users');
        $this->breadcrumbs->push(trans("email_edit"), '/');

        $item = $this->email_settings_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->library("form_validation");

        $this->form_validation->set_rules("protocol", trans("protocol"), "required|trim");
        $this->form_validation->set_rules("host", trans("host"), "required|trim");
        $this->form_validation->set_rules("port", trans("port"), "required|trim");
        $this->form_validation->set_rules("user", trans("email"), "required|trim|valid_email");
        $this->form_validation->set_rules("password", trans("password"), "required|trim");
        $this->form_validation->set_rules("from", trans("from"), "required|trim|valid_email");
        $this->form_validation->set_rules("to", trans("to"), "required|trim|valid_email");
        $this->form_validation->set_rules("user_name", trans("email_title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['user_name'] = $this->input->post('user_name');
            $data['protocol'] = $this->input->post('protocol');
            $data['port'] = $this->input->post('port');
            $data['user'] = $this->input->post('user');
            $data['password'] = $this->input->post('password');
            $data['from'] = $this->input->post('from');
            $data['to'] = $this->input->post('to');
            $data['host'] = $this->input->post('host');

            $update = $this->email_settings_model->update(array("id" => $id), $data);

            if ($update) {
                $alert = array(
                    "title" => trans("has_success"),
                    "text" => trans("success_update"),
                    "type" => "success",
                    "position" => "top-center"
                );
            } else {
                $alert = array(
                    "title" => trans("has_error"),
                    "text" => trans("error_update"),
                    "type" => "error",
                    "position" => "top-center"
                );
            }

            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("email_settings"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("email_edit");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->email_settings_model->get(
                array(
                    "id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("email_settings", "delete")) {
            redirect(base_url());
        }

        $delete = $this->email_settings_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {
            $alert = array(
                "title" => trans("has_success"),
                "text" => trans("success_delete"),
                "type" => "success",
                "position" => "top-center"
            );
        } else {
            $alert = array(
                "title" => trans("has_error"),
                "text" => trans("error_delete"),
                "type" => "error",
                "position" => "top-center"
            );
        }

        $this->session->set_flashdata("alert", $alert);
        redirect(base_url('email_settings'));
    }

    public function isActiveSetter($id)
    {

        if ($id) {
            $isActive = $this->input->post("data");
            if ($isActive == "false") {
                $isActive = 0;
            } else {
                $isActive = 1;
            }

            if ($isActive = 0) {
                $update = $this->email_settings_model->update(array("id" => $id), array("isActive" => 0));
                $update = $this->email_settings_model->update(array("id !=" => $id), array("isActive" => 1));
            } else {
                $update = $this->email_settings_model->update(array("id" => $id), array("isActive" => 1));
                $update = $this->email_settings_model->update(array("id !=" => $id), array("isActive" => 0));
            }

        }

    }

    public function rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order['ord'];

        foreach ($items as $rank => $id) {
            $this->email_settings_model->update(array("id" => $id, "rank !=" => $rank), array("rank" => $rank));
        }
    }

}
