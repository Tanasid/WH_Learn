<?php namespace App\Models;
use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'sys_department';
    protected $allowedFields = ['sd_id','sd_department_name','sd_status_flg', 'sd_created_date','sd_created_by','sd_updated_date','sd_updated_by'];

 
    public function insertDepartment($dataInput) {
        return $this->insert($dataInput);
    }
}