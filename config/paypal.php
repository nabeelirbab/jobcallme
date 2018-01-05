<?php 
return array(
/** set your paypal credential **/
'client_id' =>'AdjGu2nMwbeao5rCWwX2OFrqyK-OmvdW_dako5BNrc5mjUm6jbqbVg8bhZYqHmvlQihN3nAMgBtJ90xy',
'secret' => 'EFDsa9b5pjZJxmEOG9wtiqjhPSbwaITRrbhCKLSZonOsddoSh6cgt0tbWWhEaRuKHNqw9lFDSPuLH25W',
/**
* SDK configuration 
*/
'settings' => array(
/**
* Available option 'sandbox' or 'live'
*/
'mode' => 'sandbox',
/**
* Specify the max request time in seconds
*/
'http.ConnectionTimeOut' => 1000,
/**
* Whether want to log to a file
*/
'log.LogEnabled' => true,
/**
* Specify the file that want to write on
*/
'log.FileName' => storage_path() . '/logs/paypal.log',
/**
* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
*
* Logging is most verbose in the 'FINE' level and decreases as you
* proceed towards ERROR
*/
'log.LogLevel' => 'FINE'
),
);