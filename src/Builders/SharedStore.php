<?php

declare(strict_types=1);

namespace OpenApiGenerator\Builders;

class SharedStore
{
    /**
     * @var array
     */
    protected array $store = [];

    /**
     * Get value from store.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return array_key_exists($key, $this->store) ? $this->store[$key] : null;
    }

    /**
     * Set value to store.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->store[$key] = $value;
    }
}
