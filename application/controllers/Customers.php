<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "customers";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'customers';
        $this->load->model('accounts_model');
        $this->load->model('customers_model');
        $this->load->model('invoices_model');
        $this->load->model('invoice_payments_model');
        $this->load->model('incomes_model');
        $this->load->model('income_category_model');
        $this->load->model('expenses_model');
        $this->load->model('expense_category_model');
        $this->load->model('ibans_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("customers", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("customer_list"), '/customers');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->customers_model->getAll(
            array(),
            ""
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("customer_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("customers", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("customer_list"), '/customers');
        $this->breadcrumbs->push(trans("add_customer"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_customer");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("customers", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("customer_list"), '/customers');
        $this->breadcrumbs->push(trans("add_customer"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("cus_name", trans("customer_name"), "required|is_unique[customers.cus_name]|trim");
        $this->form_validation->set_rules("cus_owner", trans("customer_owner"), "required|trim");
        $this->form_validation->set_rules("cus_owner_phone", trans("customer_owner_phone"), "required|trim");
        $this->form_validation->set_rules("cus_phone", trans("phone"), "required|trim");
        // $this->form_validation->set_rules("cus_fax", trans("fax"), "required|trim");
        // $this->form_validation->set_rules("cus_gsm", trans("gsm"), "required|trim");
        $this->form_validation->set_rules("cus_email", trans("email"), "required|valid_email|trim");
        $this->form_validation->set_rules("cus_address", trans("address"), "required|trim");
        $this->form_validation->set_rules("cus_info", trans("company_info"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['cus_name'] = $this->input->post('cus_name');
            $data['cus_owner'] = $this->input->post('cus_owner');
            $data['cus_owner_phone'] = $this->input->post('cus_owner_phone');
            $data['cus_phone'] = $this->input->post('cus_phone');
            $data['cus_fax'] = $this->input->post('cus_fax');
            $data['cus_gsm'] = $this->input->post('cus_gsm');
            $data['cus_email'] = $this->input->post('cus_email');
            $data['cus_address'] = $this->input->post('cus_address');
            $data['cus_info'] = $this->input->post('cus_info');
            $data['cus_debit'] = $this->input->post('cus_debit');
            $data['cus_credit'] = $this->input->post('cus_credit');
            $data['cus_tax_number'] = $this->input->post('cus_tax_number');
            $data['cus_tax_office'] = $this->input->post('cus_tax_office');

            if ($_FILES["cus_logo"]["name"] !== "") {

                $randName = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config['file_name'] = $randName;

                $this->load->library('upload', $config);

                $upload = $this->upload->do_upload("cus_logo");

                if ($upload) {
                    $data['cus_logo'] = $this->upload->data("file_name");
                } else {
                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => trans("error_upload_image"),
                        "type" => "error",
                        "position" => "top-center"
                    );
                }
            }

            //Form verilerini kaydet
            $insert = $this->customers_model->add($data);
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
            redirect(base_url('customers'));

        } else {
            $viewData = new stdClass();
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_customer");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("customers", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("customer_list"), '/customers');
        $this->breadcrumbs->push(trans("edit_customer"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->customers_model->get(
            array(
                "cus_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_customer");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("customers", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("customer_list"), '/customers');
        $this->breadcrumbs->push(trans("edit_customer"), '/');

        $item = $this->customers_model->get(
            array(
                "cus_id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..

        if ($item->cus_name != $this->input->post("cus_name")) {
            $this->form_validation->set_rules("cus_name", trans("company_name"), "required|is_unique[customers.cus_name]|trim");
        }
        $this->form_validation->set_rules("cus_owner", trans("company_owner"), "required|trim");
        $this->form_validation->set_rules("cus_owner_phone", trans("company_owner_phone"), "required|trim");
        $this->form_validation->set_rules("cus_phone", trans("phone"), "required|trim");
        // $this->form_validation->set_rules("cus_fax", trans("fax"), "required|trim");
        // $this->form_validation->set_rules("cus_gsm", trans("gsm"), "required|trim");
        $this->form_validation->set_rules("cus_email", trans("email"), "required|valid_email|trim");
        $this->form_validation->set_rules("cus_address", trans("address"), "required|trim");
        $this->form_validation->set_rules("cus_info", trans("company_info"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            //Form'dan verileri al.
            $data['cus_name'] = $this->input->post('cus_name');
            $data['cus_owner'] = $this->input->post('cus_owner');
            $data['cus_owner_phone'] = $this->input->post('cus_owner_phone');
            $data['cus_phone'] = $this->input->post('cus_phone');
            $data['cus_fax'] = $this->input->post('cus_fax');
            $data['cus_gsm'] = $this->input->post('cus_gsm');
            $data['cus_email'] = $this->input->post('cus_email');
            $data['cus_address'] = $this->input->post('cus_address');
            $data['cus_info'] = $this->input->post('cus_info');
            $data['cus_debit'] = $this->input->post('cus_debit');
            $data['cus_credit'] = $this->input->post('cus_credit');
            $data['cus_tax_number'] = $this->input->post('cus_tax_number');
            $data['cus_tax_office'] = $this->input->post('cus_tax_office');

            // Upload Süreci...
            if ($_FILES["cus_logo"]["name"] !== "") {

                $file_name = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config["file_name"] = $file_name;

                $this->load->library("upload", $config);

                $upload = $this->upload->do_upload("cus_logo");

                if ($upload) {

                    $data['cus_logo'] = $this->upload->data("file_name");
                    unlink("uploads/{$this->viewFolder}/$item->cus_logo");

                } else {

                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => trans("error_upload_image"),
                        "type" => "error",
                        "position" => "top-center"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("customers/updateForm/$id"));

                    die();

                }

            }

            $update = $this->customers_model->update(array("cus_id" => $id), $data);

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

            redirect(base_url("customers"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_customer");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->customers_model->get(
                array(
                    "cus_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("customers", "delete")) {
            redirect(base_url());
        }

        $item = $this->customers_model->get(
            array(
                "cus_id" => $id
            )
        );

        $delete = $this->customers_model->delete(
            array(
                "cus_id" => $id
            )
        );

        if ($delete) {

            unlink("uploads/{$this->viewFolder}/$item->cus_logo");
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
        redirect(base_url('customers'));
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

            $update = $this->customers_model->update(array("cus_id" => $id), array("cus_isActive" => $isActive));

        }

    }

    /* Activities */

    public function activities($id)
    {

        if (!permission("customers", "activities")) {
            redirect(base_url());
        }

        //Verilerin getirilmesi
        $item = $this->customers_model->get(array("cus_id" => $id));

        $invoices = $this->db
            ->where(array("cus_id" => $id))
            ->order_by("inv_cre_date DESC")
            ->get("invoices")
            ->result();

        $invSum = $this->db
            ->where(array("cus_id" => $id))
            ->select_sum('inv_total')
            ->get('invoices')
            ->row();

        $invPaySum = $this->db
            ->where(array("cus_id" => $id))
            ->join('invoices', 'invoices.inv_id = invoice_payments.inv_id', 'left')
            ->select_sum('inv_pay_amount')
            ->get('invoice_payments')
            ->row();

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("customer_list"), '/customers');
        $this->breadcrumbs->push($item->cus_name, '/');

        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "activities";
        $viewData->item = $item;
        $viewData->title = $item->cus_name;
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "");
        $viewData->invoices = $invoices;
        $viewData->invSum = $invSum;
        $viewData->invPaySum = $invPaySum;
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function editInfo($id)
    {

        $data["cus_info"] = $this->input->post("cus_info");

        $update = $this->customers_model->update(array("cus_id" => $id), $data);

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
        redirect($_SERVER['HTTP_REFERER']);

    }

}
