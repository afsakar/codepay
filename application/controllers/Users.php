<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public $viewFolder = "";
    public $tableName = "users";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'users';
        $this->load->model('users_model');
        $this->load->database();
        $this->userLoad = get_active_user();
        $this->userData = $this->session->userdata("user");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $userRole = $this->userData;
        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("user_list"), '/users');

        $viewData = new stdClass();

        //Tablodan verilerin çekilmesi.
        if ($userRole->user_type != "superadmin") {
            $items = $this->users_model->getAll(
                array("id" => $userRole->id),
                ""
            );
        } else {
            $items = $this->users_model->getAll(
                array(),
                ""
            );
        }

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->title = trans("user_list");
        $viewData->items = $items;
        $viewData->userRole = $this->userData;
        $viewData->breadcrumbs = $this->breadcrumbs->show();


        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function addForm()
    {

        $userRole = $this->userData;
        if ($userRole->user_type != "superadmin") {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/');
        $this->breadcrumbs->push(trans("users"), '/users');
        $this->breadcrumbs->push(trans("user_add"), '/');

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->title = trans("user_add");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function addItem()
    {
        $userRole = $this->userData;
        if ($userRole->user_type != "superadmin") {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("users"), '/users');
        $this->breadcrumbs->push(trans("user_add"), '/');

        $this->load->library("form_validation");

        if ($_FILES["img_url"]["name"] == "") {
            $alert = array(
                "title" => trans("has_error"),
                "text" => trans("please_select_image"),
                "type" => "error",
                "position" => "top-center"
            );
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url('users/addForm'));
            die();
        }


        $this->form_validation->set_rules("user_name", trans("user_name"), "required|is_unique[users.user_name]|trim");
        $this->form_validation->set_rules("full_name", trans("name_surname"), "required|trim");
        $this->form_validation->set_rules("email", trans("email"), "required|is_unique[users.email]|valid_email|trim");
        $this->form_validation->set_rules("password", trans("password"), "required|min_length[8]|trim");
        $this->form_validation->set_rules("re_password", trans("re_password"), "required|matches[password]|min_length[8]|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique"),
            "matches" => trans("matches"),
            "min_length" => trans("min_length")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {
            //Form'dan verileri al.
            $data['user_name'] = $this->input->post('user_name');
            $data['full_name'] = $this->input->post('full_name');
            $data['email'] = $this->input->post('email');
            $data['password'] = md5($this->input->post('password'));
            $data['user_type'] = $this->input->post('user_type');

            $randName = rand(0, 99999) . $this->viewFolder;

            $config["allowed_types"] = "jpg|jpeg|png";
            $config["upload_path"] = "uploads/$this->viewFolder/";
            $config['file_name'] = $randName;

            $this->load->library('upload', $config);

            $upload = $this->upload->do_upload("img_url");

            if ($upload) {
                $data['img_url'] = $this->upload->data("file_name");
            } else {
                $alert = array(
                    "title" => trans("has_error"),
                    "text" => trans("error_upload_image"),
                    "type" => "error",
                    "position" => "top-center"
                );
            }

            //Form verilerini kaydet
            $insert = $this->users_model->add($data);
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
            redirect(base_url('users'));
            die();
        } else {
            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $this->session->set_flashdata("formError", $viewData->formError = true);
            $viewData->title = trans("user_add");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
    }

    public function updateForm($id)
    {
        $userRole = $this->userData;
        if ($userRole->id != $id && $userRole->user_type != "superadmin") {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("users"), '/users');
        $this->breadcrumbs->push(trans("user_edit"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->users_model->get(
            array(
                "id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->userData = $this->session->userdata("user");
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $viewData->userRole = $this->userData;
        $viewData->title = trans("user_edit");
        $viewData->permissions = json_decode($item->permissions, true);
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updateItem($id)
    {
        $userRole = $this->userData;
        if ($userRole->id != $id && $userRole->user_type != "superadmin") {
            redirect(base_url());
        }

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("users"), '/users');
        $this->breadcrumbs->push(trans("user_edit"), '/');

        $item = $this->users_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..
        if ($this->input->post('user_name') != $item->user_name) {
            $this->form_validation->set_rules("user_name", trans("user_name"), "required|is_unique[users.user_name]|trim");
        }
        $this->form_validation->set_rules("full_name", trans("name_surname"), "required|trim");
        if ($this->input->post('email') != $item->email) {
            $this->form_validation->set_rules("email", trans("email"), "required|is_unique[users.email]|valid_email|trim");
        }

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "valid_email" => trans("valid_email"),
            "is_unique" => "<strong>{field}</strong>" . trans("is_unique")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['user_name'] = $this->input->post('user_name');
            $data['full_name'] = $this->input->post('full_name');
            $data['email'] = $this->input->post('email');
            if ($this->input->post("user_type")) {
                $data['user_type'] = $this->input->post('user_type');
            }
            if ($this->input->post("permissions")) {
                $data['permissions'] = json_encode($this->input->post('permissions'));
            }


            // Upload Süreci...
            if ($_FILES["img_url"]["name"] !== "") {

                $randName = rand(0, 99999) . $this->viewFolder;

                $config["allowed_types"] = "jpg|jpeg|png";
                $config["upload_path"] = "uploads/$this->viewFolder/";
                $config['file_name'] = $randName;

                $this->load->library('upload', $config);

                $upload = $this->upload->do_upload("img_url");

                if ($upload) {
                    $data['img_url'] = $this->upload->data("file_name");
                    unlink("uploads/{$this->viewFolder}/$item->img_url");
                } else {
                    $alert = array(
                        "title" => trans("has_error"),
                        "text" => trans("error_upload_image"),
                        "type" => "error",
                        "position" => "top-center"
                    );
                    $this->session->set_flashdata("alert", $alert);
                    redirect(base_url("users/updateForm/$id"));
                    die();
                }

            }

            $update = $this->users_model->update(array("id" => $id), $data);

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
            redirect(base_url("users"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $viewData->userRole = $this->userData;
            $viewData->permissions = json_decode($item->permissions, true);
            $viewData->title = trans("user_edit");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->users_model->get(
                array(
                    "id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function deleteItem($id)
    {
        $userRole = $this->userData;
        if ($userRole->user_type != "superadmin") {
            redirect(base_url());
            die();
        }
        $getItem = $this->users_model->get(array("id" => $id));

        $delete = $this->users_model->delete(
            array(
                "id" => $id
            )
        );

        if ($delete) {
            unlink("uploads/{$this->viewFolder}/$getItem->img_url");

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
        redirect(base_url('users'));
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

            $update = $this->users_model->update(array("id" => $id), array("isActive" => $isActive));

        }

    }

    public function rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order['ord'];

        foreach ($items as $rank => $id) {
            $this->users_model->update(array("id" => $id, "rank !=" => $rank), array("rank" => $rank));
        }
    }

    public function password($id)
    {

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("users"), '/users');
        $this->breadcrumbs->push(trans("change_password"), '/');

        $viewData = new stdClass();

        //Verilerin getirilmesi
        $item = $this->users_model->get(
            array(
                "id" => $id
            )
        );

        //View'e gönderilen verilerin set edilmesi.
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "password";
        $viewData->item = $item;
        $viewData->title = trans("change_password");
        $viewData->breadcrumbs = $this->breadcrumbs->show();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function updatePassword($id)
    {

        $this->breadcrumbs->unshift(trans("homepage"), '/', false);
        $this->breadcrumbs->push(trans("users"), '/users');
        $this->breadcrumbs->push(trans("change_password"), '/');

        $item = $this->users_model->get(
            array(
                "id" => $id
            )
        );

        $this->load->library("form_validation");

        // Kurallar yazilir..

        $this->form_validation->set_rules("password", trans("password"), "required|min_length[8]|trim");
        $this->form_validation->set_rules("re_password", trans("re_password"), "required|matches[password]|min_length[8]|trim");

        $this->form_validation->set_message(array(
            "required" => "<strong>{field}</strong> " . trans("cant_be_null"),
            "matches" => trans("matches"),
            "min_length" => trans("min_length")
        ));

        //Form validation çalıştır
        $validate = $this->form_validation->run();

        if ($validate) {

            $data['password'] = md5($this->input->post('password'));

            if ($data['password'] == $item->password) {
                $alert = array(
                    "title" => trans("has_error"),
                    "text" => trans("error_pass_update"),
                    "type" => "error",
                    "position" => "top-center"
                );
                $this->session->set_flashdata("alert", $alert);
                redirect(base_url("users/updatePassword/$id"));
                die();
            }

            $update = $this->users_model->update(array("id" => $id), $data);

            if ($update) {
                $alert = array(
                    "title" => trans("has_success"),
                    "text" => trans("success_pass_update"),
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
            redirect(base_url("users"));

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "password";
            $viewData->form_error = true;
            $viewData->title = trans("change_password");
            $viewData->breadcrumbs = $this->breadcrumbs->show();

            /** Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->users_model->get(
                array(
                    "id" => $id,
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

}
