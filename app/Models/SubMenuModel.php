<?php namespace App\Models;
use CodeIgniter\Model;

class SubMenuMedel extends Model {

    protected $table = 'sys_menu_detail';
    
    protected $primaryKey = 'smd_id'; 

    protected $allowedFields = ["smm_id","smd_name","smd_link","smd_method","smd_order","spd_status_flg","spd_created_date","spd_created_by","spd_updated_date","spd_updated_by"];
    
    protected $useAutoIncrement = true;


    public function insertSubMenu($dataInput) {
        return $this->insert($dataInput);
    }

}