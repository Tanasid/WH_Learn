<?php

namespace App\Controllers;

use App\Models\DepartmentModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\Controller;

class Department extends Controller
{
    public function index()
    {
        $content = view('department');
        $anotherJS = '<script src="/assets/js/department.js"></script>';
        $data = [
            "title_page" => "Department",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function addDepartment()
    {
        $session = session();
        $model = new DepartmentModel();

        $dep_name = $this->request->getPost('inpName');

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT sd_department_name FROM sys_department WHERE sd_department_name = '$dep_name' ");
        $resutlName = $checkName->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Department Name is 
            already exist']);
        }

        $newData = [
            'sd_department_name' => $this->request->getPost('inpName'),
            'sd_status_flg' => 1,
            'sd_created_date' => date('Y-m-d H:i:s'),
            'sd_created_by' => $session->get('emp_code'),
            'sd_updated_date' => date('Y-m-d H:i:s'),
            'sd_updated_by' => $session->get('emp_code'),
            // ... other fields you want to update
        ];

        // return $this->response->setJSON(['error' => true, 'message' => $newData]);

        $model->insertDepartment($newData); // Return JSON response
        return $this->response->setJSON(['success' => true, 'message' => 'Data has been inserted successfully.']);
    }

    public function getDepartment()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_department");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function getDepByStatus()
    {
        $sd_id = $this->request->getVar('depID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_department WHERE sd_id = $sd_id");
        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateStatusFlg()
    {
        $session = session();

        $sd_id = $this->request->getVar('sd_id');
        $sd_status_flg = $this->request->getVar('sd_status_flg');
        $sd_date = date('Y-m-d H:i:s');
        $sd_by = $session->get('emp_code');

        if ($sd_status_flg == 1) {
            $sd_status_flg = 0;
        } else if ($sd_status_flg == 0) {
            $sd_status_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_department SET sd_status_flg = ?, sd_updated_date = ?, sd_updated_by = ? WHERE sd_id = ?", [$sd_status_flg, $sd_date, $sd_by, $sd_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function getDepartmentByID()
    {
        $sd_id = $this->request->getVar('sd_id');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_department WHERE sd_id = ?", [$sd_id]);

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateDepartment()
    {
        $session = session();

        // Assuming you have received data from the POST request
        $sd_id = $this->request->getPost('sd_id');
        $sd_department_name = $this->request->getPost('sd_departname_name');
        $sd_date = date('Y-m-d H:i:s');
        $sd_by = $session->get('emp_code');

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT sd_department_name FROM sys_department WHERE sd_department_name = '$sd_department_name' AND sd_id <> $sd_id ");
        $ResultName = $checkName->getResultArray();
        if (count($ResultName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Department Name is already exist']);
        } else {
            $query = $db->query("UPDATE sys_department
            SET sd_department_name = '$sd_department_name', sd_updated_date = '$sd_date', sd_updated_by = '$sd_by' WHERE sd_id = $sd_id");

            if ($query) {
                return $this->response->setJSON(['success' => true, 'message' => 'Updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update Department Name']);
            }
        }
    }
}
