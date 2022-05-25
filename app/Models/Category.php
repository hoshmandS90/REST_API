<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class Category extends Model
{


    protected $table = 'categories';

    protected $fillable = [
        'name','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        if (auth()->check()) {
            static::addGlobalScope('user_id', function (Builder $builder) {
                $builder->where('user_id', auth()->user()->id);
            });
        }
       
    }
}
