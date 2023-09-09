<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postagem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'titulo',
        'texto',
        'slug',
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'titulo' => 'string',
        'texto' => 'string',
        'slug' => 'string',
        'deleted_at' => 'datetime',
    ];
}
