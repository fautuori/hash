<?php
require_once('Library.php');
$counter = 0;
$hash = '062c57c3324317cfadd8ab574e60490c';
$separators = [':', '|'];
$variables = ['var1', 'var2', 'var3'];

combine($variables, $separators);
echo "Combinations: ".number_format($counter,0,',','.')."\n";
echo "Didn't found matching hashes\n";
?>