<?php

use AJUR\Toolkit\XLSXWriter;

$chars = 'abcdefgh';

$header = array('c1'=>'string','c2'=>'integer','c3'=>'integer','c4'=>'integer','c5'=>'integer');

$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1', $header, ['freeze_rows'=>1, 'freeze_columns'=>1] );
for($i=0; $i<250; $i++)
{
    $writer->writeSheetRow('Sheet1', array(
        str_shuffle($chars),
        mt_rand()%10000,
        mt_rand()%10000,
        mt_rand()%10000,
        mt_rand()%10000
    ));
}
$writer->writeToFile('xlsx-freeze-rows-columns.xlsx');
echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";
