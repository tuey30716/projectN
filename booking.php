<?php 
include_once 'menu.php';
include_once 'discountcode.php';  
include_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function startbooking()
{
    echo "\n Booking\n";
    echo str_repeat("-",70)."\n";
    echo "\n\tBooking Name            : ";
    $bname=trim(fgets(STDIN)); $bname=strtoupper($bname);
    echo "\n\tBooking Surname         : ";
    $bsname=trim(fgets(STDIN));$bsname=strtoupper($bsname);

    while(1)
    {
        echo "\n\tBooking Person Number   : ";
        fscanf(STDIN,"%d",$bnum);
        if(is_numeric($bnum)){
        break;
        }
        else
        {
            echo "\n\tInvalid Person Number !!\n\tPlease Input Only Number\n  ";
        }
    }
    
    while(1)
    {
        echo "\n\tBooking Date(dd/mm/yyyy): ";
        $bdate=trim(fgets(STDIN));
        $getdate=explode("/",$bdate);
        $now       = new DateTime();

            if(!isset($getdate[0])&&!isset($getdate[1])&&!isset($getdate[2]))
            {
                $getdate[0]='0';
                $getdate[1]='0';
                $getdate[2]='0';
            }
            elseif(isset($getdate[0])&&isset($getdate[1])&&isset($getdate[2]))
            {
                $user_date = DateTime::createFromFormat('d/m/Y', $bdate);
            if(checkdate($getdate[0], $getdate[1], $getdate[2])&&$user_date>=$now){
                    break;
            }
            else {
                echo "\n\tInvalid Date !!\n\tPlease Input New Date\n";
            }
            }
            else 
            {
                echo "\n\tInvalid Date !!\n\tPlease Input New Date\n";
            }
    }



    echo "\n\tBooking Time(hr:mn)     : ";
    $btime=trim(fgets(STDIN));

    while(1){
        echo "\n\tDiscount Code(if have)  : ";
        $bdiscode=trim(fgets(STDIN));$bdiscode=strtoupper($bdiscode);
            if(in_array($bdiscode,discountcode())||$bdiscode=='')
            {
                if(in_array($bdiscode,discountcode())){ $checkdiscount=true;}
                else{ $checkdiscount=false;}
                break;
            }
            elseif ($bdiscode=='d'||$bdiscode=='D') 
            {
                showdiscountcode();
            }
            else
            {
                echo "\n\tInvalid Discount Code!!\n\tPlease Input Again  or Input 'd' To See Available Discount Code\n  ";
            }
    }
    


    echo "\n\tInput Number Of Food    : ";
    fscanf(STDIN,"%d",$foodnum);
    echo "\n\tInput (h) if you want to see food list\n";
    $j=0;
    $subtotal=0;
    $nettotal=0;
    for ($i=0; $i < $foodnum; $i++) { 
        $fnum=$i+1;
        echo "\n\tInput Menu Number$fnum  : ";
        $menunum[$i]=trim(fgets(STDIN));

        if(in_array_r($menunum[$i],menu()))
        {
            
            $menu=menu();
            foreach($menu as $key=>$val){
                if(in_array($menunum[$i], $val))
                {
                    $bookfood[$j][0]=$val[1];
                    $bookfood[$j][1]=$val[2];
                    $j++;
                    $subtotal+=$val[2];
                    $break;
                }            
        }
        }
        else
        {
            if($menunum[$i]=='h'||$menunum[$i]=='H')
            {
                showmenu(menu());
            }
            else
            {
                echo "\n\tInvalid Menu Number!!\n\tPlease Input Again or Input 'h' To See Food List\n ";
            }
            $i--;
        }
    }
    if(discount($bdiscode))
    {
        $discount=discount($bdiscode)*$subtotal;
        $nettotal=$subtotal-$discount;
    }
    else
    {
        $discount='No Discount';
        $nettotal+=$subtotal;
    }
    
    
    $spreadsheet = new Spreadsheet(); 
    $inputFileName = './booking/'.$bname.'.xlsx';
    $spreadsheet->getActiveSheet()->setCellValue('A1', 'BookingName')->setCellValue('B1', $bname)
    ->setCellValue('A2', 'Booking Surname')->setCellValue('B2', $bsname)
    ->setCellValue('A3', 'Booking Person Number')->setCellValue('B3', $bnum)
    ->setCellValue('A4', 'Booking Date')->setCellValue('B4', $bdate)
    ->setCellValue('A5', 'Booking Time')->setCellValue('B5', $btime)
    ->setCellValue('A6', 'Booking Food');

    (int)$afterrow=$foodnum+7;
    $spreadsheet->getActiveSheet()->fromArray($bookfood, null, 'B7');
    
    $spreadsheet->getActiveSheet()->setCellValue('A'.$afterrow, 'Subtotal')->setCellValue('C'.$afterrow, $subtotal)
    ->setCellValue('A'.($afterrow+1), 'Discount')->setCellValue('C'.($afterrow+1), $discount)
    ->setCellValue('A'.($afterrow+2), 'Net Total')->setCellValue('C'.($afterrow+2), $nettotal);


    foreach(range('A','D') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);    
    }
        $writer = new Xlsx($spreadsheet);
        $writer->save($inputFileName);

        showsummary($inputFileName);
}


function showsummary($inputFileName)
{   
    $inputFileType = 'xlsx';
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


    $worksheet = $spreadsheet->getActiveSheet();
    $menu=$worksheet->toArray();

    echo "\n Summary\n";
    echo str_repeat("-",90)."\n";
    foreach($menu as $key=>$val){

        foreach($val as $k=>$v){

            if($val[0]==$v){
                echo "   ".str_pad($v, 23, " ", STR_PAD_RIGHT);

            }
            if($val[1]==$v){
                echo "   ".str_pad($v, 45, " ", STR_PAD_RIGHT);
            }
            if($val[2]==$v&&$v!='')
            {
                if(is_numeric($v)){
                    echo "   ".str_pad(number_format($v, 2, '.', ','), 13, " ", STR_PAD_LEFT);
                }
                else
                {
                    echo "   ".str_pad($v, 13, " ", STR_PAD_LEFT);
                }
                
            }
           }
           echo "\n";
        
    }

    echo "\n\n\t\t\t\t Thank you \n";

}







//In_array for 2d array---------------------------------------------------------------
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
?>