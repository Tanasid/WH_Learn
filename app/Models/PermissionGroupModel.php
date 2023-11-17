<?php namespace App\Models;
use CodeIgniter\Model;

class PermissionGroupModel extends Model {
    protected $table = 'sys_permission_group';
    protected $allowedFields = ['spg_id','spg_name','spg_status_flg','spg_created_date','spg_created_by','spg_updated_date','spg_updated_by'];

    public function insertPremissionGroup($dataInput) {
        return $this->insert($dataInput);
    }


}