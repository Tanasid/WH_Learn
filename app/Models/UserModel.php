<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
   protected  $table = 'sys_user';
   protected  $allowedFields = ['su_id', 'su_emp_code', 'su_emp_password'];
}