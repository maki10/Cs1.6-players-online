<?php
function cs_scan($ip,$port){
  global $pingtime;
  $fp = @fsockopen('udp://'.$ip,$port,$errno,$errstr,1);
  if ($config['timeout'] = intval($config['timeout']))
  {
    @stream_set_timeout($fp, $config['timeout']);
  }
  else
  {
    @stream_set_timeout($fp, 0, 500000);
  }

  @stream_set_blocking($fp, TRUE);
  if (!$fp) {
    unset($data);
    $data['color'] = "st4";
    $data['address'] = $ip.":".$port;
    $data['gamemod'] = "-";
    $data['hostname'] = "-";
    $data['mapname'] = "-";
    $data['players'] = "0";
    $data['maxplayers'] = "0";
    $data['password'] = "-";
    $data['datatype'] = "-";
    $data['version'] = "-";
    $data['description'] = "-";
    $data['server_type'] = "-";
    $data['server_os'] = "-";
    $data['server_secure'] = "-";
    $data['server_bots'] = "-";
    $stopro = 1;
    $osv1   = $data['players'];
    $osvw1  = $osv1/$stopro;
    $osve1  = $osvw1*100;
    $data['percent'] = round($osve1);
    $data['la'] = "images/la/0.gif";
    $data['color'] = "color2";
    $data['status'] = 0;
    return $data;
  }
  else { 
   $pingtime1 = microtime(); 
   $final = false;
   fwrite($fp,"\xFF\xFF\xFF\xFFTSource Engine Query\x00");
   $buffer = fread($fp,4096);
   if (!$buffer) {
    fclose($fp);
    unset($data);
    $data['color'] = "st4";
    $data['address'] = $ip.":".$port;
    $data['gamemod'] = "-";
    $data['hostname'] = "-";
    $data['mapname'] = "-";
    $data['players'] = "0";
    $data['maxplayers'] = "0";
    $data['password'] = "-";
    $data['datatype'] = "-";
    $data['version'] = "-";
    $data['description'] = "-";
    $data['server_type'] = "-";
    $data['server_os'] = "-";
    $data['server_secure'] = "-";
    $data['server_bots'] = "-";
    $stopro = 1;
    $osv1   = $data['players'];
    $osvw1  = $osv1/$stopro;
    $osve1  = $osvw1*100;
    $data['percent'] = round($osve1);
    $data['la'] = "images/la/0.gif";
    $data['color'] = "color2";
    $data['status'] = 0;
    return $data;
   }
   $second_packet = $buffer;
   if (strlen($second_packet) > 0) {
    $reverse_check = dechex(ord($buffer[8]));
    if ($reverse_check[0] == "1") {
     $tmp = $buffer;
     $buffer = $second_packet;
     $second_packet = $tmp;
    }
    $buffer = substr($buffer, 13);
    $second_packet = substr($second_packet, 9);
    $buffer = trim($buffer.$second_packet);
    $buffer = trim(substr($buffer, 4));
    if (!trim($buffer)) {
    unset($data);
    $data['color'] = "st4";
    $data['address'] = $ip.":".$port;
    $data['gamemod'] = "-";
    $data['hostname'] = "-";
    $data['mapname'] = "-";
    $data['players'] = "0";
    $data['maxplayers'] = "0";
    $data['password'] = "-";
    $data['datatype'] = "-";
    $data['version'] = "-";
    $data['description'] = "-";
    $data['server_type'] = "-";
    $data['server_os'] = "-";
    $data['server_secure'] = "-";
    $data['server_bots'] = "-";
    $stopro = 1;
    $osv1   = $data['players'];
    $osvw1  = $osv1/$stopro;
    $osve1  = $osvw1*100;
    $data['percent'] = round($osve1);
    $data['la'] = "images/la/0.gif";
    $data['color'] = "color2";
    $data['status'] = 0;
    return $data;
    }
   }
  }
  fclose($fp);
  unset($data);
  $tmp       = explode("\x00", $buffer);
  $place = strlen($tmp[0].$tmp[1].$tmp[2].$tmp[3].$tmp[4]) + 5;
  $data['color'] = "st4";
  $data['address'] = $ip.":".$port;
  $data['gamemod'] = $tmp[3];
  $data['hostname'] = $tmp[1];
  $data['mapname'] = $tmp[2];
  if ($data['mapname'] == "cstrike"){
  $data['hostname'] = $tmp[3];
  $data['mapname']  = $tmp[1];  
  }
  if ($data['mapname'] == "") {
  $data['hostname'] = $tmp[1];
  $data['mapname']  = $tmp[2];
  }
  $data['next']             = 1; 
  $data['players'] = ord($buffer[$place]);
  $data['maxplayers'] = ord($buffer[$place + 1]);
  $data['color'] = "";
  $stopro = $data['maxplayers']+1;  
  $osv1   = $data['players'];
  $osvw1  = $osv1/$stopro;
  $osve1  = $osvw1*100;
  $data['percent'] = round($osve1);
  $data['status']  = 1;
  $data['la'] = "images/la/0.gif";
  if(round($osve1)>0 && round($osve1)<21) {
  $data['la'] = "images/la/1.gif";  }
  if(round($osve1)>20 && round($osve1)<41) {
  $data['la'] = "images/la/2.gif";  }
  if(round($osve1)>40 && round($osve1)<61) {
  $data['la'] = "images/la/3.gif";  }
  if(round($osve1)>60 && round($osve1)<81) {
  $data['la'] = "images/la/4.gif";  }
  if(round($osve1)>80 && round($osve1)<101) {
  $data['la'] = "images/la/5.gif";  }
  $data['pingtime']              =       microtime()-$pingtime1;
  $data['password'] = ord($buffer[$place + 5]);
  if ($data['password'] = ord($buffer[$place + 5])){
                         $data['password'] = 'Clan War';
                         }
                         else{
                         $data['password'] = 'Public';
                         }
  $data['datatype'] = $buffer[0];                // m ??? ????? ????
  $data['version'] = ord($buffer[$place + 2]);   // ??????
  $data['description'] = $tmp[4];
  $data['server_type'] = $buffer[$place + 3];    // D ???????? ??? L ???????
  $data['server_os'] = $buffer[$place + 4];      // W ??? ?????? ??? L ??? ????????
  $data['server_secure'] = ord($tmp[14]);        // VAC
  if ($data['server_secure']  = ord($tmp[14])){
                          $data['server_secure'] = "????";
                          }
                          else{
                          $data['server_secure'] = "???";
                          }
  $data['server_bots'] = ord($tmp[15]);          // ???-?? ?????
  if (substr_count($data['hostname'],"banned") == 1) {
   $data['hostname'] = "IP Banned";
   $data['mapname'] = "-";
   $data['password'] = "-";
   $data['server_secure'] = "-";
  }
  if ($data == "Server offline") { 
   unset($data);
   $data['hostname'] = "Server Offline";
   $data['mapname'] = "-";
   $data['players'] = "0";
   $data['maxplayers'] = "0";
  }
  if($data['players'] > $data['maxplayers']){
   $temp=$data['players'];
   $data['players']=$data['maxplayers'];
   $data['maxplayers']=$temp;
  }
  return $data;
}
?>
