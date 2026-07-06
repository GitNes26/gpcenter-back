<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPC_EmployeeDetails extends Model
{
    use HasFactory;

    protected $connection = 'mysql_gpcentral';

    protected $table = 'employee_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'gpc_employee_id',
        'avatar',
        'signature_image',
        'license_number',
        'license_type',
        'license_due_date',
        'img_license',
        'street',
        'num_ext',
        'num_int',
        'active',
    ];
}
