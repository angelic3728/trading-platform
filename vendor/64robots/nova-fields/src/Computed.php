<?php

namespace R64\NovaFields;

class Computed extends Text
{
    use Computable;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-fields-computed';
}
