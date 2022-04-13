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
    public function belongs() {
        return $this->hasMany(BelongTo::class);
    }
    public function messages() {
        return $this->hasMany(Message::class);
    }
    public function games() {
        return $this->belongsTo('App\Models\Game','gameId','id' );
    }
}
