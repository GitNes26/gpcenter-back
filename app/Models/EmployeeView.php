<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeView extends Model
{
    /**
     * Especificar la conexion si no es la por default
     * @var string
     */
    protected $connection = 'mysql_gpcentral';

    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'vw_employees';
}