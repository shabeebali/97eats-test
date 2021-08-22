<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAddon extends Model
{
    use HasFactory;


    public function options()
    {
        return $this->hasMany(ItemAddonOption::class);
    }
}
