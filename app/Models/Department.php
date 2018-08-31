<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name','introduction'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Branch::class);
    }
}
