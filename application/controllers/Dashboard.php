<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'dashboard';
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
        $firstDay = date("Y/m/d", strtotime("first day of this month"));
        $lastDay = date("Y/m/d", strtotime("last day of this month"));

        $calendar = $this->db
            ->where("end_date >=", $today)
            ->where("start_date <=", $today)
            ->order_by("")
            ->get("calendar")
            ->result();

        //Daily profit-benefit
        $incomeDaily = $this->db
            ->select("*")
            ->where("op_date <=", date("Y/m/d"))
            ->where("op_date >=", date("Y/m/d"))
            ->select_sum("op_price")
            ->get("incomes")
            ->result();

        $expenseDaily = $this->db
            ->select("*")
            ->where("op_date <=", date("Y/m/d"))
            ->where("op_date >=", date("Y/m/d"))
            ->select_sum("op_price")
            ->get("expenses")
            ->result();

        //Official
        $incomesOff = $this->db
            ->select("*")
            ->where("op_type", "official")
            ->where("op_date <=", $lastDay)
            ->where("op_date >=", $firstDay)
            ->select_sum("op_price")
            ->get("incomes")
            ->result();

        $expensesOff = $this->db
            ->select("*")
            ->where("op_type", "official")
            ->where("op_date <=", $lastDay)
            ->where("op_date >=", $firstDay)
            ->select_sum("op_price")
            ->get("expenses")
            ->result();

        //Bill-Invoice
        $invoices = $this->db
            ->select("*")
            ->where("inv_cre_date <=", $lastDay)
            ->where("inv_cre_date >=", $firstDay)
            ->select_sum("inv_total")
            ->get("invoices")
            ->result();

        $bills = $this->db
            ->select("*")
            ->where("bill_cre_date <=", $lastDay)
            ->where("bill_cre_date >=", $firstDay)
            ->select_sum("bill_total")
            ->get("bills")
            ->result();

        //Unofficial
        $incomesUnoff = $this->db
            ->select("*")
            ->where("op_type", "unofficial")
            ->where("op_date <=", $lastDay)
            ->where("op_date >=", $firstDay)
            ->select_sum("op_price")
            ->get("incomes")
            ->result();

        $expensesUnoff = $this->db
            ->select("*")
            ->where("op_type", "unofficial")
            ->where("op_date <=", $lastDay)
            ->where("op_date >=", $firstDay)
            ->select_sum("op_price")
            ->get("expenses")
            ->result();

        //Accounts
        $accounts = $this->db
            ->select("*")
            ->where("acc_isActive", 1)
            ->select_sum("acc_balance")
            ->get("accounts")
            ->result();

        //Services
        $services = $this->db
            ->select("*")
            ->where("sr_isActive", 1)
            ->get("services");

        //Products
        $products = $this->db
            ->select("*")
            ->where("pr_isActive", 1)
            ->get("products");

        /*Start ViewData */
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->title = trans("homepage");
        $viewData->calendar = $calendar;
        $viewData->incomesOff = $incomesOff;
        $viewData->expensesOff = $expensesOff;
        $viewData->invoices = $invoices;
        $viewData->bills = $bills;
        $viewData->accounts = $accounts;
        $viewData->services = $services;
        $viewData->products = $products;
        $viewData->dailyIncome = $incomeDaily;
        $viewData->dailyExpense = $expenseDaily;

        $this->load->view("{$viewData->viewFolder}/index", $viewData);
    }

    public function dontShowAgain()
    {
        set_cookie("events", "true", 60 * 60 * 24);
    }

    public function site_lang($site_lang)
    {
        $language_data = array(
            'site_lang' => $site_lang
        );

        $this->session->set_userdata($language_data);
        if ($this->session->userdata('site_lang')) {
            echo 'user session language is = ' . $this->session->userdata('site_lang');
        }
        redirect($_SERVER['HTTP_REFERER']);

        exit;
    }
}
