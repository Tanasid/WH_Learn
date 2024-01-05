<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ManageAccountModel;

class ManageAccount extends Controller
{

    public function index()
    {
        $content = view('manageAccount');
        $anotherJS = '<script src="/assets/js/mngAccount.js"></script>';
        $data = [
            "title_page" => "Manage Account",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];

        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }


    public function showAccount()
    {
        $session = session();

        $emp_code = $session->get('emp_code');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT su.*, pg.spg_name, sd.sd_department_name 
        from sys_user su
        LEFT JOIN sys_permission_group pg ON su.spg_id = pg.spg_id
        LEFT JOIN sys_department sd ON sd.sd_id = su.sd_id
        WHERE su_emp_code != '$emp_code' ");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function showStatus()
    {
        $su_id = $this->request->getVar('suID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT su_firstname, su_status_flg FROM sys_user WHERE su_id = $su_id");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateStatusFlag()
    {
        $session = session();
        $su_id = $this->request->getVar('suId');
        $su_flg = $this->request->getVar('suFlg');
        $su_date = date('Y-m-d H:i:s');
        $su_by = $session->get('emp_code');

        if ($su_flg == 1) {
            $su_flg = 0;
        } else if ($su_flg == 0) {
            $su_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_user SET su_status_flg = ?, su_updated_date = ?, su_updated_by = ? WHERE su_id = ?", [$su_flg, $su_date, $su_by, $su_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function getPermissionGroups()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT spg_id, spg_name, spg_status_flg FROM sys_permission_group WHERE spg_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getDepartment()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT sd_id, sd_department_name, sd_status_flg FROM sys_department WHERE sd_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getPlant()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT mpc_id, mpc_code, mpc_name FROM mst_plant_code WHERE mpc_status_flg = 1");

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function getDataEdit()
    {
        $userID = $this->request->getVar('userID');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT ssu.su_id, ssu.su_emp_code, ssu.spg_id, pg.spg_name, ssu.sd_id, ssu.su_emp_password, ssu.su_firstname, ssu.su_lastname, ssu.su_status_flg, ssu.su_email, mt.mpc_name, ssu.mpc_id
        FROM sys_user ssu
        LEFT JOIN sys_permission_group pg ON ssu.spg_id = pg.spg_id
        LEFT JOIN mst_plant_code mt on  ssu.mpc_id = mt.mpc_id
        WHERE ssu.su_id = ?", [$userID]);

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function addAccount()
    {
        $session = session();

        $su_emp_code = $this->request->getPost('empCode');
        $su_emp_password = $this->request->getPost('empPassword');
        $spg_id = $this->request->getPost('permissionGroup');
        $sd_id = $this->request->getPost('Department');
        $su_firstname = $this->request->getPost('firstName');
        $su_lastname = $this->request->getPost('lastName');
        $su_email = $this->request->getPost('email');
        $mpc_id = $this->request->getPost('plant');
        $su_date = date('Y-m-d H:i:s');
        $su_by = $session->get('emp_code');

        $mdPass = md5($su_emp_password);

        $db = \Config\Database::connect();

        $checkNameSub = $db->query("SELECT su_emp_code FROM sys_user WHERE su_emp_code = '$su_emp_code' ");
        $resutlName = $checkNameSub->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Employee Code is 
            already exist']);
        }

        $query = $db->query("INSERT INTO sys_user (su_emp_code, su_emp_password, spg_id, sd_id, su_firstname,  su_lastname, su_email, mpc_id, su_status_flg, su_created_date, su_created_by, su_updated_date, su_updated_by)
        VALUES ('$su_emp_code', '$mdPass', '$spg_id', '$sd_id', '$su_firstname', '$su_lastname', '$su_email', '$mpc_id', 1, '$su_date', '$su_by', '$su_date', '$su_by')");

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Add Account successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to Added Account']);
        }
    }

    public function updateAccount()
    {
        // Assuming you have received data from the POST request
        $suId = $this->request->getPost('suId');
        $su_emp_password = $this->request->getPost('su_emp_password');
        $oldPass = $this->request->getPost('oldPassword');
        $su_emp_code = $this->request->getPost('su_emp_code');

        $db = \Config\Database::connect();
        $checkNameSub = $db->query("SELECT su_emp_code FROM sys_user WHERE su_emp_code = '$su_emp_code' AND su_id != $suId ");
        $resutlName = $checkNameSub->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Employee Code is 
            already exist']);
        }

        if ($su_emp_password == $oldPass) {
            $mdPass = $su_emp_password;
        }else {
            $mdPass = md5($su_emp_password);
        }
        
        $newData = [
            'su_emp_code' => $su_emp_code,
            'su_emp_password' => $mdPass,
            'spg_id' => $this->request->getPost('spg_id'),
            'sd_id' => $this->request->getPost('sd_id'),
            'su_firstname' => $this->request->getPost('su_firstname'),
            'su_lastname' => $this->request->getPost('su_lastname'),
            'su_status_flg' => $this->request->getPost('su_status_flg'),
            'su_email' => $this->request->getPost('su_email'),
            'mpc_id' => $this->request->getPost('mpc_id'),
            // ... other fields you want to update
        ];
        $model = new ManageAccountModel();
        $model->updateUserData($suId, $newData);

        $response = ['success' => true];
        return $this->response->setJSON($response);
    }

    // public function deleteAccount()
    // {
    //     $su_id = $this->request->getPost('su_id');
    //     $model = new ManageAccountModel();

    //     $delete = $model->deleteAccountData($su_id);

    //     if($delete) {
    //         $response = ['success' => true];
    //     } else {
    //         $response = ['success' => false];
    //     }
    //     return $this->response->setJSON($response);
    // }


}
