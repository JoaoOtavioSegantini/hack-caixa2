<?php

namespace Tests\Unit\App\Models;

use App\Models\Postagem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostagemUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Postagem();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class,
            SoftDeletes::class,
        ];
    }

    protected function fillables(): array
    {
        return [
            'id',
            'titulo',
            'texto',
            'slug',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'titulo' => 'string',
            'texto' => 'string',
            'slug' => 'string',
            'deleted_at' => 'datetime',
        ];
    }
}
