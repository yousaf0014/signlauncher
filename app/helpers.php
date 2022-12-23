<?php 

function canAddDevice(){
    if(!empty(Auth::user()) && \Auth::user()->id){
        $device = \App\Device::where('user_id',\Auth::user()->id)->first();
        if(empty($device)){
            return true;
        }
        if(unUsedInvoiceCount() > 1){
            return true;
        }
    }
    return false;
}

function unUsedInvoiceCount(){
    $userID = \Auth::user()->id;
    $unusedScreen = \App\Invoice::where('user_id',$userID)->where('screen_count','>','used_count')->get();
    $count = 0;
    foreach($unusedScreen as $invoice){
        $count += ($invoice->screen_count - $invoice->used_count);
    }
    return $count;
}


function flash($message,$level = 'info'){
	session()->flash('flash_message',$message);
	session()->flash('flash_message_level',$level);
}
function stringToSlug($str){
	$str = strtolower(trim($str));
    // replace all non valid characters and spaces with an underscore
    $str = preg_replace('/[^a-z0-9-]/', '_', $str);
    $str = preg_replace('/-+/', "_", $str);
    return $str;
}
function YMD2MDY($date, $join = '-') {
    $dateArr = preg_split("/[- ]/", $date);
    return $dateArr[1] . $join . $dateArr[2] . $join . $dateArr[0];
}

function MDY2YMD($date, $join = '/') {
    $dateArr = preg_split("/[- ]/", $date);
    return $dateArr[2] . $join.  $dateArr[0]. $join. $dateArr[1] .$join. $dateArr[3];
}


function rtime($date, $join = '-') {
    $dateArr = preg_split("/[-: ]/", $date);
    return date("H:i:s", mktime($dateArr[3], $dateArr[4], $dateArr[5], $dateArr[1], $dateArr[2], $dateArr[0]));
}