<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "suppliers";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'suppliers';
        $this->load->model('accounts_model');
        $this->load->model('suppliers_model');
        $this->load->model('bills_model');
        $this->load->model('bill_payments_model');
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
        if (!permission("suppliers", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("supplier_list"), '/suppliers');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->suppliers_model->getAll(
            array(),
            ""
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("supplier_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("suppliers", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("supplier_list"), '/suppliers');
        $this->breadcrumbs->push(trans("add_supplier"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_supplier");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("suppliers", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("supplier_list"), '/suppliers');
        $this->breadcrumbs->push(trans("add_supplier"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("sup_name", trans("supplier_name"), "required|is_unique[suppliers.sup_name]|trim");
        $this->form_validation->set_rules("sup_owner", trans("supplier_owner"), "required|trim");
        $this->form_validation->set_rules("sup_owner_phone", trans("supplier_owner_phone"), "required|trim");
        $this->form_validation->set_rules("sup_phone", trans("phone"), "required|trim");
        // $this->form_validation->set_rules("sup_fax", trans("fax"), "required|trim");
        // $this->form_validation->set_rules("sup_gsm", trans("gsm"), "required|trim");
        $this->form_validation->set_rules("sup_email", trans("email"), "required|valid_email|trim");
        $this->form_validation->set_rules("sup_address", trans("address"), "required|trim");
        $this->form_validation->set_rules("sup_info", trans("company_info"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['sup_name'] = $this->input->post('sup_name');
            $data['sup_owner'] = $this->input->post('sup_owner');
            $data['sup_owner_phone'] = $this->input->post('sup_owner_phone');
            $data['sup_phone'] = $this->input->post('sup_phone');
            $data['sup_fax'] = $this->input->post('sup_fax');
            $data['sup_gsm'] = $this->input->post('sup_gsm');
            $data['sup_email'] = $this->input->post('sup_email');
            $data['sup_address'] = $this->input->post('sup_address');
            $data['sup_info'] = $this->input->post('sup_info');
            $data['sup_debit'] = $this->input->post('sup_debit');
            $data['sup_credit'] = $this->input->post('sup_credit');
            $data['sup_tax_number'] = $this->input->post('sup_tax_number');
            $data['sup_tax_office'] = $this->input->post('sup_tax_office');

            if ($_FILES["sup_logo"]["name"] !== "") {

                $randName = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config['file_name'] = $randName;

                $this->load->library('upload', $config);

                $upload = $this->upload->do_upload("sup_logo");

                if ($upload) {
                    $data['sup_logo'] = $this->upload->data("file_name");
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
            $insert = $this->suppliers_model->add($data);
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
            redirect(base_url('suppliers'));

        } else {
            $viewData = new stdClass();
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_supplier");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("suppliers", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("supplier_list"), '/suppliers');
        $this->breadcrumbs->push(trans("edit_supplier"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->suppliers_model->get(
            array(
                "sup_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_supplier");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("suppliers", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("supplier_list"), '/suppliers');
        $this->breadcrumbs->push(trans("edit_supplier"), '/');

        $item = $this->suppliers_model->get(
            array(
                "sup_id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..

        if ($item->sup_name != $this->input->post("sup_name")) {
            $this->form_validation->set_rules("sup_name", trans("company_name"), "required|is_unique[suppliers.sup_name]|trim");
        }
        $this->form_validation->set_rules("sup_owner", trans("company_owner"), "required|trim");
        $this->form_validation->set_rules("sup_owner_phone", trans("company_owner_phone"), "required|trim");
        $this->form_validation->set_rules("sup_phone", trans("phone"), "required|trim");
        // $this->form_validation->set_rules("sup_fax", trans("fax"), "required|trim");
        // $this->form_validation->set_rules("sup_gsm", trans("gsm"), "required|trim");
        $this->form_validation->set_rules("sup_email", trans("email"), "required|valid_email|trim");
        $this->form_validation->set_rules("sup_address", trans("address"), "required|trim");
        $this->form_validation->set_rules("sup_info", trans("company_info"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            //Form'dan verileri al.
            $data['sup_name'] = $this->input->post('sup_name');
            $data['sup_owner'] = $this->input->post('sup_owner');
            $data['sup_owner_phone'] = $this->input->post('sup_owner_phone');
            $data['sup_phone'] = $this->input->post('sup_phone');
            $data['sup_fax'] = $this->input->post('sup_fax');
            $data['sup_gsm'] = $this->input->post('sup_gsm');
            $data['sup_email'] = $this->input->post('sup_email');
            $data['sup_address'] = $this->input->post('sup_address');
            $data['sup_info'] = $this->input->post('sup_info');
            $data['sup_debit'] = $this->input->post('sup_debit');
            $data['sup_credit'] = $this->input->post('sup_credit');
            $data['sup_tax_number'] = $this->input->post('sup_tax_number');
            $data['sup_tax_office'] = $this->input->post('sup_tax_office');

            // Upload Süreci...
            if ($_FILES["sup_logo"]["name"] !== "") {

                $file_name = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config["file_name"] = $file_name;

                $this->load->library("upload", $config);

                $upload = $this->upload->do_upload("sup_logo");

                if ($upload) {

                    $data['sup_logo'] = $this->upload->data("file_name");
                    unlink("uploads/{$this->viewFolder}/$item->sup_logo");

                } else {

                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => trans("error_upload_image"),
                        "type" => "error",
                        "position" => "top-center"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("suppliers/updateForm/$id"));

                    die();

                }

            }

            $update = $this->suppliers_model->update(array("sup_id" => $id), $data);

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

            redirect(base_url("suppliers"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_supplier");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->suppliers_model->get(
                array(
                    "sup_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("suppliers", "delete")) {
            redirect(base_url());
        }

        $item = $this->suppliers_model->get(
            array(
                "sup_id" => $id
            )
        );

        $delete = $this->suppliers_model->delete(
            array(
                "sup_id" => $id
            )
        );

        if ($delete) {

            unlink("uploads/{$this->viewFolder}/$item->sup_logo");
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
        redirect(base_url('suppliers'));
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

            $update = $this->suppliers_model->update(array("sup_id" => $id), array("sup_isActive" => $isActive));

        }

    }

    /* Activities */
    public function activities($id)
    {

        if (!permission("suppliers", "activities")) {
            redirect(base_url());
        }

        //Verilerin getirilmesi
        $item = $this->suppliers_model->get(array("sup_id" => $id));

        $bills = $this->db
            ->where(array("sup_id" => $id))
            ->order_by("bill_cre_date DESC")
            ->get("bills")
            ->result();

        $invSum = $this->db
            ->where(array("sup_id" => $id))
            ->select_sum('bill_total')
            ->get('bills')
            ->row();

        $invPaySum = $this->db
            ->where(array("sup_id" => $id))
            ->join('bills', 'bills.bill_id = bill_payments.bill_id', 'left')
            ->select_sum('bill_pay_amount')
            ->get('bill_payments')
            ->row();

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("supplier_list"), '/suppliers');
        $this->breadcrumbs->push($item->sup_name, '/');

        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "activities";
        $viewData->item = $item;
        $viewData->title = $item->sup_name;
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "");
        $viewData->bills = $bills;
        $viewData->invSum = $invSum;
        $viewData->invPaySum = $invPaySum;
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function editInfo($id)
    {

        $data["sup_info"] = $this->input->post("sup_info");

        $update = $this->suppliers_model->update(array("sup_id" => $id), $data);

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
    /* Activities */

}
