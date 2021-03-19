<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_templates extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "email_templates";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'email_templates';
        $this->load->model('email_templates_model');
        $this->load->model('email_templates_veriables_model');
        $this->load->database();
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("email_templates", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("email_templates"), '/email_templates');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->email_templates_model->getAll(
            array(),
            ""
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("email_templates");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function updateForm($id)
    {

        if (!permission("email_templates", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("email_templates"), '/users');
        $this->breadcrumbs->push(trans("edit_template"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->email_templates_model->get(
            array(
                "id" => $id
            )
        );

        $veriables = $this->email_templates_veriables_model->getAll(array("template_id" => $id), "");

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->veriables = $veriables;
        $viewData->title = trans("edit_template");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("email_templates", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("email_templates"), '/users');
        $this->breadcrumbs->push(trans("edit_template"), '/');

        $item = $this->email_templates_model->get(
            array(
                "id" => $id
            )
        );

        $veriables = $this->email_templates_veriables_model->getAll(array("template_id" => $id), "");

        $this->load->library("form_validation");

        $this->form_validation->set_rules("title", trans("title"), "required|trim");
        $this->form_validation->set_rules("body", trans("email_body"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['title'] = $this->input->post('title');
            $data['body'] = $this->input->post('body');

            $update = $this->email_templates_model->update(array("id" => $id), $data);

            // TODO Alert sistemi eklenecek...
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
            redirect(base_url("email_templates"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->veriables = $veriables;
            $viewData->title = trans("edit_template");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->email_templates_model->get(
                array(
                    "id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("email_templates", "delete")) {
            redirect(base_url());
        }

        $delete = $this->email_templates_model->delete(
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
        redirect(base_url('email_templates'));
    }

}
