<?php namespace App\Models;
use CodeIgniter\Model;

class PermissionDetailModel extends Model {
    protected $table = 'sys_permission_detail';
    protected $allowedFields = ['spd_id','spg_id','smd_id','spd_status_flg','spd_created_date','spd_created_by','spd_updated_date','spd_updated_by'];  

    public function insertPermissionDetail($dataInput) {
        return $this->insert($dataInput);
    }

}