<?php namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model {
    protected $table = 'log_active';
    protected $allowedFields = ['la_id', 'su_id', 'la_login', 'la_logout', 'la_status_flg'];

    public function insertLogLogin($dataInput) {
        return $this->insert($dataInput);
    }

    public function updateLogLogin($login_id, $data)
    {
        $this->db->table($this->table)->where('la_id', $login_id)->update($data);
    }

}