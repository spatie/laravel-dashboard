<?php

namespace Spatie\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Tile extends Model
{
    protected $table = 'dashboard_tiles';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];

    public static function firstOrCreateForName(string $name): self
    {
        return static::firstOrCreate(['name' => $name]);
    }

    public function putData(string $name, mixed $value): self
    {
        $currentData = $this->data;

        $currentData[$name] = $value;

        $this->update([
            'data' => $currentData,
        ]);

        return $this;
    }

    public function getData(string $name): mixed
    {
        return Arr::get($this->data, $name);
    }
}
