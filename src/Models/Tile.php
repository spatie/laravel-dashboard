<?php

namespace Spatie\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @property array<string, mixed> $data
 */
class Tile extends Model
{
    protected $table = 'dashboard_tiles';

    protected $fillable = ['name', 'data'];

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

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
