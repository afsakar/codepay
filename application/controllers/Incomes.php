<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Incomes extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "incomes";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'incomes';
        $this->load->model('accounts_model');
        $this->load->model('accounts_type_model');
        $this->load->model('incomes_model');
        $this->load->model('income_category_model');
        $this->load->model('customers_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("incomes", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("income_list"), '/accounts');

        $viewData = new stdClass();
        $incomes = $this->db->select("op_price, op_date")->select_sum("op_price")->group_by("op_date")->limit(7)->get("incomes")->result();

        //Tablodan verilerin çekilmesi.
        $items = $this->incomes_model->getAll(array(), "op_date DESC");

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->incomes = $incomes;
        $viewData->title = trans("income_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("incomes", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_list"), '/incomes');
        $this->breadcrumbs->push(trans("add_income"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_income");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
        $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
        $viewData->income_categories = $this->income_category_model->getAll(array("inc_isActive" => 1), "");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("incomes", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_list"), '/incomes');
        $this->breadcrumbs->push(trans("add_income"), '/');

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
            $data['cus_id'] = $this->input->post('cus_id');
            $data['inc_id'] = $this->input->post('inc_id');
            $data['op_date'] = $this->input->post('op_date');
            $data['op_price'] = $this->input->post('op_price');
            $data['op_description'] = $this->input->post('op_description');

            //Form verilerini kaydet
            $insert = $this->incomes_model->add($data);
            if ($insert) {

                $account = $this->accounts_model->get(array("acc_id" => $data["acc_id"]));
                $balance["acc_balance"] = $account->acc_balance + $data["op_price"];
                $add = $this->accounts_model->update(array("acc_id" => $data["acc_id"]), $balance);

                $customer = $this->customers_model->get(array("cus_id" => $data["cus_id"]));
                $updateCustomer = $this->customers_model->update(array("cus_id" => $data["cus_id"]), array("cus_credit" => $customer->cus_credit + $data["op_price"]));

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
            redirect(base_url('incomes'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_income");
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
            $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
            $viewData->income_categories = $this->income_category_model->getAll(array("inc_isActive" => 1), "");
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("incomes", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_list"), '/incomes');
        $this->breadcrumbs->push(trans("edit_income"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->incomes_model->get(
            array(
                "op_id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_income");
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
        $viewData->income_categories = $this->income_category_model->getAll(array("inc_isActive" => 1), "");
        $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("incomes", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("account_list"), '/accounts');
        $this->breadcrumbs->push(trans("edit_income"), '/');

        $item = $this->db->where(array("op_id" => $id))->get("incomes")->row();

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
            $data['cus_id'] = $this->input->post('cus_id');
            $data['inc_id'] = $this->input->post('inc_id');
            $data['op_price'] = $this->input->post('op_price');
            $data['op_date'] = $this->input->post('op_date');
            $data['op_type'] = $this->input->post('op_type');
            $data['op_description'] = $this->input->post('op_description');

            $oldAccount = $this->accounts_model->get(array("acc_id" => $item->acc_id));
            $newAccount = $this->accounts_model->get(array("acc_id" => $this->input->post('acc_id')));
            $oldCustomer = $this->customers_model->get(array("cus_id" => $item->cus_id));
            $newCustomer = $this->customers_model->get(array("cus_id" => $this->input->post('cus_id')));

            /* Account Check */
            if ($this->input->post('acc_id') != $item->acc_id) {
                $updateOldAccount = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $oldAccount->acc_balance - $item->op_price));
                $updateNewAccount = $this->accounts_model->update(array("acc_id" => $this->input->post('acc_id')), array("acc_balance" => $newAccount->acc_balance + $item->op_price));
            }
            /* Account Check */

            /* Price Check */
            if ($this->input->post('acc_id') == $item->acc_id && $this->input->post('op_price') != $item->op_price) {
                $updateOldAccount = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $oldAccount->acc_balance - $item->op_price + $this->input->post('op_price')));
            }
            /* Price Check */

            /* Account and Price Check */
            if ($this->input->post('acc_id') != $item->acc_id && $this->input->post('op_price') != $item->op_price) {
                $updateOldAccount = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $oldAccount->acc_balance - $item->op_price));
                $updateNewAccount = $this->accounts_model->update(array("acc_id" => $this->input->post('acc_id')), array("acc_balance" => $newAccount->acc_balance + $this->input->post('op_price')));
            }
            /* Account and Price Check */

            $update = $this->incomes_model->update(array("op_id" => $id), $data);

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

            redirect(base_url("incomes"));

        } else {
            $viewData = new stdClass();

            //Verilerin getirilmesi
            $item = $this->incomes_model->get(
                array(
                    "op_id" => $id
                )
            );

            //View'e gönderilen verilerin set edilmesi.
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->item = $item;
            $viewData->title = trans("edit_income");
            $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
            $viewData->income_categories = $this->income_category_model->getAll(array("inc_isActive" => 1), "");
            $viewData->breadcrumbs = $this->breadcrumbs->show();
            $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
            $viewData->form_error = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("incomes", "delete")) {
            redirect(base_url());
        }

        $item = $this->incomes_model->get(array("op_id" => $id));
        $account = $this->accounts_model->get(array("acc_id" => $item->acc_id));
        $balance = $account->acc_balance - $item->op_price;
        $customer = $this->customers_model->get(array("cus_id" => $item->cus_id));

        $delete = $this->incomes_model->delete(
            array(
                "op_id" => $id
            )
        );

        if ($delete) {
            $update = $this->accounts_model->update(array("acc_id" => $item->acc_id), array("acc_balance" => $balance));
            $updateCustomer = $this->customers_model->update(array("cus_id" => $item->cus_id), array("cus_credit" => $customer->cus_credit - $item->op_price));
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
        redirect(base_url('incomes'));
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

            $update = $this->incomes_model->update(array("acc_id" => $id), array("acc_isActive" => $isActive));

        }

    }

    /* Category */
    public function income_category()
    {
        if (!permission("income_category", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("income_types"), '/income_category');

        $viewData = new stdClass();

        /* Pagination Start */
        $config["base_url"] = base_url("expenses/income_category");
        $config["total_rows"] = $this->income_category_model->get_count();
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
        $items = $this->income_category_model->get_records(
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
        $viewData->title = trans("income_types");
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

            $update = $this->income_category_model->update(array("inc_id" => $id), array("inc_isActive" => $isActive));

        }

    }

    public function categoryForm()
    {

        if (!permission("income_category", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_types"), '/income_category');
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
        if (!permission("income_category", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_types"), '/income_category');
        $this->breadcrumbs->push(trans("add_type"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("inc_title", trans("title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['inc_title'] = $this->input->post('inc_title');

            //Form verilerini kaydet
            $insert = $this->income_category_model->add($data);
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
            redirect(base_url('income_category'));

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

        if (!permission("income_category", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_types"), '/income_category');
        $this->breadcrumbs->push(trans("edit_type"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->income_category_model->get(
            array(
                "inc_id" => $id
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

        if (!permission("income_category", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("income_types"), '/income_category');
        $this->breadcrumbs->push(trans("edit_type"), '/');

        $item = $this->income_category_model->get(
            array(
                "inc_id" => $id
            )
        );

        $this->load->library("form_validation");

        $this->form_validation->set_rules("inc_title", trans("title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null")
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['inc_title'] = $this->input->post('inc_title');

            $update = $this->income_category_model->update(array("inc_id" => $id), $data);

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

            redirect(base_url("income_category"));

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
            $viewData->item = $this->income_category_model->get(
                array(
                    "inc_id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/{$viewData->subViewFolder2}/index", $viewData);
        }

    }

    public function deleteCategory($id)
    {
        if (!permission("income_category", "delete")) {
            redirect(base_url());
        }

        $delete = $this->income_category_model->delete(
            array(
                "inc_id" => $id
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
        redirect(base_url('income_category'));
    }
    /* Category */

}
