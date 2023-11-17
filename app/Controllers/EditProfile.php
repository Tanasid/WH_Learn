<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ManageAccountModel;

class EditProfile extends Controller
{
    public function index()
    {
        $content = view('editProfile');
        $anotherJS = '
        <script src="/assets/js/editProfile.js"></script>
        ';
        $data = [
            "title_page" => "Edit Profile",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function updateProfile()
    {
        $session = session();
        $su_emp_code = $this->request->getPost('empCode');
        // $nameControl = $this->request->getPost('nameControl');
        $pass = $this->request->getPost('empPassword');
        $oldpass = $this->request->getPost('oldPassword');

        if ($pass != $oldpass) {
            $pass = md5($pass);
        }

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT su_emp_code FROM sys_user WHERE su_emp_code = '$su_emp_code' ");
        $resutlName = $checkName->getResultArray();
        if (count($resutlName) == 1) {

            $userID = $this->request->getPost('suID');
            $data = [
                'su_emp_code' => $su_emp_code,
                'su_emp_password' => $pass,
                'spg_id' => $this->request->getPost('permissionGroup'),
                'su_firstname' => $this->request->getPost('firstName'),
                'su_lastname' => $this->request->getPost('lastName'),
                'su_email' => $this->request->getPost('email'),
                'mpc_id' => $this->request->getPost('plant'),
                'su_status_flg' => '1',
                'su_updated_date' => date('Y-m-d H:i:s'),
                'su_updated_by' => $session->get('firstname'),
            ];

            $model = new ManageAccountModel();
            $model->updateUserData($userID, $data);

            $response = ['success' => true];
            return $this->response->setJSON($response);

        } else if (count($resutlName) >= 1) {

            return $this->response->setJSON(['success' => false, 'message' => 'Employee Code is 
            already exist']);
        }
    }
}
