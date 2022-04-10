<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $table = 'games';
    protected $fillable = [
        'title',
        'thumbnail',
        'url', 
        'description'
];
public function user() {
    {
        return $this->hasMany(Party::class);
    }
}
}


