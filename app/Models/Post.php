<?php

namespace App\Models;

use App\Models\Traits\Taggables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,Taggables;

    protected $fillable = ['name'];


    public function getAttribute($key)
    {
        try {
            return parent::getAttribute($key);
        } catch (\Exception $e) {
            return parent::getAttribute($this->getForeignKey());
        }
    }
}
