<?php 

function showdiscountcode()
{
    echo "\n\tDiscount Code: \n\n";
    
    echo "\t Code: DISCOUNT5  for ".str_pad("5%", 4, " ", STR_PAD_LEFT)." Discount \n";
    echo "\t Code: DISCOUNT10 for ".str_pad("10%", 4, " ", STR_PAD_LEFT)." Discount \n";
    echo "\t Code: DISCOUNT15 for ".str_pad("15%", 4, " ", STR_PAD_LEFT)." Discount \n";
    echo "\t Code: DISCOUNT20 for ".str_pad("20%", 4, " ", STR_PAD_LEFT)." Discount \n";
    echo "\t Code: DISCOUNT25 for ".str_pad("25%", 4, " ", STR_PAD_LEFT)." Discount \n";
    echo "\t Code: DISCOUNT30 for ".str_pad("30%", 4, " ", STR_PAD_LEFT)." Discount \n";
    
}

function discountcode()
{
    $discountcode=array('DISCOUNT5','DISCOUNT10','DISCOUNT15','DISCOUNT20','DISCOUNT25','DISCOUNT30');
    return $discountcode;
}

function discount($discountcode)
{
    if($discountcode=='DISCOUNT5')
    {
         return 0.05;
    }
    elseif($discountcode=='DISCOUNT10')
    {
         return 0.10;
    }
    elseif($discountcode=='DISCOUNT15')
    {
         return 0.15;
    }
    elseif($discountcode=='DISCOUNT20')
    {
         return 0.20;
    }
    elseif($discountcode=='DISCOUNT25')
    {
         return 0.25;
    }
    elseif($discountcode=='DISCOUNT30')
    {
         return 0.30;
    }
    else
    {
        return 0.0;
    }
}

?>