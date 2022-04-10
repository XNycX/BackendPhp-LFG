<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    protected $table = 'parties';
    public $fillable = [
        'name',
        'owner',
        'gameId'
    ];
    public function games() {
        return $this->belongsTo('App\Models\Game','gameId','id' );
    }
    public function belongs() {
        return $this->hasMany(BelongTo::class);
    }
}
