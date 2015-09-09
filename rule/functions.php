<?php
function out_footer() {
  echo <<< EOF
</body>
</html>

EOF;
}

function abort($message) {
  echo <<< EOF
<center>
<font size="+1" color="#FF0000"><b>$message</b></font>
</center>

EOF;
  out_footer;
  exit;
}

function quit($message) {
  echo <<< EOF
<center>
<font size="+1" color="#000000"><b>$message</b></font>
</center>

EOF;
  out_footer;
  exit;
}

function crlf_conv($string) {
  $string = preg_replace("/\r\n/", "<br>", $string);
  $string = preg_replace("/\r/",   "<br>", $string);
  $string = preg_replace("/\n/",   "<br>", $string);
  return $string;
}

function date_string($year, $month, $day)
{
  if (checkdate($month, $day, $year)) {
    $string = sprintf("%04d-%02d-%02d", $year, $month, $day);
  } else {
    $string = "";
  }
  return $string;
}

/* 日付文字列を整形して返す。*/
function check_date_string($string)
{
  /* 半角文字列に変換する。*/
  $string = trim(mb_convert_kana($string, "kasv", "EUC-JP"));
  if (preg_match("/^([0-9]{4})([0-9]{2})([0-9]{2})$/", $string, $n)) {
    $string = "$n[1]-$n[2]-$n[3]";
  } else if (preg_match("/^[0-9]+[-\/][0-9]+$/", $string)) {
    $string = date("Y")."-".$string; /* 年を追加 */
  }
  return preg_match("/^([0-9]{4})[-\/]([0-9]+)[-\/]([0-9]+)$/", $string, $n) ? date_string($n[1], $n[2], $n[3]) : "";
}

function is_date($string)
{
  preg_match("/^([0-9]{4})[-\/]([0-9]+)[-\/]([0-9]+)/", $string, $n);
  return checkdate($n[2], $n[3], $n[1]);
}

function time_string($hour, $minute, $secound)
{
  if ($hour    == "" || $hour    > 23) {
    return "";
  }
  if ($minute  == "" || $minute  > 59) {
    return "";
  }
  if ($secound > 59) { /* 秒は省略可 */
    return "";
  }
  $string = sprintf("%02d:%02d", $hour, $minute);
  if ($secound != "") {
    $string = $string.sprintf("%02d", $secound);
  }
  return $string;
}

/* 時刻文字列を整形して返す。 */
function check_time_string($string)
{
  $string = trim(mb_convert_kana($string, "kasv", "EUC-JP"));
  if (preg_match("/^([0-9]{2})([0-9]{2})([0-9]{2})$/", $string, $n)) {
    /* hhmmss */
    $hh = $n[1];
    $mm = $n[2];
    $ss = $n[3];
  } else if (preg_match("/^([0-9]{2})([0-9]{2})$/", $string, $n)) {
    /* hhmm */
    $hh = $n[1];
    $mm = $n[2];
  } else if (preg_match("/^([0-9]+):([0-9]+)(:[0-9]+)?$/", $string, $n)) {
    $hh = $n[1];
    $mm = $n[2];
    if ($n[3] != "") {
      $ss = substr($n[3], 1);
    }
  }
  return time_string($hh, $mm, $ss);
}

/* 時刻文字列かどうかを返す。*/
function is_time($string)
{
  if (preg_match("/^([0-9]+):([0-9]+)(:[0-9]+)?$/", $string, $n)) {
    $hh = $n[1];
    $mm = $n[2];
    if ($n[3] != "") {
      $ss = substr($n[3], 1);
    }
  }
  return (time_string($hh, $mm, $ss) != "") ? 1 : 0;
}

/* パスポートNo.を整形して返す。 */
function check_passport_no_string($string)
{
  $string = strtoupper(trim(mb_convert_kana($string, "kasv", "EUC-JP")));
  return preg_match("/^[A-Z]{2}[0-9]{7}$/", $string) ? $string : "";
}

function is_passport_no($string)
{
  return (check_passport_no_string($string) != "") ? 1 : 0;
}

