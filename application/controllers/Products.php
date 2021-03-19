<?php
defined('BASEPATH') or exit('No direct script access allowed');

class products extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "products";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'products';
        $this->load->model('products_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("products", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("product_list"), '/products');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->products_model->getAll(
            array(),
            "pr_code ASC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("product_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("products", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("product_list"), '/products');
        $this->breadcrumbs->push(trans("add_product"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_product");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("products", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("product_list"), '/products');
        $this->breadcrumbs->push(trans("add_product"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("pr_code", trans("product_code"), "required|exact_length[6]|is_unique[products.pr_code]|trim");
        $this->form_validation->set_rules("pr_name", trans("title"), "required|trim");
        $this->form_validation->set_rules("pr_description", trans("description"), "required|trim");
        $this->form_validation->set_rules("pr_price", trans("tax_rate"), "required|trim");
        $this->form_validation->set_rules("pr_amount", trans("amount"), "required|trim");
        $this->form_validation->set_rules("pr_tax", trans("tax"), "required|trim");
        $this->form_validation->set_rules("pr_unit", trans("unit"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "exact_length" => "<strong>{field}</strong> " . trans("exact_length_6"),
            "is_unique" => "<strong>{field}</strong> " . trans("is_unique")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['pr_code'] = $this->input->post('pr_code');
            $data['pr_name'] = $this->input->post('pr_name');
            $data['pr_description'] = $this->input->post('pr_description');
            $data['pr_price'] = $this->input->post('pr_price');
            $data['pr_amount'] = $this->input->post('pr_amount');
            $data['pr_tax'] = $this->input->post('pr_tax');
            $data['pr_unit'] = $this->input->post('pr_unit');

            //Form verilerini kaydet
            $insert = $this->products_model->add($data);
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
            redirect(base_url('products'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_product");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("products", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("product_list"), '/products');
        $this->breadcrumbs->push(trans("edit_product"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->products_model->get(
            array(
                "pr_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_product");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("products", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("product_list"), '/products');
        $this->breadcrumbs->push(trans("edit_product"), '/');

        $item = $this->products_model->get(
            array(
                "pr_id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..

        if ($item->pr_code != $this->input->post('pr_code')) {
            $this->form_validation->set_rules("pr_code", trans("product_code"), "required|exact_length[6]|is_unique[products.pr_code]|trim");
        }
        $this->form_validation->set_rules("pr_name", trans("title"), "required|trim");
        $this->form_validation->set_rules("pr_description", trans("description"), "required|trim");
        $this->form_validation->set_rules("pr_price", trans("tax_rate"), "required|trim");
        $this->form_validation->set_rules("pr_amount", trans("amount"), "required|trim");
        $this->form_validation->set_rules("pr_tax", trans("tax"), "required|trim");
        $this->form_validation->set_rules("pr_unit", trans("unit"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "exact_length" => "<strong>{field}</strong> " . trans("exact_length_6"),
            "is_unique" => "<strong>{field}</strong> " . trans("is_unique")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['pr_code'] = $this->input->post('pr_code');
            $data['pr_name'] = $this->input->post('pr_name');
            $data['pr_description'] = $this->input->post('pr_description');
            $data['pr_price'] = $this->input->post('pr_price');
            $data['pr_amount'] = $this->input->post('pr_amount');
            $data['pr_tax'] = $this->input->post('pr_tax');
            $data['pr_unit'] = $this->input->post('pr_unit');

            $update = $this->products_model->update(array("pr_id" => $id), $data);

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

            redirect(base_url("products"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_product");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->products_model->get(
                array(
                    "pr_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("products", "delete")) {
            redirect(base_url());
        }

        $delete = $this->products_model->delete(
            array(
                "pr_id" => $id
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
        redirect(base_url('products'));
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

            $update = $this->products_model->update(array("pr_id" => $id), array("pr_isActive" => $isActive));

        }

    }

}
