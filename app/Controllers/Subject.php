<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use CodeIgniter\Controller;

class Subject extends Controller
{
    public function index()
    {
        $content = view('subject');
        $anotherJS = '<script src="/assets/js/subject.js"></script>';
        $data = [
            "title_page" => "Subject",
            "content" => $content,
            "anotherJS" => $anotherJS,
        ];
        $page = view('start', $data);
        return $this->response->setContentType('text/html')->setBody($page);
    }

    public function getSubject()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_subject");

        $data = $query->getResultArray();
        return $this->response->setJSON($data);
    }

    public function getSubjectByStatus()
    {
        $ss_id = $this->request->getVar('subjectID');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_subject WHERE ss_id = $ss_id");
        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function addSubject()
    {
        $session = session();
        $model = new SubjectModel();

        $subject_name = $this->request->getPost('inpName');
        $subject_method = $this->request->getPost('inpMethod');
        $subject_link = $this->request->getFile('inpLink');
        $subject_doc = $this->request->getFile('inpDocument');


        ////////////////////////  File Move Link  ///////////////////////////
        if ($subject_link->isValid() && !$subject_link->hasMoved()) {
            $subject_link_name = $subject_link->getRandomName();
            // $pathDocument = FCPATH . 'uploads/'. $subject_doc_name;
            $pathLink = 'uploads/' . $subject_link_name;
            $subject_link->move('uploads/', $subject_link_name);
        }

        ////////////////////////  File Move Document  ///////////////////////////
        if ($subject_doc->isValid() && !$subject_doc->hasMoved()) {
            $subject_doc_name = $subject_doc->getRandomName();
            // $pathDocument = FCPATH . 'uploads/'. $subject_doc_name;
            $pathDocument = 'uploads/' . $subject_doc_name;
            $subject_doc->move('uploads/', $subject_doc_name);
        }

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT ss_subject_name FROM sys_subject WHERE ss_subject_name = '$subject_name' ");
        $resutlName = $checkName->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Subject Name is 
            already exist']);
        }

        $checkMethod = $db->query("SELECT ss_method FROM sys_subject WHERE ss_method = '$subject_method' ");
        $resutlName = $checkMethod->getResultArray();
        if (count($resutlName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Method Name is 
            already exist']);
        }

        $newData = [
            'ss_subject_name' => $subject_name,
            'ss_link' => $pathLink,
            'ss_document' => $pathDocument,
            'ss_method' => $subject_method,
            'ss_status_flg' => 1,
            'ss_created_date' => date('Y-m-d H:i:s'),
            'ss_created_by' => $session->get('emp_code'),
            'ss_updated_date' => date('Y-m-d H:i:s'),
            'ss_updated_by' => $session->get('emp_code'),
            // ... other fields you want to update
        ];

        // return $this->response->setJSON(['true' => true, 'message' => $newData]);

        $model->insertSubject($newData); // Return JSON response
        return $this->response->setJSON(['success' => true, 'message' => 'Data has been inserted successfully.']);
    }

    public function updateStatusFlg()
    {
        $session = session();

        $ss_id = $this->request->getVar('ss_id');
        $ss_status_flg = $this->request->getVar('ss_status_flg');
        $ss_date = date('Y-m-d H:i:s');
        $ss_by = $session->get('emp_code');

        if ($ss_status_flg == 1) {
            $ss_status_flg = 0;
        } else if ($ss_status_flg == 0) {
            $ss_status_flg = 1;
        }
        $db = \Config\Database::connect();
        $query = $db->query("UPDATE sys_subject SET ss_status_flg = ?, ss_updated_date = ?, ss_updated_by = ? WHERE ss_id = ?", [$ss_status_flg, $ss_date, $ss_by, $ss_id]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function getSubjectByID()
    {
        $ss_id = $this->request->getVar('ss_id');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sys_subject WHERE ss_id = ?", [$ss_id]);

        $data = $query->getResultArray(); // Fetch results as an array

        return $this->response->setJSON($data); // Return JSON response
    }

    public function updateSubject()
    {
        $session = session();

        // Assuming you have received data from the POST request
        $ss_id = $this->request->getPost('ss_id');
        $ss_subject_name = $this->request->getPost('ss_subject_name');
        $ss_method = $this->request->getPost('ss_method');
        $ss_document = $this->request->getPost('ss_document');
        $subject_doc = $this->request->getFile('ss_document_new');
        $ss_link = $this->request->getPost('ss_link');
        $subject_link = $this->request->getFile('ss_link_new');
        $ss_date = date('Y-m-d H:i:s');
        $ss_by = $session->get('emp_code');

        $db = \Config\Database::connect();
        $checkName = $db->query("SELECT ss_subject_name FROM sys_subject WHERE ss_subject_name = '$ss_subject_name' AND ss_id <> $ss_id");
        $ResultName = $checkName->getResultArray();

        $checkMethod = $db->query("SELECT ss_method FROM sys_subject WHERE ss_method = '$ss_method' AND ss_id <> $ss_id");
        $ResultMethod = $checkMethod->getResultArray();

        $checkLink = $db->query("SELECT ss_link FROM sys_subject WHERE ss_link = '$ss_link' AND ss_id = '$ss_id' ");
        $ResultLink = $checkLink->getResultArray();
        
        $checkDoc = $db->query("SELECT ss_document FROM sys_subject WHERE ss_document = '$ss_document' AND ss_id = '$ss_id' ");
        $ResultDoc = $checkDoc->getResultArray();
        
        // return $this->response->setJSON(['success' => false, 'message' => count($ResultLink).' And '.count($ResultDoc)]);

        if (count($ResultName) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Subject Name is already exist']);
        } else if (count($ResultMethod) >= 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Method is already exist']);
        } else if (count($ResultDoc) >= 1 && count($ResultLink) >= 1) {
            // return $this->response->setJSON(['error' => true, 'message' => 'This Here']);
            $query = $db->query("UPDATE sys_subject
            SET ss_subject_name = '$ss_subject_name', ss_method = '$ss_method', ss_updated_date = '$ss_date', ss_updated_by = '$ss_by' WHERE ss_id = $ss_id");

            if ($query) {
                return $this->response->setJSON(['success' => true, 'message' => 'Updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update subject']);
            }
        } else if (count($ResultDoc) >= 1 && count($ResultLink) == 0) {

            ////////////////////////  File Move  ///////////////////////////
            if ($subject_link->isValid() && !$subject_link->hasMoved()) {
                $subject_link_name = $subject_link->getRandomName();
                // $pathDocument = FCPATH . 'uploads/'. $subject_doc_name;
                $pathLink = 'uploads/' . $subject_link_name;
                $subject_link->move('uploads/', $subject_link_name);
            }
            $query = $db->query("UPDATE sys_subject
            SET ss_subject_name = '$ss_subject_name', ss_method = '$ss_method', ss_link = '$pathLink', ss_updated_date = '$ss_date', ss_updated_by = '$ss_by' WHERE ss_id = $ss_id");

            if ($query) {
                return $this->response->setJSON(['success' => true, 'message' => 'Updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update subject']);
            }
        } else if (count($ResultDoc) == 0 && count($ResultLink) >= 1) {

            ////////////////////////  File Move  ///////////////////////////
            if ($subject_doc->isValid() && !$subject_doc->hasMoved()) {
                $subject_doc_name = $subject_doc->getRandomName();
                // $pathDocument = FCPATH . 'uploads/'. $subject_doc_name;
                $pathDocument = 'uploads/' . $subject_doc_name;
                $subject_doc->move('uploads/', $subject_doc_name);
            }

            $query = $db->query("UPDATE sys_subject
            SET ss_subject_name = '$ss_subject_name', ss_method = '$ss_method', ss_document = '$pathDocument', ss_updated_date = '$ss_date', ss_updated_by = '$ss_by' WHERE ss_id = $ss_id");

            if ($query) {
                return $this->response->setJSON(['success' => true, 'message' => 'Updated successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update subject']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'This Here ELSE']);
        }
    }
}
