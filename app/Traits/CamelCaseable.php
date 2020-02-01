<?php

namespace App\Traits;


use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

trait CamelCaseable
{
    /**
     * Encode a value to camelCase JSON
     *
     * @param $value
     * @return array
     */
    public function toCamelCase($value)
    {
        if ($value instanceof Arrayable) {
            return $this->encodeArrayable($value);
        } else if (is_array($value)) {
            return $this->encodeArray($value);
        } else if (is_object($value)) {
            return $this->encodeArray((array)$value);
        } else {
            return $value;
        }
    }

    /**
     * Encode an arrayable
     *
     * @param Arrayable $arrayable
     * @return array
     */
    private function encodeArrayable($arrayable)
    {
        $array = $arrayable->toArray();
        return $this->toCamelCase($array);
    }

    /**
     * Encode an array
     *
     * @param $array
     * @return array
     */
    private function encodeArray($array)
    {
        $newArray = [];
        foreach ($array as $key => $val) {
            $newArray[Str::camel($key)] = $this->toCamelCase($val);
        }
        return $newArray;
    }
}