/* JMB No. を整形して返す。 */
function check_jmb_no_string($string)
{
  $string = trim(mb_convert_kana($string, "kasv", "EUC-JP"));
  if (preg_match("/^[0-9]{9}$/", $string)) {
    $string = substr($string, 0, 2)."-".substr($string, 2, 3)."-".substr($string, 5, 4);
  } else if (!preg_match("/^[0-9]{2}-[0-9]{3}-[0-9]{4}$/", $string)) {
    $string = "";
  }
  return $string;
}

function is_jmb_no($no)
{
  return preg_match("/^[0-9]{2}-[0-9]{3}-[0-9]{4}$/", $string);
}

function timen($string)
{
  preg_match("/^([0-9]{4})[-\/]([0-9]+)[-\/]([0-9]+)$/", $string, $n);
  return mktime(0, 0, 0, $n[2], $n[3], $n[1]);
}

function year($string)
{
  preg_match("/^([0-9]{4})[-\/]([0-9]+)[-\/]([0-9]+)$/", $string, $n);
  return $n[1];
}

function month($string)
{
  preg_match("/^([0-9]{4})[-\/]([0-9]+)[-\/]([0-9]+)$/", $string, $n);
  return $n[2];
}

function day($string)
{
  preg_match("/^([0-9]{4})[-\/]([0-9]+)[-\/]([0-9]+)$/", $string, $n);
  return $n[3];
}

/* 空文字なら"NULL"を返す */
function SQLstr($string) {
  return ($string == "") ? "NULL" : "'$string'";
}

/* 数字列でなければ"NULL"を返す */
function SQLnum($string) {
  return (!is_numeric($string)) ? "NULL" : $string;
}

/* 日付でなければ"NULL"を返す */
function SQLdate($string)
{
  return (!is_date($string)) ? "NULL" : "'$string'";
}

/* 時刻でなければ"NULL"を返す */
function SQLtime($string)
{
  return (!is_time($string)) ? "NULL" : "'$string'";
}

/* 空文字列ならば - を渡す。*/
function padding($string) {
  return ($string != "") ? $string : "-";
}

/* 半角変換 */
function tohan($string) {
  return trim(mb_convert_kana($string, "kasv", "EUC-JP"));
}

function add_condition($cond, $operator, $addition) {
  if ($cond != "" && $addition != "") {
    return "($cond) $operator ($addition)";
  } else {
    return ($cond != "") ? $cond : $addition;
  }
}

function str_connect($string, $delimiter, $addition) {
  if ($string != "" && $addition != "") {
    return $string.$delimiter.$addition;
  } else {
    return ($string != "") ? $string : $addition;
  }
}

function op_isset($key) {
  if (!($status = isset($_GET[$key]))) {
    $status = isset($_POST[$key]);
  }
  return $status;
}

function op_numeric($key) {
  if (($val = $_GET[$key]) == "") {
    $val = $_POST[$key];
  }
  $val = mb_convert_encoding($val, "EUC-JP", "auto");
  $val = trim(mb_convert_kana($val, "kasv", "EUC-JP"));
  return is_numeric($val) ? $val : "";
}

function op_string($key, $hankaku, $trim) {
  if (($val = $_GET[$key]) == "") {
    $val = $_POST[$key];
  }
  $val = mb_convert_encoding($val, "EUC-JP", "auto");
  if ($hankaku) {
    $val = mb_convert_kana($val, "kasv", "EUC-JP");
  }
  if ($trim) {
    $val = trim($val);
  }
  return $val;
}

function op_date($key) {
  if (($val = $_GET[$key]) == "") {
    $val = $_POST[$key];
  }
  $val = mb_convert_encoding($val, "EUC-JP", "auto");
  $val = trim(mb_convert_kana($val, "kasv", "EUC-JP"));
  return is_date($val) ? $val : "";
}

function op_time($key) {
  if (($val = $_GET[$key]) == "") {
    $val = $_POST[$key];
  }
  $val = mb_convert_encoding($val, "EUC-JP", "auto");
  $val = trim(mb_convert_kana($val, "kasv", "EUC-JP"));
  return is_time($val) ? $val : "";
}

/* t_registuserから社員番号を読み込む*/
function codesearch($dt)
{
  $SQL = "";
  
//  $db = pg_connect("host=tklfpdmfgwsv dbname=tklfpdmfg user=user_rd password=PeekMe!");
  $db = pg_connect(G_CONNECT_READ);

  $SQL = "SELECT usercode FROM t_registuser WHERE userid = '" . $dt . "'";
  $res = pg_query($db, $SQL);
  
  $data = pg_fetch_array($res);
  $usercode = $data[usercode];

  return $usercode;
}

