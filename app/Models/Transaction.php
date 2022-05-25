<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $guarded = [];

    protected $dates=['transaction_date'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }


    protected static function booted(){
        if(Auth()->check()){
            static::AddGlobalScope('user_id',function(Builder $builder){
                $builder->where('user_id',Auth()->user()->id);
            });
        }
    }

  
}
