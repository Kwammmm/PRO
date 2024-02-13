<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new mPDF();
$mpdf->WriteHTML('<h1>hhhhhhhhhhhhhhhhh</h1>');
$mpdf->Output();
?>
