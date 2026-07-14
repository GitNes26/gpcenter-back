<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherRequesterView extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'username',
    //     'email',
    //     'password',
    //     'role_id',
    //     'active',
    //     'id',
    //     'user_id',
    //     'avatar',
    //     'full_name',
    //     'name',
    //     'plast_name',
    //     'mlast_name',
    //     'cellphone',
    //     // 'license_number',
    //     // 'license_type',
    //     // 'license_due_date',
    //     // 'img_license',
    //     'employee_code',
    //     // 'department_uuid',
    //     'department',
    //     'signature_image',
    //     'seal_image',
    //     // 'community_id',
    //     // 'street',
    //     // 'num_ext',
    //     // 'num_int',
    //     'role',
    //     'read',
    //     'create',
    //     'update',
    //     'delete',
    //     'more_permissions'
    // ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'deleted_at',
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'vw_voucher_requesters';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    // protected $primaryKey = 'id';
}
