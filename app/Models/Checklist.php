<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    /**
     * Get the checks that belong to the Checklist.
     */
    public function checks()
    {
        return $this->hasMany(Check::class);
    }

}
