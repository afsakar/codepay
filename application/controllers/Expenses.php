<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "expenses";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'expenses';
        $this->load->model('accounts_model');
        $this->load->model('accounts_type_model');
        $this->load->model('expenses_model');
        $this->load->model('expense_category_model');
        $this->load->model('suppliers_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("expenses", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("expense_list"), '/accounts');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->expenses_model->getAll(array(), "op_date DESC");

        $expenses = $this->db->select("op_price, op_date")->select_sum("op_price")->group_by("op_date")->limit(7)->get("expenses")->result();

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->expenses = $expenses;
        $viewData->title = trans("expense_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("expenses", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_list"), '/expenses');
        $this->breadcrumbs->push(trans("add_expense"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_expense");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
        $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
        $viewData->expense_categories = $this->expense_category_model->getAll(array("exc_isActive" => 1), "");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("expenses", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_list"), '/expenses');
        $this->breadcrumbs->push(trans("add_expense"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("op_price", trans("price"), "required|trim");
        $this->form_validation->set_rules("op_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("op_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            $data['acc_id'] = $this->input->post('acc_id');
            $data['op_type'] = $this->input->post('op_type');
            $data['sup_id'] = $this->input->post('sup_id');
            $data['exc_id'] = $this->input->post('exc_id');
            $data['op_date'] = $this->input->post('op_date');
            $data['op_price'] = $this->input->post('op_price');
            $data['op_description'] = $this->input->post('op_description');

            //Form verilerini kaydet
            $insert = $this->expenses_model->add($data);
            if ($insert) {

                $account = $this->accounts_model->get(array("acc_id" => $data["acc_id"]));
                $balance["acc_balance"] = $account->acc_balance - $data["op_price"];
                $add = $this->accounts_model->update(array("acc_id" => $data["acc_id"]), $balance);

                $supplier = $this->suppliers_model->get(array("sup_id" => $data["sup_id"]));
                $updateSupplier = $this->suppliers_model->update(array("sup_id" => $data["sup_id"]), array("sup_credit" => $supplier->sup_credit + $data["op_price"]));

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
            redirect(base_url('expenses'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_expense");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
            $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
            $viewData->expense_categories = $this->expense_category_model->getAll(array("exc_isActive" => 1), "");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("expenses", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_list"), '/expenses');
        $this->breadcrumbs->push(trans("edit_expense"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->expenses_model->get(
            array(
                "op_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_expense");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
        $viewData->expense_categories = $this->expense_category_model->getAll(array("exc_isActive" => 1), "");
        $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("expenses", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("edit_expense"), '/');

        $item = $this->db->where(array("op_id" => $id))->get("expenses")->row();

        $this->load->library("form_validation");

        $this->form_validation->set_rules("op_price", trans("price"), "required|trim");
        $this->form_validation->set_rules("op_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("op_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            $data['acc_id'] = $this->input->post('acc_id');
            $data['sup_id'] = $this->input->post('sup_id');
            $data['exc_id'] = $this->input->post('exc_id');
            $data['op_price'] = $this->input->post('op_price');
            $data['op_date'] = $this->input->post('op_date');
            $data['op_type'] = $this->input->post('op_type');
            $data['op_description'] = $this->input->post('op_description');

            $oldAccount = $this->accounts_model->get(array("acc_id" => $item->acc_id));
            $newAccount = $this->accounts_model->get(array("acc_id" => $this->input->post('acc_id')));
            $oldSupplier = $this->suppliers_model->get(array("sup_id" => $item->sup_id));
            $newSupplier = $this->suppliers_model->get(array("sup_id" => $this->input->post('sup_id')));

            /* Account Check */
            if ($this->input->post('acc_id') != $item->acc_id) {
                $updateOldAccount = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $oldAccount->acc_balance + $item->op_price));
                $updateNewAccount = $this->accounts_model->update(array("acc_id" => $this->input->post('acc_id')), array("acc_balance" => $newAccount->acc_balance - $item->op_price));
            }
            /* Account Check */

            /* Price Check */
            if ($this->input->post('acc_id') == $item->acc_id && $this->input->post('op_price') != $item->op_price) {
                $updateOldAccount = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $oldAccount->acc_balance + $item->op_price - $this->input->post('op_price')));
            }
            /* Price Check */

            /* Account and Price Check */
            if ($this->input->post('acc_id') != $item->acc_id && $this->input->post('op_price') != $item->op_price) {
                $updateOldAccount = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $oldAccount->acc_balance + $item->op_price));
                $updateNewAccount = $this->accounts_model->update(array("acc_id" => $this->input->post('acc_id')), array("acc_balance" => $newAccount->acc_balance - $this->input->post('op_price')));
            }
            /* Account and Price Check */


            $update = $this->expenses_model->update(array("op_id" => $id), $data);

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

            redirect(base_url("expenses"));

        } else {
            $viewData = new stdClass();

            //Verilerin getirilmesi
            $item = $this->expenses_model->get(
                array(
                    "op_id" => $id
                )
            );

            //View'e gönderilen verilerin set edilmesi.
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->item = $item;
            $viewData->title = trans("edit_expense");
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
            $viewData->expense_categories = $this->expense_category_model->getAll(array("exc_isActive" => 1), "");
            $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("expenses", "delete")) {
            redirect(base_url());
        }

        $item = $this->expenses_model->get(array("op_id" => $id));
        $account = $this->accounts_model->get(array("acc_id" => $item->acc_id));
        $balance = $account->acc_balance + $item->op_price;

        $delete = $this->expenses_model->delete(
            array(
                "op_id" => $id
            )
        );

        if ($delete) {
            $update = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $balance));
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
        redirect(base_url('expenses'));
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

            $update = $this->expenses_model->update(array("acc_id" => $id), array("acc_isActive" => $isActive));

        }

    }

    /* Category */
    public function expense_category()
    {
        if (!permission("expense_category", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("expense_types"), '/expense_category');

        $viewData = new stdClass();

        /* Pagination Start */
        $config["base_url"] = base_url("expenses/expense_category");
        $config["total_rows"] = $this->expense_category_model->get_count();
        $config["uri_segment"] = 3;
        $config["per_page"] = 10;
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
        $items = $this->expense_category_model->get_records(
            array(),
            "",
            $config["per_page"],
            $page
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "types";
        $viewData->subViewFolder2 = "list";
        $viewData->items = $items;
        $viewData->title = trans("expense_types");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);
    }

    public function isActiveCategory($id)
    {

        if ($id) {
            $isActive = $this->input->post("data");
            if ($isActive == "false") {
                $isActive = 0;
            } else {
                $isActive = 1;
            }

            $update = $this->expense_category_model->update(array("exc_id" => $id), array("exc_isActive" => $isActive));

        }

    }

    public function categoryForm()
    {

        if (!permission("expense_category", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_types"), '/expense_category');
        $this->breadcrumbs->push(trans("add_type"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "types";
        $viewData->subViewFolder2 = "add";
        $viewData->title = trans("add_type");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);

    }

    public function addCategory()
    {
        if (!permission("expense_category", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_types"), '/expense_category');
        $this->breadcrumbs->push(trans("add_type"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("exc_title", trans("title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['exc_title'] = $this->input->post('exc_title');

            //Form verilerini kaydet
            $insert = $this->expense_category_model->add($data);
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
            redirect(base_url('expense_category'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "types";
            $viewData->subViewFolder2 = "add";
            $viewData->title = trans("add_type");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);

        }
    }

    public function updateCategory($id)
    {

        if (!permission("expense_category", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_types"), '/expense_category');
        $this->breadcrumbs->push(trans("edit_type"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->expense_category_model->get(
            array(
                "exc_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "types";
        $viewData->subViewFolder2 = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_type");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);

    }

    public function editCategory($id)
    {

        if (!permission("expense_category", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("expense_types"), '/expense_category');
        $this->breadcrumbs->push(trans("edit_type"), '/');

        $item = $this->expense_category_model->get(
            array(
                "exc_id" => $id
            )
        );

        $this->load->library("form_validation");

        $this->form_validation->set_rules("exc_title", trans("title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['exc_title'] = $this->input->post('exc_title');

            $update = $this->expense_category_model->update(array("exc_id" => $id), $data);

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

            redirect(base_url("expense_category"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "types";
            $viewData->subViewFolder2 = "update";
            $viewData->form_error = true;
            $viewData->title = trans("edit_type");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->expense_category_model->get(
                array(
                    "exc_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);
        }

    }

    public function deleteCategory($id)
    {
        if (!permission("expense_category", "delete")) {
            redirect(base_url());
        }

        $delete = $this->expense_category_model->delete(
            array(
                "exc_id" => $id
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
        redirect(base_url('expense_category'));
    }
    /* Category */

}
