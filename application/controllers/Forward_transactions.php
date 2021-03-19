<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forward_transactions extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "forward_transactions";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'forward_transactions';
        $this->load->model('forward_transactions_model');
        $this->load->model('accounts_model');
        $this->load->model('incomes_model');
        $this->load->model('income_category_model');
        $this->load->model('customers_model');
        $this->load->model('expenses_model');
        $this->load->model('expense_category_model');
        $this->load->model('suppliers_model');
        $this->load->model('calendar_model');
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("forward_transactions", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("forward_transactions"), '/forward_transactions');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        $items = $this->forward_transactions_model->getAll(
            array(),
            "op_date ASC"
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("forward_transactions");
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("forward_transactions", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("forward_transactions"), '/forward_transactions');
        $this->breadcrumbs->push(trans("add_new"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_new");
        $viewData->breadcrumbs = $this->breadcrumbs->show();
        $viewData->accounts = $this->accounts_model->getAll(array("acc_isActive" => 1), "acc_name ASC");
        $viewData->customers = $this->customers_model->getAll(array("cus_isActive" => 1), "");
        $viewData->suppliers = $this->suppliers_model->getAll(array("sup_isActive" => 1), "");
        $viewData->expense_categories = $this->expense_category_model->getAll(array("exc_isActive" => 1), "");
        $viewData->income_categories = $this->income_category_model->getAll(array("inc_isActive" => 1), "");

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("forward_transactions", "add")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("forward_transactions"), '/forward_transactions');
        $this->breadcrumbs->push(trans("add_new"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("op_price", trans("price"), "required|trim");
        $this->form_validation->set_rules("op_date", trans("date"), "required|trim");
        $this->form_validation->set_rules("op_description", trans("description"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data["acc_id"] = $this->input->post("acc_id");
            $data["op_type"] = $this->input->post("op_type");
            $data["op_price"] = $this->input->post("op_price");
            $data["op_date"] = $this->input->post("op_date");
            $data["op_description"] = $this->input->post("op_description");
            $data["transaction_type"] = $this->input->post("transaction_type");

            if ($this->input->post("transaction_type") == "income") {
                $data["cus_sup_id"] = $this->input->post("cus_id");
                $data["inc_exc_id"] = $this->input->post("inc_id");
                $bgColor = "#007E33";
                $textColor = "#FFF";
            } else {
                $data["cus_sup_id"] = $this->input->post("sup_id");
                $data["inc_exc_id"] = $this->input->post("exc_id");
                $bgColor = "#CC0000";
                $textColor = "#FFF";
            }

            //Form verilerini kaydet
            $insert = $this->forward_transactions_model->add($data);
            if ($insert) {

                $date = str_replace("/", "-", $data["op_date"]);

                $this->calendar_model->add(array(
                    "title" => $data["op_description"],
                    "start_date" => $date,
                    "end_date" => $date,
                    "bgColor" => $bgColor,
                    "textColor" => $textColor,
                    "fw_id" => 1
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
            redirect(base_url('forward_transactions'));

        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_new");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("forward_transactions", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("forward_transactions"), '/forward_transactions');
        $this->breadcrumbs->push(trans("update"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->forward_transactions_model->get(
            array(
                "id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("update");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("forward_transactions", "edit")) {
            redirect(base_url());
        }

        $item = $this->forward_transactions_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..
        $this->form_validation->set_rules("title", trans("title"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
        ));

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['title'] = $this->input->post('title');

            // Upload Süreci...
            /* if ($_FILES["img_url"]["name"] !== "") {

                $file_name = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config["file_name"] = $file_name;

                $this->load->library("upload", $config);

                $upload = $this->upload->do_upload("img_url");

                if ($upload) {

                    $data['img_url'] = $this->upload->data("file_name");
                    unlink("uploads/{$this->viewFolder}/$item->img_url");

                } else {

                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => "Görsel yüklenirken bir problem oluştu!",
                        "type" => "error",
                        "position" => "top-center"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("forward_transactions/updateForm/$id"));

                    die();

                }

            } */

            $update = $this->forward_transactions_model->update(array("id" => $id), $data);

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

            redirect(base_url("forward_transactions"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->title = trans("update");

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->forward_transactions_model->get(
                array(
                    "id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("forward_transactions", "delete")) {
            redirect(base_url());
        }

        $item = $this->forward_transactions_model->get(array("op_id" => $id));

        $delete = $this->forward_transactions_model->delete(
            array(
                "op_id" => $id
            )
        );

        if ($delete) {

            $this->calendar_model->delete(array("title" => $item->op_description));

            $alert = array(
                "title" => trans("has_success"),
                "text" => "Kayıt başarıyla silindi!",
                "type" => "success",
                "position" => "top-center"
            );
        } else {
            $alert = array(
                "title" => trans("has_error"),
                "text" => "Kayıt silinirken bir hata oluştu, lütfen tekrar deneyin!",
                "type" => "error",
                "position" => "top-center"
            );
        }

        $this->session->set_flashdata("alert", $alert);
        redirect(base_url('forward_transactions'));
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

            $update = $this->forward_transactions_model->update(array("id" => $id), array("isActive" => $isActive));

        }

    }

    public function rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order['ord'];

        foreach ($items as $rank => $id) {
            $this->forward_transactions_model->update(array("id" => $id, "rank !=" => $rank), array("rank" => $rank));
        }
    }
}
