<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultations extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'id',
        'registry_id',
        'queries',
        'description',
        'link',
        'request_key',
        'agreed_begin_time',
        'agreed_end_time',
        'begin_time',
        'category',
        'complexity',
        'current_department',
        'customer_key',
        'customer_priority',
        'department_begin_time',
        'department_end_time',
        'department_insertion',
        'end_time',
        'insertion',
        'long_description',
        'planned_begin_time',
        'planned_end_time',
        'priority',
        'severity',
        'status',
        'status_description',
        'summary_text',
        'task_type',
        'documentation',
        'revision',
        'bug',
        'daily',
        'update',
        'service_forecast'

    ];
}
