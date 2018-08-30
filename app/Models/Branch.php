<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name','department_id','introduction'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