/* IS Usersから社員氏名を読み込む*/
function namesearch($dt)
{
  if($dt == '000000')
  {
    $username = namesearch2($dt);
  }
  else
  {
//    $SQL = "";
//  
//    $mscn = mssql_connect('TKLGDB1','ISGuest','guestusers');
//
//    $SQL = "SELECT LastNameJ,FirstNameJ FROM Users";
//    $SQL .= " WHERE NTAccount = 'ASIA\\" . $dt . "'";
//    $rs = mssql_query($SQL);
//
//    $data = mssql_fetch_array($rs);
//    $username = mb_convert_encoding($data[LastNameJ], "EUC-JP", "SJIS") . " " . mb_convert_encoding($data[FirstNameJ], "EUC-JP", "SJIS");
      $db = pg_connect(G_CONNECT_READ);

      $SQL = "SELECT sei, na FROM t_jinin_list WHERE shain_bangou = '" . $dt . "'";
      $res = pg_query($db, $SQL);
      
      $data = pg_fetch_array($res);
      $username = $data[sei] . " " . $data[na];
      if(trim($username) == "")
      {
        $username = "";
      }
      pg_close($db);
  }
  
  return $username;
}

/* 大津サーバーから社員氏名を読み込む*/
function namesearch2($dt)
{
  $SQL = "";
  
//  $db = pg_connect("host=tklfpdmfgwsv dbname=tklfpdmfg user=user_rd password=PeekMe!");
  $db = pg_connect(G_CONNECT_READ);

  $SQL = "SELECT sei, na FROM t_jinin_list WHERE shain_bangou = '" . $dt . "'";
  $res = pg_query($db, $SQL);
  
  $data = pg_fetch_array($res);
  $username = $data[sei] . " " . $data[na];

  if(trim($username) == "")
  {
    $username = "";
  }
  
  return $username;
}

/* 大津サーバー→IS Usersの順に社員氏名を読み込む*/
function namesearch4($dt)
{
  $username = namesearch2($dt);

  if($username == "")
  {
    $username = namesearch($dt);
  }

  return $username;
}

/* ファイル名の後ろにアンダーバーで2つ数字をくっつける */
function fncustom($fnstr, $addstr1, $addstr2)
{
  $res = "";

  if((trim($fnstr) == "") or (trim($fnstr) == null))
  {
    $res = "error.txt";
  }
  else
  {
    //渡された文字列の.の位置を数える
    $cnt = mb_strpos($fnstr,'.');
    $len = mb_strwidth($fnstr);
    
    if($cnt <= 0)
    {
      //拡張子が無いならそのままくっつける
      $res = $fnstr . "_" . $addstr1 . "_" . $addstr2;
    }
    else
    {
      //拡張子の区切りがあったなら間に
      $res = mb_substr($fnstr,0,$cnt) . "_" . $addstr1 . "_" . $addstr2 . mb_substr($fnstr,$cnt);
    }
  }
  return $res;
}

/* 指定桁数分前に0を並べる */
function zeroset($str, $fig)
{
  $res = "";
  
  $len = mb_strwidth($str);
  
  for($i = 0; $i < $fig-$len; $i++)
  {
    $res = "0" . $res;
  }
  $res = $res . $str;
  return $res;
}

/* 単純に日数差を返す */
function datediff($sdate, $edate)
{
  $res = "";
  
  if(!$sdate or !$edate)
  {
    $res = 0;
  }
  else
  {
//    $sval = split('[/.-]',$sdate);
//    $eval = split('[/.-]',$edate);
    $sval = preg_split('/[\/\.\-]/',$sdate);
    $eval = preg_split('/[\/\.\-]/',$edate);
    
    $sy = $sval[0];
    $sm = $sval[1];
    $sd = $sval[2];
    $ey = $eval[0];
    $em = $eval[1];
    $ed = $eval[2];
    
    $date1 = mktime(0,0,0,$sm,$sd,$sy);
    $date2 = mktime(0,0,0,$em,$ed,$ey);

    $res = ($date2 - $date1) / (60*60*24);
  }
  
  return $res;
}

