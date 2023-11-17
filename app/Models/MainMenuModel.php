<?php namespace App\Models;
use CodeIgniter\Model;

class MainMenuModel extends Model {
    protected $table = 'sys_main_menu';

    protected $primary = 'smm_id';

    protected $allowedFields = ['smm_name', 'smm_icon', 'smm_order', 'smm_status_flg', 'smm_created_date', 'smm_created_by', 'smm_updated_date', 'smm_updated_by'];
    
    protected $useAutoIncrement = true;

    public function insertMainMenu($dataInput) {
        return $this->insert($dataInput);
    }

   
}