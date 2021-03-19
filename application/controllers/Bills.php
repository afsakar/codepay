<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bills extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "bills";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'bills';
        $this->load->model('bills_model');
        $this->load->model('suppliers_model');
        $this->load->model('products_model');
        $this->load->model('bill_payments_model');
        $this->load->model('accounts_model');
        $this->load->model('expenses_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("bills", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("bill_list"), '/bills');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->bills_model->getAll(
            array(),
            "bill_cre_date DESC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("bill_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("bills", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("bill_list"), '/bills');
        $this->breadcrumbs->push(trans("add_invoice"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_invoice");
        $viewData->products = $this->products_model->getAll(array("pr_isActive" => 1), "pr_code ASC");
        $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("bills", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("bill_list"), '/bills');
        $this->breadcrumbs->push(trans("add_invoice"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("bill_number", trans("bill_number"), "required|is_unique[bills.bill_number]|trim");
        $this->form_validation->set_rules("bill_cre_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("sup_id", trans("Supplier_name"), "required|trim");
        $this->form_validation->set_rules("bill_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data["bill_number"] = $this->input->post("bill_number");
            $data["bill_cre_date"] = $this->input->post("bill_cre_date");
            $data["bill_items"] = json_encode($this->input->post("items"), JSON_UNESCAPED_UNICODE);
            $data["bill_description"] = $this->input->post("bill_description");
            $data["bill_total"] = $this->input->post("bill_total");
            $data["sup_id"] = $this->input->post("sup_id");

            //Form verilerini kaydet
            $insert = $this->bills_model->add($data);
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
            redirect(base_url('bills'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_invoice");
            $viewData->products = $this->products_model->getAll(array("pr_isActive" => 1), "pr_code ASC");
            $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $this->session->set_flashdata("form_error", $viewData->form_error = true);

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("bills", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("bill_list"), '/bills');
        $this->breadcrumbs->push(trans("edit_invoice"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->bills_model->get(
            array(
                "bill_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_invoice");
        $viewData->products = $this->products_model->getAll(array("pr_isActive" => 1), "pr_code ASC");
        $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
        $viewData->getSupplier = $this->suppliers_model->get(array("sup_id" => $item->sup_id));
        $viewData->bill_items = json_decode($item->bill_items, true);
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("bills", "edit")) {
            redirect(base_url());
        }

        $item = $this->bills_model->get(
            array(
                "bill_id" => $id
            )
        );

        $this->load->library("form_validation");

        if ($item->bill_number != $this->input->post("bill_number")) {
            $this->form_validation->set_rules("bill_number", trans("bill_number"), "required|is_unique[bills.bill_number]|trim");
        }
        $this->form_validation->set_rules("bill_cre_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("sup_id", trans("Supplier_name"), "required|trim");
        $this->form_validation->set_rules("bill_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data["bill_number"] = $this->input->post("bill_number");
            $data["bill_cre_date"] = $this->input->post("bill_cre_date");
            $data["bill_items"] = json_encode($this->input->post("items"), JSON_UNESCAPED_UNICODE);
            $data["bill_description"] = $this->input->post("bill_description");
            $data["bill_total"] = $this->input->post("bill_total");
            $data["sup_id"] = $this->input->post("sup_id");

            $update = $this->bills_model->update(array("bill_id" => $id), $data);

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

            redirect(base_url("bills"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->item = $item;
            $viewData->title = trans("edit_invoice");
            $viewData->products = $this->products_model->getAll(array("pr_isActive" => 1), "pr_code ASC");
            $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
            $viewData->getSupplier = $this->suppliers_model->get(array("sup_id" => $item->sup_id));
            $viewData->bill_items = json_decode($item->bill_items, true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $viewData->form_error = true;

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->bills_model->get(
                array(
                    "bill_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("bills", "delete")) {
            redirect(base_url());
        }

        $delete = $this->bills_model->delete(
            array(
                "bill_id" => $id
            )
        );

        if ($delete) {
            //Delete expenses
            $getexpenses = $this->expenses_model->getAll(array("bill_id" => $id), "");
            foreach ($getexpenses as $Expense) {
                $deleteexpenses = $this->expenses_model->delete(array("bill_id" => $id));
            }

            //Delete Payments
            $getPayments = $this->bill_payments_model->getAll(array("bill_id" => $id), array());
            foreach ($getPayments as $payment) {

                $account = $this->accounts_model->get(array("acc_id" => $payment->acc_id));
                $balance = $account->acc_balance + $payment->bill_pay_amount;
                $update = $this->accounts_model->update(array("acc_id" => $payment->acc_id), array("acc_balance" => $balance));

                $delete = $this->bill_payments_model->delete(
                    array(
                        "bill_pay_id" => $payment->bill_pay_id
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
        redirect(base_url('bills'));
    }

    public function getSupplier()
    {
        $data = $this->input->post("sup_id");
        $getItem = $this->db->where(array("sup_id" => $data))->get("suppliers")->row();
        echo '          <p class="h3">' . $getItem->sup_name . '
                            <a href="javascript:void(0)" class="btn btn-sm pull-right d-print-none" id="remove"><i class="fa fa-times text-danger"></i></a>
                        </p>
                        <address>
                            <span class="font-weight-bold">' . trans("address") . ':</span> ' . $getItem->sup_address . '<br>
                            <span class="font-weight-bold">' . trans("phone") . ':</span> ' . $getItem->sup_phone . '<br>
                            <span class="font-weight-bold">' . trans("tax_office_name") . ':</span> ' . $getItem->sup_tax_office . '<br>
                            <span class="font-weight-bold">' . trans("tax_number") . ':</span> ' . $getItem->sup_tax_number . '<br>
                            <span class="font-weight-bold">' . trans("email") . ':</span> ' . $getItem->sup_email . '
                        </address>';
    }

    public function getProduct()
    {
        $data = $this->input->post("pr_id");
        $getItem = $this->db->where(array("pr_id" => $data))->get("products")->row();
        echo json_encode($getItem, JSON_UNESCAPED_UNICODE);
    }

    public function payments($id, $sup_id)
    {

        if (!permission("bills", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("bill_list"), '/bills');
        $this->breadcrumbs->push(trans("bill_payments"), '/bill_payments');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->bill_payments_model->getAll(
            array("bill_id" => $id),
            "bill_pay_date DESC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "payments";
        $viewData->items = $items;
        $viewData->bill = $this->bills_model->get(array("bill_id" => $id));
        $viewData->title = trans("bill_payments");
        $viewData->sup_id = $sup_id;
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function paymentForm($id, $sup_id)
    {

        if (!permission("bills", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("bill_list"), '/bills');
        $this->breadcrumbs->push(trans("add_payment"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "addPayment";
        $viewData->title = trans("add_payment");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "");
        $viewData->bill_id = $id;
        $viewData->sup_id = $sup_id;
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addPayment($id, $sup_id)
    {
        if (!permission("bills", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("bill_list"), '/bills');
        $this->breadcrumbs->push(trans("add_payment"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("bill_pay_amount", trans("price"), "required|trim");
        $this->form_validation->set_rules("bill_pay_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("bill_pay_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data["bill_id"] = $this->input->post("bill_id");
            $data["acc_id"] = $this->input->post("acc_id");
            $data["bill_pay_date"] = $this->input->post("bill_pay_date");
            $data["bill_pay_description"] = $this->input->post("bill_pay_description");
            $data["bill_pay_amount"] = $this->input->post("bill_pay_amount");

            //Form verilerini kaydet
            $insert = $this->bill_payments_model->add($data);
            if ($insert) {
                $account = $this->accounts_model->get(array("acc_id" => $data["acc_id"]));
                $updateAcc = $this->accounts_model->update(array("acc_id" => $data["acc_id"]), array("acc_balance" => $account->acc_balance - $data["bill_pay_amount"]));
                $addExpense = $this->expenses_model->add(array(
                    "sup_id" => $sup_id,
                    "acc_id" => $data["acc_id"],
                    "op_date" => $data["bill_pay_date"],
                    "op_description" => $data["bill_pay_description"],
                    "op_type" => "official",
                    "op_price" => $data["bill_pay_amount"],
                    "exc_id" => 0,
                    "bill_id" => $data["bill_id"]
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
            redirect(base_url("bills/payments/$id/$sup_id"));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "addPayment";
            $viewData->title = trans("add_payment");
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "");
            $viewData->bill_id = $id;
            $viewData->sup_id = $sup_id;
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $this->session->set_flashdata("form_error", $viewData->form_error = true);

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function deletePayment($id)
    {
        if (!permission("bills", "delete")) {
            redirect(base_url());
        }

        $getPayments = $this->bill_payments_model->get(array("bill_pay_id" => $id));
        $delete = $this->bill_payments_model->delete(
            array(
                "bill_pay_id" => $id
            )
        );

        if ($delete) {

            $account = $this->accounts_model->get(array("acc_id" => $getPayments->acc_id));
            $updateAcc = $this->accounts_model->update(array("acc_id" => $getPayments->acc_id), array("acc_balance" => $account->acc_balance + $getPayments->bill_pay_amount));
            $addExpense = $this->expenses_model->delete(array("op_description" => $getPayments->bill_pay_description));

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
        redirect(base_url('bills'));
    }

}
