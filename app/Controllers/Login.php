<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\LoginModel;

class Login extends Controller
{

    public function index()
    {
        helper(['form']);
        echo view('login');
    }

    public function auth()
    {
        $session = session();
        $model = new UserModel();


        $emp_code = $this->request->getVar('emp_code');
        $emp_password = $this->request->getVar('emp_password');
        $mdPass = md5($emp_password);
        //****************************************//
        // $ipAddress = "http://172.21.64.223/";
        $ipAddress = "http://192.168.161.219";

        if (preg_match('/[ก-๏เแโใไ]/u', $emp_password)) {
            // หากรหัสผ่านมีตัวอักษรภาษาไทย
            $session->setFlashdata('msg', 'The password must contain letters a-z, A-Z and numbers 0-9 only.');
            return redirect()->to('/login');
        }

        $data = $model->where('su_emp_code', $emp_code)->first();
        if ($data) {
            if ($data['su_status_flg'] == 0) {
                $session->setFlashdata('msg', 'Your account has been suspended.');
                return redirect()->to('/login');
            }
            $pass = $data['su_emp_password'];
            // $verify_password = password_verify($emp_password, $pass);
            if ($pass == $mdPass || $pass == $emp_password) {
                $altLoginSuccess = "<script>const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })
                  
                  Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully',
                    text: 'Hello " . $data['su_firstname'] . " " . $data['su_lastname'] . "'
                  })</script>";


                $ses_data = [
                    'user_id' => $data['su_id'],
                    'emp_code' => $data['su_emp_code'],
                    'spg_id' => $data['spg_id'],
                    'firstname' => $data['su_firstname'],
                    'lastname' => $data['su_lastname'],
                    'ipAddress' => $ipAddress,
                    'user_group_id' => $data['spg_id'],
                    'logged_in' => TRUE,
                    'altLogin' => $altLoginSuccess,
                ];

                $session->set($ses_data);
                $log_id = $session->get('user_id');
                //LogInsert
                $logModel = new LoginModel();
                $dataLog = [
                    'la_id' => null,
                    'su_id' => $log_id,
                    'la_login' => date('Y-m-d H:i:s'),
                    'la_logout' => '',
                    'la_status_flg' => 1
                ];
                $logModel->insertLogLogin($dataLog);

                $db = \Config\Database::connect();
                $logActId = $db->query("SELECT * FROM log_active WHERE su_id = '{$ses_data['user_id']}' AND la_logout = '0000-00-00 00:00:00' ORDER BY la_id DESC ");
                $resultLogId = $logActId->getResultArray();
                if (count($resultLogId) >= 1) {
                    $Login_id = $resultLogId[0]['la_id'];
                    $session->set('Login_id', $Login_id);
                }

                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Employee Code not found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $login_id = $session->get('Login_id');

        $logModel = new LoginModel();
        $dataLog = [
            'la_logout' => date('Y-m-d H:i:s'),
            'la_status_flg' => 0,
        ];

        $logModel->updateLogLogin($login_id, $dataLog);

        $session->destroy();
        return redirect()->to('/login');
        
    }

    // public function logged() {
    //     $logModel = new LoginModel();
    //     //$date = date('m/d/Y h:i:s', time());
    //     $dataLog = [
    //         'su_id' => $data['su_id'],
    //         'la_login' => date('Y-m-d H:i:s'),
    //         'la_logout' => date('Y-m-d H:i:s'),
    //         'la_status_flg' => 1,
    //     ];
    //     $db->table('log_active')->insert($dataLog); 
    //     }

}
