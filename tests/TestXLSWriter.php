<?php

use AJUR\Toolkit\XLSXWriter;

require __DIR__ .'/../vendor/autoload.php';

class TestXLSWriter extends XLSXWriter
{
    public function getTabRatio()
    {
        return $this->tabRatio;
    }
}