<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $quarded = false;
    protected $table = 'projects';

    protected $dates = ['created_at_time', 'contracted_at', 'deadline'];

    protected $fillable = [
        'type_id',
        'title',
        'created_at_time',
        'contracted_at',
        'deadline',
        'is_chain',
        'is_on_time',
        'has_outsource',
        'has_investors',
        'worker_count',
        'service_count',
        'payment_first_step',
        'payment_second_step',
        'payment_third_step',
        'payment_fourth_step',
        'comment',
        'effective_value',


    ];
}
