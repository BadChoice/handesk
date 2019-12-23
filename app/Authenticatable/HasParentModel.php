<?php

namespace App\Authenticatable;

use Illuminate\Support\Str;
use ReflectionClass;

trait HasParentModel
{
    public function getParentClass()
    {
        static $parentClassName;

        return $parentClassName ?: $parentClassName = (new ReflectionClass($this))->getParentClass()->getName();
    }

    public function getTable()
    {
        if (! isset($this->table)) {
            return str_replace('\\', '', Str::snake(Str::plural(class_basename($this->getParentClass()))));
        }

        return $this->table;
    }

    public function getForeignKey()
    {
        return Str::snake(class_basename($this->getParentClass())).'_'.$this->primaryKey;
    }

    public function joiningTable($related, $INSTANCE = null)
    {
        $models = [
            Str::snake(class_basename($related)),
            Str::snake(class_basename($this->getParentClass())),
        ];
        sort($models);

        return strtolower(implode('_', $models));
    }
}
