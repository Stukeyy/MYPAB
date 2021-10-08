<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'global',
        'parent_id',
        'colour'
    ];

    /**
     * Get the parent of the tag.
     */
    public function parent()
    {
        return $this->hasOne(Tag::class, 'id', 'parent_id');
    }

    /**
     * Get the children of the tag.
     */
    public function children()
    {
        return $this->hasMany(Tag::class, 'parent_id', 'id');
    }

}
