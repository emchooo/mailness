<?php

namespace App\Mixins;

class StringableMixins
{
    public function appendWhen()
    {
        return function (bool $when, ...$values) {
            if ($when) {
                return $this->append(...$values);
            }

            return $this;
        };
    }
}
