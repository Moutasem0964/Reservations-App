<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablePhoto extends Model
{
    use HasFactory;

    protected $fillable=[
        'table_id',
        'photo'
    ];

    public function table(){
        return $this->belongsTo(Table::class);
    }
}
