<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPC_Department extends Model
{
    use HasFactory;

    protected $connection = 'mysql_gpcentral';

    protected $table = 'departments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'organization_id',
        'code',
        'name',
        'seal_image',
        'start_date',
        'end_date',
        'active',
    ];
}