<?php namespace App\Models;

use CodeIgniter\Model;

class ManageAccountModel extends Model {
    protected $table = 'sys_user'; // Name of your table

    protected $primaryKey = 'su_id'; // Primary key of your table

    protected $allowedFields = ['su_emp_code', 'su_emp_password', 'spg_id', 'sd_id','su_firstname', 'su_lastname', 'su_email', 'mpc_id', 'su_status_flg', 'su_created_date', 'su_created_by','su_updated_date', 'su_updated_by'];

    // Add more fields as needed

    protected $useAutoIncrement = true;

    // Other model configurations...
    
    public function updateUserData($suId, $newData)
    {
        $session = session();
        // Filter and sanitize data if needed
        $filteredData = [
            'su_emp_code' => $newData['su_emp_code'],
            'su_emp_password' => $newData['su_emp_password'],
            'spg_id' => $newData['spg_id'],
            'sd_id' => $newData['sd_id'],
            'su_firstname' => $newData['su_firstname'],
            'su_lastname' => $newData['su_lastname'],
            'su_email' => $newData['su_email'],
            'mpc_id' => $newData['mpc_id'],
            'su_status_flg' =>  $newData['su_status_flg'],
            'su_updated_date' => date('Y-m-d H:i:s'),
            'su_updated_by' => $session->get('emp_code')
        ];

        // Update the data in the database
        $this->where('su_id', $suId)->set($filteredData)->update();
    }

    public function deleteAccountData($suId)
    {
        return $this->delete($suId);
    }

}