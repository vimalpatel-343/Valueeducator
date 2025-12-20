<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDefaultAdminUser extends Migration
{
    public function up()
    {
        $data = [
            'fld_email' => 'admin@valueeducator.com',
            'fld_password' => md5('admin123'),
            'fld_full_name' => 'Super Admin',
            'fld_role' => 'superadmin',
            'fld_status' => 1,
            'fld_created_at' => date('Y-m-d H:i:s'),
            'fld_updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->table('ve_admin_users')->insert($data);
    }

    public function down()
    {
        $this->db->table('ve_admin_users')->where('fld_email', 'admin@valueeducator.com')->delete();
    }
}