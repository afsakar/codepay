<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "services";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'services';
        $this->load->model('services_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("services", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("service_list"), '/services');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->services_model->getAll(
            array(),
            "sr_code ASC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("service_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("services", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("service_list"), '/services');
        $this->breadcrumbs->push(trans("add_service"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_service");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("services", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("service_list"), '/services');
        $this->breadcrumbs->push(trans("add_service"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("sr_code", trans("product_code"), "required|exact_length[6]|is_unique[services.sr_code]|trim");
        $this->form_validation->set_rules("sr_name", trans("title"), "required|trim");
        $this->form_validation->set_rules("sr_description", trans("description"), "required|trim");
        $this->form_validation->set_rules("sr_price", trans("tax_rate"), "required|trim");
        $this->form_validation->set_rules("sr_amount", trans("amount"), "required|trim");
        $this->form_validation->set_rules("sr_tax", trans("tax"), "required|trim");
        $this->form_validation->set_rules("sr_unit", trans("unit"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "exact_length" => "<strong>{field}</strong> " . trans("exact_length_6"),
            "is_unique" => "<strong>{field}</strong> " . trans("is_unique")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['sr_code'] = $this->input->post('sr_code');
            $data['sr_name'] = $this->input->post('sr_name');
            $data['sr_description'] = $this->input->post('sr_description');
            $data['sr_price'] = $this->input->post('sr_price');
            $data['sr_amount'] = $this->input->post('sr_amount');
            $data['sr_tax'] = $this->input->post('sr_tax');
            $data['sr_unit'] = $this->input->post('sr_unit');

            //Form verilerini kaydet
            $insert = $this->services_model->add($data);
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
            redirect(base_url('services'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_service");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("services", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("service_list"), '/services');
        $this->breadcrumbs->push(trans("edit_service"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->services_model->get(
            array(
                "sr_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_service");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("services", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("service_list"), '/services');
        $this->breadcrumbs->push(trans("edit_service"), '/');

        $item = $this->services_model->get(
            array(
                "sr_id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..

        if ($item->sr_code != $this->input->post('sr_code')) {
            $this->form_validation->set_rules("sr_code", trans("product_code"), "required|exact_length[6]|is_unique[services.sr_code]|trim");
        }
        $this->form_validation->set_rules("sr_name", trans("title"), "required|trim");
        $this->form_validation->set_rules("sr_description", trans("description"), "required|trim");
        $this->form_validation->set_rules("sr_price", trans("tax_rate"), "required|trim");
        $this->form_validation->set_rules("sr_amount", trans("amount"), "required|trim");
        $this->form_validation->set_rules("sr_tax", trans("tax"), "required|trim");
        $this->form_validation->set_rules("sr_unit", trans("unit"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "exact_length" => "<strong>{field}</strong> " . trans("exact_length_6"),
            "is_unique" => "<strong>{field}</strong> " . trans("is_unique")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['sr_code'] = $this->input->post('sr_code');
            $data['sr_name'] = $this->input->post('sr_name');
            $data['sr_description'] = $this->input->post('sr_description');
            $data['sr_price'] = $this->input->post('sr_price');
            $data['sr_amount'] = $this->input->post('sr_amount');
            $data['sr_tax'] = $this->input->post('sr_tax');
            $data['sr_unit'] = $this->input->post('sr_unit');

            $update = $this->services_model->update(array("sr_id" => $id), $data);

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

            redirect(base_url("services"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_service");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->services_model->get(
                array(
                    "sr_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("services", "delete")) {
            redirect(base_url());
        }

        $delete = $this->services_model->delete(
            array(
                "sr_id" => $id
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
        redirect(base_url('services'));
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

            $update = $this->services_model->update(array("sr_id" => $id), array("sr_isActive" => $isActive));

        }

    }

}
