<?php 
require_once 'help.php';    
require_once 'menu.php';
require_once 'booking.php';
require_once 'discountcode.php';   
require_once 'showerror.php';

$input = $_SERVER['argv'];

$optind = NULL;
$shortopts  = "hmdb";
$longopts  = array('help','menu','discount','booking');
$opts = getopt($shortopts, $longopts,$optind );
$args = array_slice($_SERVER['argv'], $optind); 
$checkerr=0;

#Help==============================================================
if(array_key_exists('help', $opts) || array_key_exists('h', $opts))
{
    if(count($args)>=1)
    {
        error($input[0]);
    }
    else
    {
    echohelp($input[0]);
    }
    $checkerr++;
}

#Menu==============================================================
if(array_key_exists('m', $opts) || array_key_exists('menu', $opts))
{
    showmenu(menu());
    $checkerr++;
}

#DiscountCode===========================================================
if(array_key_exists('discount', $opts) || array_key_exists('d', $opts))
{
    if(count($args)>=1)
    {
        error($input[0]);
    }
    else
    {
    showdiscountcode();
    }
    $checkerr++;
}

#StartBooking=======================================================
if(array_key_exists('b', $opts) || array_key_exists('booking', $opts))
{
    startbooking();
    $checkerr++;
}



if($checkerr==0){
    error($input[0]);
  
}
?>