/* 日数を足す（秒版） */
function datepluss($sdate, $dtsec, $sw)
{
  //$SW 0:2000-1-1で回答 1:秒の数値のまま回答
  $res = "";
  
  if(!$sdate or !$dtsec)
  {
    $res = 0;
  }
  else
  {
    $sval = split('[/.-]',$sdate);
    
    $sy = $sval[0];
    $sm = $sval[1];
    $sd = $sval[2];
    
    $date1 = mktime(0,0,0,$sm,$sd,$sy);
    $date2 = $date1 + $dtsec;

    if(($sw <> 1) or (!$sw))
    {
      $res = date("Y-m-d",$date2);
    }
    else
    {
      $res = $date2;
    }
  }
  
  return $res;
}

/* 日数を足す（日版） */
function dateplusd($sdate, $dtday, $sw)
{
  //$SW 0:2000-1-1で回答 1:秒の数値のまま回答
  $res = "";
  
  if(!$sdate or !$dtday)
  {
    $res = 0;
  }
  else
  {
    $sval = preg_split('/[\/\.\-]/',$sdate);
    
    $sy = $sval[0];
    $sm = $sval[1];
    $sd = $sval[2];
    
    $date1 = mktime(0,0,0,$sm,$sd,$sy);
    $date2 = $date1 + $dtday * 24 * 60 * 60;
    
    if(($sw <> 1) or (!$sw))
    {
      $res = date("Y-m-d",$date2);
    }
    else
    {
      $res = $date2;
    }
  }
  
  return $res;
}

function sendmail($tocode, $fromcode, $subjectid, $bunid)
{
  //科目で決まった宛先にだけ送信
  //送ってきた宛先社員番号は受講者が誰かわかるために利用
  $res = false;
  $SQL = "";
  $toadd = "";
  $kamokumei = "";

  $tocode = trim($tocode);
  $fromcode = trim($fromcode);

//  $db = pg_connect("host=tklfpdmfgwsv dbname=tklfpdmfg user=user_rd password=PeekMe!");
  $db = pg_connect(G_CONNECT_READ);
  //科目名、科目担当の読み込み
  $SQL = "";
  $SQL = "SELECT kamokumei,tantoucode FROM t_subject";
  $SQL .= " WHERE subjectid = " . $subjectid;
  $rs1 = pg_query($db, $SQL);
  $dt1 = pg_fetch_array($rs1);
  $kamokumei = $dt1[kamokumei];

  $tantou = split('[/.-]',$dt1[tantoucode]);
  $cnt1 = count($tantou);
//  echo $tantou . ":" . $cnt . "<br>";
  
  //科目担当者を登録数だけ足す
  if($cnt1 > 0)
  {
    for($i=0; $i<$cnt1; $i++)
    {
      $SQL = "";
      $SQL = "SELECT e_mail FROM t_jinin_list";
      $SQL .= " WHERE shain_bangou = '" . trim($tantou[$i]) . "'";
      $rs2 = pg_query($db, $SQL);
      $dt2 = pg_fetch_array($rs2);
      if(!$dt2[e_mail])
      {
//        $toadd .= ";" . $dt3[e_mail] . "Connection NG! ----";
        $toadd = "satoshi.hirakawa@tel.com";
      }
      else
      {
        if(!$toadd)
        {
          $toadd = $dt2[e_mail];
        }
        else
        {
          $toadd .= "," . $dt2[e_mail];
        }
      }
      pg_free_result($rs2);
    }
  }
  
  //送信者の読み込み　また後で判断が入る
  if(!$fromcode)
  {
    //未入力なら固定
    $fromadd = "TKL FPD MFG HUM YOSHIZUMI SAORI<saori.yoshizumi@tel.com>";
  }
  else
  {
    $SQL = "";
    $SQL = "SELECT e_mail FROM t_jinin_list";
    $SQL .= " WHERE shain_bangou = '" . $fromcode . "'";
    $rs3 = pg_query($db, $SQL);
    $dt3 = pg_fetch_array($rs3);
    if(!$dt3[e_mail])
    {
      $fromadd = "TKL FPD MFG HUM YOSHIZUMI SAORI<saori.yoshizumi@tel.com>";
    }
    else
    {
      $fromadd = $dt3[e_mail];
    }
  }

  $SQL = "";
  $SQL = "SELECT sei, na FROM t_jinin_list";
  $SQL .= " WHERE shain_bangou = '" . $tocode . "'";
  $rs4 = pg_query($db, $SQL);
  $dt4 = pg_fetch_array($rs4);
//  $toname = mb_convert_encoding($dt4[sei], "SJIS", "EUC-JP") . " " . mb_convert_encoding($dt4[na], "SJIS", "EUC-JP");
  $toname = $dt4[sei] . " " . $dt4[na];
  
  //送信内容の作成
  $title = $kamokumei . "の件";
  //文書内容の作成
  $SQL = "";
  $SQL = "SELECT title, bun FROM t_teikeibun";
  $SQL .= " WHERE bunid = '" . $bunid . "'";
  $rs5 = pg_query($db, $SQL);
  $dt5 = pg_fetch_array($rs5);
  if(!$dt5[bun])
  {
    $bun = "選択された文書が見つかりませんでした。管理者へ確認ください。";
  }
  else
  {
//    $title = mb_convert_encoding($dt5[title], "SJIS", "EUC-JP");
//    $bun = mb_convert_encoding("さん", "SJIS", "EUC-JP");
//    $bun .= "\n";
//    $bun .= mb_convert_encoding($kamokumei . $dt5[bun], "SJIS", "EUC-JP");

    $bun = "（" . $tocode . "）さん";
    $bun .= "\r\n\r\n";
    $bun .= $kamokumei . $dt5[bun];
  }
  
  $bunsyo = "\r\n\r\n受講者名　：　" . $toname . $bun;
  $headers = "";
  
  $headers .= "From: " . $fromadd . "\r\n";
  
  $headers .= "Content-Type: text/plain: charset=ISO-2022-JP\r\n";
  $headers .= "Content-Transfer-Encoding: 7bit\r\n";
  mb_language('Japanese');

  if(mb_send_mail($toadd, $title, $bunsyo, $headers))
  {
    $res = true;
  }
  else
  {
    $res = false;
  }
  return $res;
//  return "---TO = " . $toadd . "---FROM = " . $fromadd . "---BUNSYO = " . $bunsyo . "---HEAD = " . $headers;
} 

