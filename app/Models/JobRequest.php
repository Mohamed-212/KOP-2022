<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobRequest extends Model
{
    use SoftDeletes;

    public $table = 'job_requests';

    protected $fillable = [
        'id',
        'name',
        'email',
        'cv_file',
        'phone',
        'description',
        'job_id',
        'created_at',
        'updated_at',
    ];
    public function jobs(){
        return $this->belongsTo(Careers::class,'job_id','id');
    }
}
