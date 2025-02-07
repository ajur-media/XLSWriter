PHP_XLSXWriter
==============

This is a fork of `mk-j/php_xlsxwriter` compatible with PHP 7.2/3/4 and 8.0/1/2

Required PHP-ZIP extension, install like:

```
apt install libzip-dev php7.4-zip 
```

# Installation

`composer require ajur-media/xlsx-writer`

This library is designed to be lightweight, and have minimal memory usage.

It is designed to output an Excel compatible spreadsheet in (Office 2007+) xlsx format, with just basic features supported:
* supports PHP 7.4+ and 8.0+
* takes UTF-8 encoded input
* multiple worksheets
* supports currency/date/numeric cell formatting, simple formulas
* supports basic cell styling
* supports writing huge 100K+ row spreadsheets

Simple PHP CLI example:

```php
$data = [
    ['year','month','amount'],
    ['2003','1','220'],
    ['2003','2','153.5'],
];

$writer = new XLSXWriter();
$writer->writeSheet($data);
$writer->writeToFile('output.xlsx');
```

Simple/Advanced Cell Formats:

```php
$header = [
  'created'=>'date',
  'product_id'=>'integer',
  'quantity'=>'#,##0',
  'amount'=>'price',
  'description'=>'string',
  'tax'=>'[$$-1009]#,##0.00;[RED]-[$$-1009]#,##0.00',
];
$data = [
    ['2015-01-01',873,1,'44.00','misc','=D2*0.05'],
    ['2015-01-12',324,2,'88.00','none','=D3*0.05'],
];

$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1', $header );
foreach($data as $row)
	$writer->writeSheetRow('Sheet1', $row );
$writer->writeToFile('example.xlsx');
```

50000 rows: (1.4s, 0MB memory usage)

```php
$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1', ['c1'=>'integer','c2'=>'integer','c3'=>'integer','c4'=>'integer'] );
for($i=0; $i<50000; $i++)
{
    $writer->writeSheetRow('Sheet1', [$i, $i+1, $i+2, $i+3] );
}
$writer->writeToFile('huge.xlsx');
echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";
```
| rows   | time | memory |
| ------ | ---- | ------ |
|  50000 | 1.4s | 0MB    |
| 100000 | 2.7s | 0MB    |
| 150000 | 4.1s | 0MB    |
| 200000 | 5.7s | 0MB    |
| 250000 | 7.0s | 0MB    |

Simple cell formats map to more advanced cell formats

| simple formats | format code |
| ---------- | ---- |
| string   | @ |
| integer  | 0 |
| date     | YYYY-MM-DD |
| datetime | YYYY-MM-DD HH:MM:SS |
| time     | HH:MM:SS |
| price    | #,##0.00 |
| dollar   | [$$-1009]#,##0.00;[RED]-[$$-1009]#,##0.00 |
| euro     | #,##0.00 [$€-407];[RED]-#,##0.00 [$€-407] |


Basic cell styles:

| style        | allowed values |
| ------------ | ---- |
| font         | Arial, Times New Roman, Courier New, Comic Sans MS |
| font-size    | 8,9,10,11,12 ... |
| font-style   | bold, italic, underline, strikethrough or multiple ie: 'bold,italic' |
| border       | left, right, top, bottom,   or multiple ie: 'top,left' |
| border-style | thin, medium, thick, dashDot, dashDotDot, dashed, dotted, double, hair, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot |
| border-color | #RRGGBB, ie: #ff99cc or #f9c |
| color        | #RRGGBB, ie: #ff99cc or #f9c |
| fill         | #RRGGBB, ie: #eeffee or #efe |
| halign       | general, left, right, justify, center |
| valign       | bottom, center, distributed |


