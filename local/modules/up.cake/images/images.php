<?php
/** TODO delete this file */
$file = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/local/modules/up.cake/images/brauni.png');
$file['MODULE_ID'] = 'up.cake_1_1';
$file = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/local/modules/up.cake/images/brauni2.png');
$file['MODULE_ID'] = 'up.cake_1_2';
CFile::SaveFile($file,'uploads/');
$file = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/local/modules/up.cake/images/carbonarra.png');
$file['MODULE_ID'] = 'up.cake_2_1';
CFile::SaveFile($file,'uploads/');
$file = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/local/modules/up.cake/images/blinchiki.png');
$file['MODULE_ID'] = 'up.cake_3_1';
CFile::SaveFile($file,'uploads/');