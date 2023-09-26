<?php

namespace Tests\Unit\App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Store();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class
        ];
    }

    protected function fillables(): array
    {
        return [
            'name',
            'description',
            'email',
            'user_id'
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string'
        ];
    }
}
