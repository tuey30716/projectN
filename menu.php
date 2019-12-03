<?php 

require_once 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

function menu()
{
    $spreadsheet = new Spreadsheet();
    $inputFileType = 'xlsx';
    $inputFileName = './menu.xlsx';

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


    $worksheet = $spreadsheet->getActiveSheet();
    $menu=$worksheet->toArray();
    return $menu;
}

function showmenu($menu)
{
    echo "\n Menu\n";
    echo str_repeat("-",70)."\n";
    echo " ".$menu[0][0]."\t".$menu[0][1]."\t\t\t\t     ".$menu[0][2]."\n";
    foreach($menu as $key=>$val){
        if($key>0)
        {
            
        foreach($val as $k=>$v){

            if($val[0]==$v){
                echo "   ".str_pad($v, 6, " ", STR_PAD_RIGHT);

            }
            if($val[1]==$v){
                echo "   ".str_pad($v, 41, " ", STR_PAD_RIGHT);
            }
            if($val[2]==$v)
            {
                echo str_pad(number_format($v, 2, '.', ','), 13, " ", STR_PAD_LEFT);
            }
           }
           echo "\n";
        }
    }
}


?>