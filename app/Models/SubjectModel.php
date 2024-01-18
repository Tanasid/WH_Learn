<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table = 'sys_subject';
    protected $allowedFields = ['ss_id','ss_subject_name', 'ss_link','ss_document','ss_method', 'ss_status_flg','ss_created_date','ss_created_by','ss_updated_date', 'ss_updated_by'];

    public function insertSubject($dataInput) {
        return $this->insert($dataInput);
    }

}