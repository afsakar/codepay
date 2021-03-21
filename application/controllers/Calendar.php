<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller
{

    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'calendar';
        $this->load->model("calendar_model");
        $this->load->model("forward_transactions_model");
        $this->load->model("accounts_model");
        $this->load->model("incomes_model");

        if (!get_active_user()) {
            redirect(base_url("login"));
        }

    }

    public function index()
    {
        $today = date("Y-m-d");
        $calendar = $this->db->where("end_date >=", $today)->where("start_date <=", $today)->order_by("")->get("calendar")->result();

        /*Start ViewData */
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->title = trans("calendar");
        $viewData->calendar = $calendar;

        $this->load->view("{$viewData->viewFolder}/index", $viewData);
    }

    public function addItem()
    {

        $data["title"] = $this->input->post("title");
        $data["start_date"] = $this->input->post("start_date");
        $data["end_date"] = $this->input->post("end_date");
        $data["textColor"] = $this->input->post("textColor");
        $data["bgColor"] = $this->input->post("bgColor");

        $insert = $this->calendar_model->add($data);

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
        redirect(base_url("calendar"));
    }

    public function updateItem()
    {
        $id = $_POST["id"];
        $data["title"] = $_POST["title"];
        $data["start_date"] = $_POST["start"];
        $data["end_date"] = $_POST["end"];

        $item = $this->calendar_model->get(array("id" => $id));

        if ($item->fw_id != 0) {
            $oldDate = str_replace("-", "/", $data["start_date"]);
            $this->forward_transactions_model->update(array("op_description" => $data["title"]), array("op_date" => $oldDate));
        }

        $update = $this->calendar_model->update(array("id" => $id), $data);
    }

    public function deleteItem()
    {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $fw_id = $_POST["fw_id"];


        $delete = $this->calendar_model->delete(array("id" => $id));
        if ($delete) {

            if ($fw_id == 1) {
                $this->forward_transactions_model->delete(array("op_description" => $title));
            }

            $alert = array(
                "title" => trans("has_success"),
                "text" => trans("success_delete"),
                "type" => "success",
                "position" => "top-center"
            );
        }
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("calendar"));
    }
}
