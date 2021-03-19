<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounts extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "accounts";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'accounts';
        $this->load->model('accounts_model');
        $this->load->model('accounts_type_model');
        $this->load->model('expense_category_model');
        $this->load->model('income_category_model');
        $this->load->model('transfer_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("accounts", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("account_list"), '/accounts');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->accounts_model->getAll(
            array(),
            ""
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("account_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("accounts", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("add_account"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_account");
        $viewData->accTypes = $this->accounts_type_model->getAll(array("act_isActive" => 1), "rank ASC");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("accounts", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("add_account"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("acc_name", trans("account_name"), "required|is_unique[accounts.acc_name]|trim");
        if ($this->input->post("acc_type") != 0) {
            $this->form_validation->set_rules("acc_bank_name", trans("bank_name"), "required|trim");
            $this->form_validation->set_rules("acc_branch_name", trans("branch_name"), "required|trim");
            $this->form_validation->set_rules("acc_iban", trans("account_iban"), "required|exact_length[26]|is_unique[accounts.acc_iban]|trim");
        }
        $this->form_validation->set_rules("acc_number", trans("account_number"), "is_unique[accounts.acc_number]|trim");
        $this->form_validation->set_rules("acc_branch_number", trans("branch_code"), "is_unique[accounts.acc_branch_number]|trim");
        $this->form_validation->set_rules("acc_type", trans("account_type"), "required|trim");
        $this->form_validation->set_rules("acc_owner", trans("account_owner"), "required|trim");
        $this->form_validation->set_rules("acc_date", trans("date"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "exact_length" => "<strong>{field}</strong> " . trans("exact_length_26")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['acc_name'] = $this->input->post('acc_name');
            $data['acc_bank_name'] = $this->input->post('acc_bank_name');
            $data['acc_branch_name'] = $this->input->post('acc_branch_name');
            $data['acc_branch_number'] = $this->input->post('acc_branch_number');
            $data['acc_number'] = $this->input->post('acc_number');
            $data['acc_iban'] = $this->input->post('acc_iban');
            $data['acc_type'] = $this->input->post('acc_type');
            $data['acc_owner'] = $this->input->post('acc_owner');
            $data['acc_date'] = $this->input->post('acc_date');

            //Form verilerini kaydet
            $insert = $this->accounts_model->add($data);
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
            redirect(base_url('accounts'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_account");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->accTypes = $this->accounts_type_model->getAll(array("act_isActive" => 1), "rank ASC");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("accounts", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("edit_account"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->accounts_model->get(
            array(
                "acc_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_account");
        $viewData->accTypes = $this->accounts_type_model->getAll(array("act_isActive" => 1), "rank ASC");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("accounts", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("edit_account"), '/');

        $item = $this->accounts_model->get(
            array(
                "acc_id" => $id
            )
        );

        $this->load->library("form_validation");

        if ($this->input->post('acc_name') != $item->acc_name) {
            $this->form_validation->set_rules("acc_name", trans("account_name"), "required|is_unique[accounts.acc_name]|trim");
        }
        if ($this->input->post("acc_type") != 0) {
            $this->form_validation->set_rules("acc_bank_name", trans("bank_name"), "required|trim");
            $this->form_validation->set_rules("acc_branch_name", trans("branch_name"), "required|trim");
        }
        if ($this->input->post('account_iban') != $item->account_iban && $this->input->post("acc_type") != 0) {
            $this->form_validation->set_rules("acc_iban", trans("account_iban"), "required|exact_length[26]|is_unique[accounts.acc_iban]|trim");
        }
        if ($this->input->post('acc_number') != $item->acc_number) {
            $this->form_validation->set_rules("acc_number", trans("account_number"), "is_unique[accounts.acc_number]|trim");
        }
        if ($this->input->post('acc_branch_number') != $item->acc_branch_number) {
            $this->form_validation->set_rules("acc_branch_number", trans("branch_code"), "is_unique[accounts.acc_branch_number]|trim");
        }
        $this->form_validation->set_rules("acc_type", trans("account_type"), "required|trim");
        $this->form_validation->set_rules("acc_owner", trans("account_owner"), "required|trim");
        $this->form_validation->set_rules("acc_date", trans("date"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "exact_length" => "<strong>{field}</strong> " . trans("exact_length_26")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['acc_name'] = $this->input->post('acc_name');
            $data['acc_bank_name'] = $this->input->post('acc_bank_name');
            $data['acc_branch_name'] = $this->input->post('acc_branch_name');
            $data['acc_branch_number'] = $this->input->post('acc_branch_number');
            $data['acc_number'] = $this->input->post('acc_number');
            $data['acc_iban'] = $this->input->post('acc_iban');
            $data['acc_type'] = $this->input->post('acc_type');
            $data['acc_owner'] = $this->input->post('acc_owner');
            $data['acc_date'] = $this->input->post('acc_date');

            $update = $this->accounts_model->update(array("acc_id" => $id), $data);

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

            redirect(base_url("accounts"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_account");
            $viewData->accTypes = $this->accounts_type_model->getAll(array("act_isActive" => 1), "rank ASC");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->accounts_model->get(
                array(
                    "acc_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("accounts", "delete")) {
            redirect(base_url());
        }

        $delete = $this->accounts_model->delete(
            array(
                "acc_id" => $id
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
        redirect(base_url('accounts'));
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

            $update = $this->accounts_model->update(array("acc_id" => $id), array("acc_isActive" => $isActive));

        }

    }

    /* Account Types */
    public function account_types()
    {
        if (!permission("account_types", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("accounts_types_list"), '/accounts');

        $viewData = new stdClass();

        /* Pagination Start */
        $config["base_url"] = base_url("accounts/account_types");
        $config["total_rows"] = $this->accounts_type_model->get_count();
        $config["uri_segment"] = 3;
        $config["per_page"] = settings("accounts_types_pagination");
        $config["num_links"] = 2;

        $config['full_tag_open'] = "<nav aria-label='Page navigation'> <ul class='pagination pagination-sm'>";
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item pages">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item pages">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item pages">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item pages">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li class="page-item pages">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open'] = '<li class="page-item pages">';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $viewData->links = $this->pagination->create_links();
        /* Pagination End */

        //Tablodan verilerin çekilmesi.
        $items = $this->accounts_type_model->get_records(
            array(),
            "rank ASC",
            $config["per_page"],
            $page
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "types";
        $viewData->subViewFolder2 = "list";
        $viewData->items = $items;
        $viewData->title = trans("accounts_types_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);
    }

    public function isActiveType($id)
    {

        if ($id) {
            $isActive = $this->input->post("data");
            if ($isActive == "false") {
                $isActive = 0;
            } else {
                $isActive = 1;
            }

            $update = $this->accounts_type_model->update(array("act_id" => $id), array("act_isActive" => $isActive));

        }

    }

    public function typeForm()
    {

        if (!permission("account_types", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("add_acc_type"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "types";
        $viewData->subViewFolder2 = "add";
        $viewData->title = trans("add_acc_type");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);

    }

    public function addType()
    {
        if (!permission("account_types", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("add_acc_type"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("act_title", trans("acc_type_title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['act_title'] = $this->input->post('act_title');

            //Form verilerini kaydet
            $insert = $this->accounts_type_model->add($data);
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
            redirect(base_url('account_types'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "types";
            $viewData->subViewFolder2 = "add";
            $viewData->title = trans("add_acc_type");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);

        }
    }

    public function updateType($id)
    {

        if (!permission("account_types", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("edit_acc_type"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->accounts_type_model->get(
            array(
                "act_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "types";
        $viewData->subViewFolder2 = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_acc_type");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);

    }

    public function editType($id)
    {

        if (!permission("account_types", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("edit_acc_type"), '/');

        $item = $this->accounts_type_model->get(
            array(
                "act_id" => $id
            )
        );

        $this->load->library("form_validation");

        $this->form_validation->set_rules("act_title", trans("acc_type_title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['act_title'] = $this->input->post('act_title');

            $update = $this->accounts_type_model->update(array("act_id" => $id), $data);

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

            redirect(base_url("account_types"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "types";
            $viewData->subViewFolder2 = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_acc_type");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->accounts_type_model->get(
                array(
                    "act_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);
        }

    }

    public function deleteType($id)
    {
        if (!permission("account_types", "delete")) {
            redirect(base_url());
        }

        $delete = $this->accounts_type_model->delete(
            array(
                "act_id" => $id
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
        redirect(base_url('account_types'));
    }

    public function typeRankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order['ord'];

        foreach ($items as $rank => $id) {
            $this->accounts_type_model->update(array("act_id" => $id, "rank !=" => $rank), array("rank" => $rank));
        }
    }
    /* Account Types */

    /* Transfer */
    public function transferForm($id)
    {

        if (!permission("incomes", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("transfer"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->accounts_model->get(
            array(
                "acc_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "transfer";
        $viewData->item = $item;
        $viewData->title = trans("transfer");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1, "acc_id !=" => $id), "acc_name ASC");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addTransfer($id)
    {

        if (!permission("incomes", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("transfer"), '/');

        $item = $this->accounts_model->get(
            array(
                "acc_id" => $id
            )
        );

        $this->load->library("form_validation");

        $this->form_validation->set_rules("op_price", trans("price"), "required|trim");
        $this->form_validation->set_rules("op_date", trans("date"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data["t_giver_id"] = $id;
            $data["t_receiver_id"] = $this->input->post("acc_id");
            $data["t_date"] = $this->input->post("op_date");
            $data["t_price"] = $this->input->post("op_price");

            $insert = $this->transfer_model->add($data);
            $giver = $this->accounts_model->get(array("acc_id" => $id));
            $receiver = $this->accounts_model->get(array("acc_id" => $data["t_receiver_id"]));


            if ($insert) {

                $updateGiver = $this->accounts_model->update(array("acc_id" => $data["t_giver_id"]), array("acc_balance" => $giver->acc_balance - $data["t_price"]));
                $updateReceiver = $this->accounts_model->update(array("acc_id" => $data["t_receiver_id"]), array("acc_balance" => $receiver->acc_balance + $data["t_price"]));

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

            redirect(base_url("accounts"));

        } else {
            $viewData = new stdClass();

            //Verilerin getirilmesi
            $item = $this->accounts_model->get(
                array(
                    "acc_id" => $id
                )
            );

            //View'e gönderilen verilerin set edilmesi.
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "transfer";
            $viewData->item = $item;
            $viewData->title = trans("transfer");
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1, "acc_id !=" => $id), "acc_name ASC");
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteTransfer($id)
    {
        if (!permission("incomes", "delete")) {
            redirect(base_url());
        }

        $item = $this->transfer_model->get(array("t_id" => $id));

        $delete = $this->transfer_model->delete(
            array(
                "t_id" => $id
            )
        );

        $giver = $this->accounts_model->get(array("acc_id" => $item->t_giver_id));
        $receiver = $this->accounts_model->get(array("acc_id" => $item->t_receiver_id));

        if ($delete) {

            $updateGiver = $this->accounts_model->update(array("acc_id" => $giver->acc_id), array("acc_balance" => $giver->acc_balance + $item->t_price));
            $updateReceiver = $this->accounts_model->update(array("acc_id" => $receiver->acc_id), array("acc_balance" => $receiver->acc_balance - $item->t_price));

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
        redirect(base_url('operations'));
    }
    /* Transfer */

    /* Extract */
    public function extract($id)
    {
        if (!permission("accounts", "show")) {
            redirect(base_url());
        }

        //Tablodan verilerin çekilmesi.
        $items = $this->accounts_model->get(
            array("acc_id" => $id)
        );

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("extract") . " (" . $items->acc_name . ")", '/extract');

        $viewData = new stdClass();


        $getDate = $this->input->post("getDate");
        $firstDay = date("Y/m/d", strtotime("first day of this month"));
        $lastDay = date("Y/m/d", strtotime("last day of this month"));

        $endDate = $this->input->post("end_date");
        $startDate = $this->input->post("start_date");

        if (isset($getDate)) {
            $incSum = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $endDate)->where("op_date >=", $startDate)->select_sum("op_price")->get("incomes")->result();
            $incomes = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $endDate)->where("op_date >=", $startDate)->get("incomes")->result();

            $expSum = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $endDate)->where("op_date >=", $startDate)->select_sum("op_price")->get("expenses")->result();
            $expenses = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $endDate)->where("op_date >=", $startDate)->get("expenses")->result();
        } else {
            $incSum = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $lastDay)->where("op_date >=", $firstDay)->select_sum("op_price")->get("incomes")->result();
            $incomes = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $lastDay)->where("op_date >=", $firstDay)->get("incomes")->result();

            $expSum = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $lastDay)->where("op_date >=", $firstDay)->select_sum("op_price")->get("expenses")->result();
            $expenses = $this->db->select("*")->where(array("acc_id" => $id))->where("op_date <=", $lastDay)->where("op_date >=", $firstDay)->get("expenses")->result();
        }

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "extract";
        $viewData->item = $items;
        $viewData->title = trans("extract") . " (" . $items->acc_name . ")";
        $viewData->incomes = $incomes;
        $viewData->incSum = $incSum;
        $viewData->expSum = $expSum;
        $viewData->expenses = $expenses;
        $viewData->firstDay = $firstDay;
        $viewData->lastDay = $lastDay;
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    /* Extract */

}
