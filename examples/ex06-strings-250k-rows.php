<?php

use AJUR\Toolkit\XLSXWriter;

$chars = "abcdefghijklmnopqrstuvwxyz0123456789 ";
$s = '';
for($j=0; $j<16192;$j++)
	$s.= $chars[mt_rand()%36];


$header = array('c1'=>'string','c2'=>'string','c3'=>'string','c4'=>'string');

$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1', $header);
for($i=0; $i<250000; $i++)
{
	$s1 = substr($s, mt_rand()%4000, mt_rand()%5+5);
	$s2 = substr($s, mt_rand()%8000, mt_rand()%5+5);
	$s3 = substr($s, mt_rand()%12000, mt_rand()%5+5);
	$s4 = substr($s, mt_rand()%16000, mt_rand()%5+5);
    $writer->writeSheetRow('Sheet1', array($s1, $s2, $s3, $s4) );
}
$writer->writeToFile('xlsx-strings-250k.xlsx');
echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";

