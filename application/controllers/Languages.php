<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Languages extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "languages";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'languages';
        $this->load->model('languages_model');
        $this->load->database();
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        if (!permission("languages", "show")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("language_list"), '/language_list');

        $viewData = new stdClass();
        //Tablodan verilerin çekilmesi.
        $items = $this->languages_model->getAll(
            array(),
            ""
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $viewData->title = trans("language_list");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        if (!permission("languages", "add")) {
            redirect(base_url());
        }
        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("language_list"), '/languages');
        $this->breadcrumbs->push(trans("add_language"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("add_language");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        if (!permission("languages", "add")) {
            redirect(base_url());
        }
        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("language_list"), '/languages');
        $this->breadcrumbs->push(trans("add_language"), '/');

        $this->load->library("form_validation");

        $this->form_validation->set_rules("title", trans("language_name"), "required|is_unique[languages.title]|trim");
        $this->form_validation->set_rules("code", trans("language_code"), "required|is_unique[languages.code]|min_length[2]|max_length[4]|trim");
        $this->form_validation->set_rules("folder_name", trans("folder_name"), "required|is_unique[languages.folder_name]|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "min_length" => trans("language_code") . " " . trans("min_length_2"),
            "min_length" => trans("language_code") . " " . trans("max_length_4")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['folder_name'] = lcfirst($this->input->post('folder_name'));

            //Form verilerini kaydet
            $insert = $this->languages_model->add($data);
            if ($insert) {

                //Yeni eklenen dil için klasör oluştur
                $folder_name = $data["folder_name"];
                mkdir(APPPATH . "language/$folder_name", 0777, true);

                //Referans dosyayı yeni klasöre kopyala
                copy(APPPATH . "language/turkish/site_lang.php", APPPATH . "language/$folder_name/site_lang.php");

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
            redirect(base_url('languages'));
            die();
        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->title = trans("add_language");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {

        if (!permission("languages", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("language_list"), '/languages');
        $this->breadcrumbs->push(trans("edit_language"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->languages_model->get(
            array(
                "id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->title = trans("edit_language");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {

        if (!permission("languages", "edit")) {
            redirect(base_url());
        }
        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("language_list"), '/languages');
        $this->breadcrumbs->push(trans("edit_language"), '/');

        $item = $this->languages_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->library("form_validation");

        if ($this->input->post('title') != $item->title) {
            $this->form_validation->set_rules("title", trans("language_name"), "required|is_unique[languages.title]|trim");
        }

        if ($this->input->post('folder_name') != $item->folder_name) {
            $this->form_validation->set_rules("folder_name", trans("folder_name"), "required|is_unique[languages.folder_name]|trim");
        }

        $this->form_validation->set_rules("code", trans("language_code"), "required|min_length[2]|max_length[4]|trim");


        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "min_length" => trans("language_code") . " " . trans("min_length_2"),
            "min_length" => trans("language_code") . " " . trans("max_length_4")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();


        if ($validate) {

            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['folder_name'] = lcfirst($this->input->post('folder_name'));

            $update = $this->languages_model->update(array("id" => $id), $data);

            // TODO Alert sistemi eklenecek...
            if ($update) {

                //Klasör adı değişikliği
                $new_name = $data["folder_name"];
                if ($item->folder_name != $new_name) {
                    rename(APPPATH . "language/$item->folder_name", APPPATH . "language/$new_name");
                }

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
            redirect(base_url("languages"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->title = trans("edit_language");
            $this->session->set_flashdata("form_error", $viewData->form_error = true);
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->languages_model->get(
                array(
                    "id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        if (!permission("languages", "delete")) {
            redirect(base_url());
        }

        $item = $this->languages_model->get(
            array("id" => $id)
        );

        $delete = $this->languages_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {
            $file = APPPATH . "language/$item->folder_name/site_lang.php";
            $path = APPPATH . "language/$item->folder_name";
            unlink($file);
            rmdir($path);
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
        redirect(base_url('languages'));
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

            $update = $this->languages_model->update(array("id" => $id), array("isActive" => $isActive));

        }

    }

    public function rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order['ord'];

        foreach ($items as $rank => $id) {
            $this->languages_model->update(array("id" => $id, "rank !=" => $rank), array("rank" => $rank));
        }
    }

    public function wordsForm($id)
    {

        if (!permission("languages", "edit")) {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("language_list"), '/languages');
        $this->breadcrumbs->push(trans("edit_words"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->languages_model->get(
            array(
                "id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "words";
        $viewData->item = $item;
        $viewData->title = trans("edit_words");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateWords($id)
    {

        if (!permission("languages", "edit")) {
            redirect(base_url());
        }

        $item = $this->languages_model->get(
            array(
                "id" => $id
            )
        );

        $html = '<?php' . PHP_EOL . PHP_EOL;
        foreach ($this->input->post('lang') as $key => $val) {
            $html .= '$lang["' . $key . '"] =' . "'" . $val . "';" . PHP_EOL;
        }

        $update = file_put_contents(FCPATH . "/application/language/$item->folder_name/site_lang.php", $html);

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
        redirect(base_url("languages/wordsForm/$id"));
        die();
    }

}
