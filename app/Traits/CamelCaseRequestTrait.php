<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CamelCaseRequestTrait
{
    public function validatedSnake(): array
    {
        return $this->mapToSnake($this->validated());
    }

    protected function mapToSnake(array $data): array
    {
        $snakeData = [];
        foreach ($data as $key => $value) {
            $snakeKey = Str::snake($key);
            if (is_array($value)) {
                $value = $this->mapToSnake($value);
            }
            $snakeData[$snakeKey] = $value;
        }
        return $snakeData;
    }
}
