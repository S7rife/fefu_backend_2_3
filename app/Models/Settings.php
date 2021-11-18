<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $periodicity
 * @property integer $attempts
 */
class Settings extends Model
{
    use HasFactory;
}
