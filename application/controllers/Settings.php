<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "settings";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'settings';
        $this->load->model('settings_model');
        $this->load->database();
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("settings", "show")) {
            redirect(base_url());
        }

        $item = $this->settings_model->get();
        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("general_setting"), '/');

        $viewData = new stdClass();

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->item = $item;
        $viewData->title = trans("general_setting");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/index", $viewData);
    }

    public function updateSetting()
    {

        if (!permission("settings", "edit")) {
            redirect(base_url());
        }

        $item = $this->settings_model->get();

        $this->load->library("form_validation");
        $this->form_validation->set_rules("settings[title]", trans("application_name"), "required|trim");
        $this->form_validation->set_rules("settings[currency]", trans("currency"), "required|trim");
        $this->form_validation->set_rules("settings[company_name]", trans("company_name"), "required|trim");
        $this->form_validation->set_rules("settings[author_name]", trans("author_name"), "required|trim");
        $this->form_validation->set_rules("settings[phone]", trans("phone"), "required|trim");
        $this->form_validation->set_rules("settings[fax]", trans("fax"), "required|trim");
        $this->form_validation->set_rules("settings[gsm]", trans("gsm"), "required|trim");
        $this->form_validation->set_rules("settings[email]", trans("email"), "required|trim|valid_email");
        $this->form_validation->set_rules("settings[tax_name]", trans("tax_office_name"), "required|trim");
        $this->form_validation->set_rules("settings[tax_number]", trans("tax_number"), "required|trim");
        $this->form_validation->set_rules("settings[address]", trans("address"), "required|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {

            if ($_FILES["logo"]["name"] !== "") {

                $file_name = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config["file_name"] = $file_name;

                $this->load->library("upload", $config);

                $upload = $this->upload->do_upload("logo");

                if ($upload) {

                    $data['logo'] = $this->upload->data("file_name");
                    unlink("uploads/{$this->viewFolder}/$item->logo");
                    $update = $this->settings_model->update(array("id" => 1), $data);

                } else {

                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => trans("error_upload_image"),
                        "type" => "error",
                        "position" => "top-center"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("settings"));

                    die();

                }

            }

            if ($_FILES["favicon"]["name"] !== "") {

                $file_name = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config["file_name"] = $file_name;

                $this->load->library("upload", $config);

                $upload = $this->upload->do_upload("favicon");

                if ($upload) {

                    $data['favicon'] = $this->upload->data("file_name");
                    unlink("uploads/{$this->viewFolder}/$item->favicon");
                    $update = $this->settings_model->update(array("id" => 1), $data);

                } else {

                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => trans("error_upload_image"),
                        "type" => "error",
                        "position" => "top-center"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("settings"));

                    die();

                }

            }

            $html = '<?php' . PHP_EOL . PHP_EOL;
            foreach ($this->input->post('settings') as $key => $val) {
                $html .= '$settings["' . $key . '"] =' . "'" . $val . "';" . PHP_EOL;
            }

            $update = file_put_contents(FCPATH . '/application/helpers/settings.php', $html);

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

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url('settings'));
            die();

        } else {

            $this->breadcrumbs->unshift(trans("homepage"), '/');
            $this->breadcrumbs->push(trans("general_setting"), '/');

            $viewData = new stdClass();

            //View'e gönderilen verilerin set edilmesi.
            $viewData->viewFolder = $this->viewFolder;
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->item = $item;
            $viewData->title = trans("general_setting");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/index", $viewData);

        }
    }

    public function dbexport()
    {

        $this->load->dbutil();
        $this->load->helper('download');
        $this->load->library('zip');

        $db_format = array(

            'ignore' => array($this->ignore_directories),

            'format' => 'zip',

            'filename' => 'my_db_backup.sql',

            'add_insert' => TRUE,

            'newline' => "\n"

        );

        $backup = &$this->dbutil->backup($db_format);

        $dbname = 'backup-on-' . date('Y-m-d') . '.zip';

        $save = 'uploads/db_backup/' . $dbname;

        write_file($save, $backup);

        force_download($dbname, $backup);

    }

}
