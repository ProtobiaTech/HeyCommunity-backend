<?php

namespace App;

class Dataset
{
    /**
     * @var string
     */
    public $label = 'Label';

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var string
     */
    public $backgroundColor = 'rgba(75,19,12,0.4)';

    /**
     *
     */
    public function __construct($label = null, $backgroundColor = null, $data = null)
    {
        if ($label !== null) {
            $this->label = $label;
        }

        if ($data !== null) {
            $this->data = $data;
        }

        if ($backgroundColor !== null) {
            $this->backgroundColor = $backgroundColor;
        }
    }
}
