<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function policies()
    {
        return $this->hasMany(AppPolicies::class, 'app_id', 'id');
    }
}