function sendmail2($tocode, $fromcode, $subjectid, $bunid)
{
  $res = false;
  $SQL = "";

  $tocode = trim($tocode);
  $fromcode = trim($fromcode);

  if(!$tocode)
  {
    $res = false;
  }
  else
  {
//    $db = pg_connect("host=tklfpdmfgwsv dbname=tklfpdmfg user=user_rd password=PeekMe!");
    $db = pg_connect(G_CONNECT_READ);
    //受講者の読み込み
    $SQL = "";
    $SQL = "SELECT sei, na, e_mail FROM t_jinin_list";
    $SQL .= " WHERE shain_bangou = '" . $tocode . "'";
    if (!($rs1 = pg_query($db, $SQL)))
    {
      pg_close($db);
    }
    else
    {
      $cnt1 = pg_num_rows($rs1);
      
      if($cnt1 > 0)
      {
        //科目名の読み込み
        $SQL = "";
        $SQL = "SELECT kamokumei,tantoucode FROM t_subject";
        $SQL .= " WHERE subjectid = " . $subjectid;
        $rs2 = pg_query($db, $SQL);
        $dt2 = pg_fetch_array($rs2);
        $kamokumei = $dt2[kamokumei];
        $tantou = split('[/.-]',$dt2[tantoucode]);
        $cnt2 = count($tantou);
//        echo $tantou . ":" . $cnt . "<br>";
        
        //送信先の作成
        $dt1 = pg_fetch_array($rs1);
        $toadd = $dt1[e_mail];
        $toname = $dt1[sei] . " " . $dt1[na];
        
        //送信者の読み込み
        if(!$fromcode)
        {
          //未入力なら無視
        }
        else
        {
          $SQL = "";
          $SQL = "SELECT e_mail FROM t_jinin_list";
          $SQL .= " WHERE shain_bangou = '" . $fromcode . "'";
          $rs3 = pg_query($db, $SQL);
          $dt3 = pg_fetch_array($rs3);
          if(!$dt3[e_mail])
          {
            //
          }
          else
          {
            $fromadd = $dt3[e_mail];
          }
        }
        
        //科目担当者を登録数だけ足す
        if($cnt2 > 1)
        {
          for($i=0; $i<$cnt2; $i++)
          {
//            echo $i . " = " . $tantou[$i] . "<br>";
//            $toadd .= ";" . $tantou[$i];
            $SQL = "";
            $SQL = "SELECT e_mail FROM t_jinin_list";
            $SQL .= " WHERE shain_bangou = '" . trim($tantou[$i]) . "'";
            $rs4 = pg_query($db, $SQL);
            $dt4 = pg_fetch_array($rs4);
            if(!$dt4[e_mail])
            {
//              $toadd .= ";" . $dt3[e_mail] . "Connection NG! ----";
              //
            }
            else
            {
              $ccadd .= "," . $dt4[e_mail];
            }
            pg_free_result($rs4);
          }
        }
        
        //送信内容の作成
//        $title = mb_convert_encoding($kamokumei,"SJIS","EUC-JP") . "の件";
        $title = $kamokumei . "の件";
//        $bunsyo = $kamokumei . mb_convert_encoding($bun,"EUC-JP","SJIS");
//        $bunsyo = $kamokumei . mb_convert_encoding($bun,"SJIS","EUC-JP");
        //文書内容の作成
        $SQL = "";
        $SQL = "SELECT bun FROM t_teikeibun";
        $SQL .= " WHERE bunid = '" . $bunid . "'";
        $rs5 = pg_query($db, $SQL);
        $dt5 = pg_fetch_array($rs5);
        if(!$dt5[bun])
        {
          $bun = "選択された文書が見つかりませんでした。管理者へ確認ください。";
        }
        else
        {
          $bun = $dt5[bun];
//          $bun = mb_convert_encoding($bun,"SJIS","EUC-JP");
        }
        
//        $bun = mb_convert_encoding($bun,"EUC-JP","SJIS");
        $bunsyo = "\r\n\r\n" . $kamokumei . "\r\n" . $toname . "さん" . $bun;
        $headers = "";
        if(!$fromadd)
        {
          //送り元の指定が無い時は吉住さんに
          $headers .= "From: TKL FPD MFG HUM YOSHIZUMI SAORI<saori.yoshizumi@tel.com>\r\n";
        }
        else
        {
          $headers .= "From: " . $fromadd . "\r\n";
        }
        
        $headers .= "Content-Type: text/plain: charset=ISO-2022-JP\r\n";
//        $headers .= "Content-Type: text/html: charset=SHIFT-JIS\r\n";
//        $headers .= "Content-Type: text/html: charset=SJIS\r\n";
//        $headers .= "Content-Type: text/html: charset=EUC-JP\r\n";
        $headers .= "Content-Transfer-Encoding: 7bit\r\n";
//        $headers .= "Cc: satoshi.hirakawa@tel.com\r\n";
        if(!$ccadd)
        {
          //CC無しなら何もしない
        }
        else
        {
          $headers .= "Cc: "  . ltrim($ccadd,",") . "\r\n";
        }
        
//        $headers .= "Bcc: saori.yoshizumi@tel.com\r\n";
/*
        $res = "To address = " . $toadd . "    From Address = " . $fromadd;
        $res .= "   header = " . $headers . "   bun = " . mb_convert_encoding($bunsyo,"SJIS","EUC-JP");
        $res .= "   subjectid = " . mb_convert_encoding($kamokumei,"SJIS","EUC-JP");
*/
        mb_language('Japanese');

        if(mb_send_mail($toadd, $title, $bunsyo, $headers))
//        if(mb_send_mail("satoshi.hirakawa@tel.com", $title, $bunsyo . $headers, $headers))
//        if(mail("satoshi.hirakawa@tel.com", $title, $bunsyo, $headers))
//        if(mb_send_mail("satoshi.hirakawa@tel.com", $title, $bunsyo, $headers))
        {
          $res = true;
        }
        else
        {
          $res = false;
        }

      }
//      $res = $SQL . "<br>=" . $title;
    }
    return $res;
  }
} 
