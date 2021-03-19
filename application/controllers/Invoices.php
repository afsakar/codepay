<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "invoices";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'invoices';
        $this->load->model('invoices_model');
        $this->load->model('customers_model');
        $this->load->model('services_model');
        $this->load->model('invoice_payments_model');
        $this->load->model('accounts_model');
        $this->load->model('incomes_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("invoices", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->invoices_model->getAll(
            array(),
            "inv_cre_date DESC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("invoice_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("invoices", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');
        $this->breadcrumbs->push(trans("add_invoice"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_invoice");
        $viewData->services = $this->services_model->getAll(array("sr_isActive" => 1), "sr_code ASC");
        $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("invoices", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');
        $this->breadcrumbs->push(trans("add_invoice"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("inv_number", trans("invoice_number"), "required|is_unique[invoices.inv_number]|trim");
        $this->form_validation->set_rules("inv_cre_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("cus_id", trans("customer_name"), "required|trim");
        $this->form_validation->set_rules("inv_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data["inv_number"] = $this->input->post("inv_number");
            $data["inv_cre_date"] = $this->input->post("inv_cre_date");
            $data["inv_items"] = json_encode($this->input->post("items"), JSON_UNESCAPED_UNICODE);
            $data["inv_description"] = $this->input->post("inv_description");
            $data["inv_total"] = $this->input->post("inv_total");
            $data["cus_id"] = $this->input->post("cus_id");

            //Form verilerini kaydet
            $insert = $this->invoices_model->add($data);
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
            redirect(base_url('invoices'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_invoice");
            $viewData->services = $this->services_model->getAll(array("sr_isActive" => 1), "sr_code ASC");
            $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $this->session->set_flashdata("form_error", $viewData->form_error = true);

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("invoices", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');
        $this->breadcrumbs->push(trans("edit_invoice"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->invoices_model->get(
            array(
                "inv_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_invoice");
        $viewData->services = $this->services_model->getAll(array("sr_isActive" => 1), "sr_code ASC");
        $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
        $viewData->getCustomer = $this->customers_model->get(array("cus_id" => $item->cus_id));
        $viewData->inv_items = json_decode($item->inv_items, true);
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("invoices", "edit")) {
            redirect(base_url());
        }

        $item = $this->invoices_model->get(
            array(
                "inv_id" => $id
            )
        );

        $this->load->library("form_validation");

        if ($item->inv_number != $this->input->post("inv_number")) {
            $this->form_validation->set_rules("inv_number", trans("invoice_number"), "required|is_unique[invoices.inv_number]|trim");
        }
        $this->form_validation->set_rules("inv_cre_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("cus_id", trans("customer_name"), "required|trim");
        $this->form_validation->set_rules("inv_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data["inv_number"] = $this->input->post("inv_number");
            $data["inv_cre_date"] = $this->input->post("inv_cre_date");
            $data["inv_items"] = json_encode($this->input->post("items"), JSON_UNESCAPED_UNICODE);
            $data["inv_description"] = $this->input->post("inv_description");
            $data["inv_total"] = $this->input->post("inv_total");
            $data["cus_id"] = $this->input->post("cus_id");

            $update = $this->invoices_model->update(array("inv_id" => $id), $data);

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

            redirect(base_url("invoices"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->item = $item;
            $viewData->title = trans("edit_invoice");
            $viewData->services = $this->services_model->getAll(array("sr_isActive" => 1), "sr_code ASC");
            $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
            $viewData->getCustomer = $this->customers_model->get(array("cus_id" => $item->cus_id));
            $viewData->inv_items = json_decode($item->inv_items, true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $viewData->form_error = true;

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->invoices_model->get(
                array(
                    "inv_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("invoices", "delete")) {
            redirect(base_url());
        }

        $delete = $this->invoices_model->delete(
            array(
                "inv_id" => $id
            )
        );

        if ($delete) {
            //Delete Incomes
            $getIncomes = $this->incomes_model->getAll(array("inv_id" => $id), "");
            foreach ($getIncomes as $income) {
                $deleteIncomes = $this->incomes_model->delete(array("inv_id" => $id));
            }

            //Delete Payments
            $getPayments = $this->invoice_payments_model->getAll(array("inv_id" => $id), array());
            foreach ($getPayments as $payment) {

                $account = $this->accounts_model->get(array("acc_id" => $payment->acc_id));
                $balance = $account->acc_balance - $payment->inv_pay_amount;
                $update = $this->accounts_model->update(array("acc_id" => $payment->acc_id), array("acc_balance" => $balance));

                $delete = $this->invoice_payments_model->delete(
                    array(
                        "inv_pay_id" => $payment->inv_pay_id
                    )
                );
            }

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
        redirect(base_url('invoices'));
    }

    public function getCustomer()
    {
        $data = $this->input->post("cus_id");
        $getItem = $this->db->where(array("cus_id" => $data))->get("customers")->row();
        echo '          <p class="h3">' . $getItem->cus_name . '
                            <a href="javascript:void(0)" class="btn btn-sm pull-right d-print-none" id="remove"><i class="fa fa-times text-danger"></i></a>
                        </p>
                        <address>
                            <span class="font-weight-bold">' . trans("address") . ':</span> ' . $getItem->cus_address . '<br>
                            <span class="font-weight-bold">' . trans("phone") . ':</span> ' . $getItem->cus_phone . '<br>
                            <span class="font-weight-bold">' . trans("tax_office_name") . ':</span> ' . $getItem->cus_tax_office . '<br>
                            <span class="font-weight-bold">' . trans("tax_number") . ':</span> ' . $getItem->cus_tax_number . '<br>
                            <span class="font-weight-bold">' . trans("email") . ':</span> ' . $getItem->cus_email . '
                        </address>';
    }

    public function getService()
    {
        $data = $this->input->post("sr_id");
        $getItem = $this->db->where(array("sr_id" => $data))->get("services")->row();
        echo json_encode($getItem, JSON_UNESCAPED_UNICODE);
    }

    public function payments($id, $cus_id)
    {

        if (!permission("invoices", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');
        $this->breadcrumbs->push(trans("invoice_payments"), '/invoice_payments');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->invoice_payments_model->getAll(
            array("inv_id" => $id),
            "inv_pay_date DESC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "payments";
        $viewData->items = $items;
        $viewData->invoice = $this->invoices_model->get(array("inv_id" => $id));
        $viewData->title = trans("invoice_payments");
        $viewData->cus_id = $cus_id;
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function paymentForm($id, $cus_id)
    {

        if (!permission("invoices", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');
        $this->breadcrumbs->push(trans("add_payment"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "addPayment";
        $viewData->title = trans("add_payment");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "");
        $viewData->inv_id = $id;
        $viewData->cus_id = $cus_id;
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addPayment($id, $cus_id)
    {
        if (!permission("invoices", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("invoice_list"), '/invoices');
        $this->breadcrumbs->push(trans("add_payment"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("inv_pay_amount", trans("price"), "required|trim");
        $this->form_validation->set_rules("inv_pay_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("inv_pay_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data["inv_id"] = $this->input->post("inv_id");
            $data["acc_id"] = $this->input->post("acc_id");
            $data["inv_pay_date"] = $this->input->post("inv_pay_date");
            $data["inv_pay_description"] = $this->input->post("inv_pay_description");
            $data["inv_pay_amount"] = $this->input->post("inv_pay_amount");

            //Form verilerini kaydet
            $insert = $this->invoice_payments_model->add($data);
            if ($insert) {
                $account = $this->accounts_model->get(array("acc_id" => $data["acc_id"]));
                $updateAcc = $this->accounts_model->update(array("acc_id" => $data["acc_id"]), array("acc_balance" => $account->acc_balance + $data["inv_pay_amount"]));
                $addIncome = $this->incomes_model->add(array(
                    "cus_id" => $cus_id,
                    "acc_id" => $data["acc_id"],
                    "op_date" => $data["inv_pay_date"],
                    "op_description" => $data["inv_pay_description"],
                    "op_type" => "official",
                    "op_price" => $data["inv_pay_amount"],
                    "inc_id" => 0,
                    "inv_id" => $data["inv_id"]
                ));

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
            redirect(base_url("invoices/payments/$id/$cus_id"));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "addPayment";
            $viewData->title = trans("add_payment");
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "");
            $viewData->inv_id = $id;
            $viewData->cus_id = $cus_id;
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $this->session->set_flashdata("form_error", $viewData->form_error = true);

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function deletePayment($id)
    {
        if (!permission("invoices", "delete")) {
            redirect(base_url());
        }

        $getPayments = $this->invoice_payments_model->get(array("inv_pay_id" => $id));
        $delete = $this->invoice_payments_model->delete(
            array(
                "inv_pay_id" => $id
            )
        );

        if ($delete) {

            $account = $this->accounts_model->get(array("acc_id" => $getPayments->acc_id));
            $updateAcc = $this->accounts_model->update(array("acc_id" => $getPayments->acc_id), array("acc_balance" => $account->acc_balance - $getPayments->inv_pay_amount));
            $addIncome = $this->incomes_model->delete(array("op_description" => $getPayments->inv_pay_description));

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
        redirect(base_url('invoices'));
    }

}
