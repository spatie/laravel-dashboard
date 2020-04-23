<?php

namespace Spatie\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Tile extends Model
{
    public $table = 'dashboard_tiles';

    public $guarded = [];

    public $casts = [
        'data' => 'array',
    ];

    public static function firstOrCreateForName(string $name): self
    {
        return static::firstOrCreate(['name' => $name]);
    }

    public function putData($name, $value)
    {
        $currentData = $this->data;

        $currentData[$name] = $value;

        $this->update([
            'data' => $currentData,
        ]);

        return $this;
    }

    public function getData(string $name)
    {
        return Arr::get($this->data, $name);
    }
}
