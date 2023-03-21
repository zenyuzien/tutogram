<?php

/********************************************************** */

function isThere($a , $b)
{
  for($i = 0 ; $i< count($b) ; $i++)
  {
    if ($b[$i] == $a)
      return 1;
  }
  return 0;
}

function getUnits($strings_of_u, $i, $uu )
{
  for($j = 0 ; $j < strlen($strings_of_u[$i]) ; $j++) //*U1#T1*U2#T1#T2
        {
           // if($j==0) echo"<br>iterating ".$strings_of_u[$i]."<br>";

            if($j==0 && ($strings_of_u[$i][$j]== '@'))
            {
             //   echo "yes";
                $uu[] = "@";
                break;
            } 

            else
            {
                if($j==0)
                $j++; 
                $tmp = "";
                while($j < strlen($strings_of_u[$i]) && ($strings_of_u[$i][$j] != '@' && $strings_of_u[$i][$j] != '#' ) )
                {
                  $tmp = $tmp . $strings_of_u[$i][$j++];
                 // echo "tmp:" . $tmp . "<br>";
                }
                //echo "final tmp:" . $tmp . "<br>";
                $uu[] = $tmp;
                while( ( $j < strlen($strings_of_u[$i]) ) && $strings_of_u[$i][$j] != '*')
                {
                  $j++;
                } 
            }
            
            
        }
  return $uu;
}

function getBucket($bucket, $strings_of_u, $i, $comm_units )
{
  $x = 0 ;
  //echo "from the known common units, attempting to retrieve subtopics from $strings_of_u[$i] <br>";
  for($j =0 ;   $j < strlen($strings_of_u[$i]) ; $j++)
  {
    // starts tat *
    gotoflag2:;
    // sequence starts with '*' or '\0', \0 will be handled by the looping condition. hence * is how it starts
    $tmp_uname = "" ;
    $j++;
    while($strings_of_u[$i][$j]!='@' && $strings_of_u[$i][$j]!='#' )
    {
      $tmp_uname = $tmp_uname. $strings_of_u[$i][$j] ;
      $j++;
    }
      //echo "is there ".$tmp_uname." in ".$strings_of_u[$i].": ".isThere($tmp_uname,$comm_units)."<br>";
      //echo "the escape sequence was ".$strings_of_u[$i][$j];
      if(isThere($tmp_uname,$comm_units))
      {
        $bucket[$x] = [];
        $y = 0 ;
        //echo "bucket[".($x)."] assigned a new list <br>";
        
        $bucket[$x][$y++] = $tmp_uname ; 
        //echo "bucket[".$x."][".($y-1)."]=".$tmp_uname."<br>";

        if($strings_of_u[$i][$j]=='#')
        { 
          gotoflag1:;
          $tmp_sbt = "" ;
          $j++;
          
          while(  $j < strlen($strings_of_u[$i]) &&($strings_of_u[$i][$j] != '#') && ($strings_of_u[$i][$j]!= '*')  )
          {
            $tmp_sbt = $tmp_sbt . $strings_of_u[$i][$j] ;
            $j++;
          }
          //echo "a recieved subtopic is ".$tmp_sbt."<br>";
          $bucket[$x][$y++]= $tmp_sbt ; 
          //echo "bucket[".$x."][".($y-1)."]=".$tmp_sbt."<br>";

          if($j >= strlen($strings_of_u[$i]))
          {
            //echo "escape sequence: length <br>";
            return $bucket;
          }
          else 
          {
            //echo "escape sequence: ".$strings_of_u[$i][$j];
            //echo "<br>";
            if($strings_of_u[$i][$j]=='#')
            {
              goto gotoflag1 ;
            }
            else if ($strings_of_u[$i][$j]=='*')
            {
              $x++;
              goto gotoflag2 ;
            }
            else 
            {
              echo "impossible" ;
            }
          }
        }

        else
        {
          //echo "all subtopics of the unit<br>";
          $bucket[$x][$y++]= "@" ; 
          //echo "bucket[".$x."][".($y-1)."]= @ <br>";
          $j++;
          
          if($j >= strlen($strings_of_u[$i]))
          {
              return $bucket;
          }
          else if($strings_of_u[$i][$j]=='*')
          {
            $x++;
              goto gotoflag2;
          }
          else {
            echo "impossibe ";
          }

            // was the escape sequence @, or #?
              // if @, all subtopics of the unit.
                // next character - either '*' or '\0'
                // if '*' goto beggining.
                // if '\0', done.
        }
      }
      else
      {
        while( ($j < strlen($strings_of_u[$i])) && $strings_of_u[$i][$j]!='*' )
        {
          $j++;
        }
        if($j>= strlen($strings_of_u[$i]))
        return $bucket;
        else 
        
        goto gotoflag2;

      }
      
          



  }
}
function displaybucket($bucket)
{
  for($p = 0 ; $p < count($bucket); $p++ )
  {
   for($q = 0 ; $q < count($bucket[$p]) ; $q++ )
   {
     if($q==0)echo "unit name : ".$bucket[$p][0]."<br> subtopics: ";
     else echo $bucket[$p][$q]."  ";
   }
   echo"<br>";
  }
}
function decodeBucket($Ustring,$sub,$com_st_u1 , $com_st_u2, $no)
{
  //echo"decode bucket called with no: ".$no."<br>";
  // no = 1 , only 1, no =2 , only 2 , no =3 ,both
  if($no==2)
  {
   // displaybucket($com_st_u1);
    if(count($com_st_u1)>0)
    {
      $Ustring = $Ustring."_".$sub ;
      for($p =0 ; $p < count($com_st_u1) ;$p++)
      {
        $Ustring =$Ustring."*".$com_st_u1[$p][0];
        for($q =1 ; $q < count($com_st_u1[$p]) ;$q++)
        {
          $Ustring = $Ustring . "#".$com_st_u1[$p][$q] ;
          //echo "  ".$com_st_u1[$p][$q] ;
        }

      //echo "<br>";
      }
    }
    
    else echo"empty bucket";
  }
  else if($no == 1 && count($com_st_u2)>0)
  {
    $Ustring = $Ustring."_".$sub ;
    //echo"______";
    //displaybucket($com_st_u2);
    //echo "______";
    for($p =0 ; $p < count($com_st_u2) ;$p++)
    {
     
      $Ustring =$Ustring."*".$com_st_u2[$p][0]; 
      for($q =1 ; $q < count($com_st_u2[$p]) ;$q++)
      {
        $Ustring = $Ustring . "#".$com_st_u2[$p][$q] ;
        //echo "  ".$com_st_u2[$p][$q] ;
      }
      //echo "<br>";
    }
  }
  else 
  {
    //find common here 
    //echo "count of bucket1 ".count($com_st_u1)."<br>";
    //echo "count of bucket2 ".count($com_st_u2)."<br>";
    if(count($com_st_u1) && count($com_st_u2));
    else
    {
      return $Ustring ;
    }
    for($p = 0 ; $p < count($com_st_u1); $p++)
    {
      for($q = 0 ; $q < count($com_st_u2) ; $q++ )
      {
        //echo "comparing ".$com_st_u1[$p][0]." ".$com_st_u2[$q][0]."<br>";
        if($com_st_u1[$p][0]==$com_st_u2[$q][0])
        {
          if( $com_st_u1[$p][1] == "@" )
          {
            //echo "2nd content<br>";
            $Ustring = $Ustring."*".$com_st_u2[$q][0] ;

            for($b = 1 ; $b < count($com_st_u2[$q]); $b++)
            {
              $Ustring = $Ustring."#".$com_st_u2[$q][$b] ;
              //echo "common ".$com_st_u2[$q][0]." ".$com_st_u2[$q][$b]."<br>";
            }
          }
          else if($com_st_u2[$q][1] == "@" && $com_st_u1[$p][1] == "@" )
          {
            // a case mot verified
            $Ustring = $Ustring. "*".$com_st_u2[$q][0]."@";
            //echo "entire unit is commox<br>"; 
            ;
          }
          else if($com_st_u2[$q][1] == "@")
          {
            //echo "1s content<br>";
            $Ustring = $Ustring."*".$com_st_u1[$p][0] ;

            for($b = 1 ; $b < count($com_st_u1[$p]); $b++)
            {
              //echo "common ".$com_st_u1[$p][0]." ".$com_st_u1[$p][$b]."<br>";
              $Ustring = $Ustring."#".$com_st_u1[$p][$b] ;
            }
          }
          else 
          {
            //$com_st_u1[$p][0]
            $flag=0;
            for($a = 1 ; $a < count($com_st_u1[$p]) ; $a++)
            {
              for($b = 1 ; $b < count($com_st_u2[$q]); $b++)
              {
                if($com_st_u1[$p][$a]==$com_st_u2[$q][$b])
                {
                  if($flag==0)
                  {
                    $flag=1;
                    $Ustring=$Ustring."_".$sub;
                    $Ustring=$Ustring."*".$com_st_u1[$p][0];
                  }
                  $Ustring=$Ustring."*".$com_st_u1[$p][$a];
                  //echo "commmon ".$com_st_u1[$p][0]." ".$com_st_u1[$p][$a]."<br>";
                }
              }
            }
          } 
        }
      }
    }
  }
  return $Ustring;
}
function algo_utility($t1,$t2,$mysqli)
{

$Ustring = "" ;
$sql = "SELECT $t1.subject as sub1 ,$t1.string as str1 ,$t2.string as str2 from $t1,$t2  where $t1.subject = $t2.subject  ";

if ($result = mysqli_query($mysqli, $sql) )
{
  if(mysqli_num_rows($result)>0)
  {
    $strings_of_u1 = [] ;
    $strings_of_u2 = [] ;
    $comm_subs = [] ;
    //echo "the common subjects are : <br>";
      while($row = mysqli_fetch_assoc($result))
      {
          //echo $row["sub1"] . "  " ;
          $comm_subs[] = $row['sub1'];
          $strings_of_u1[] = $row["str1"];
          $strings_of_u2[] = $row["str2"];
      }

      //echo"the subjects, strings corresponding are :";
      for($i =0 ; $i < count($comm_subs) ; $i++)
      {;
        //echo "<br>".$comm_subs[$i]." user1: "."  ".$strings_of_u1[$i].".   user2:".$strings_of_u2[$i];
      }
      //echo "<br><br>";
      for($i =0 ; $i < count($comm_subs) ; $i++) // the count is same
      {
        
        // for the particular common subject, we r storing common units

        // for now, just the units of each user
        $u1u = [];
        $u2w = [];

        $u1u = getUnits($strings_of_u1, $i, $u1u);
        $u2w = getUnits($strings_of_u2, $i, $u2w);
        
        
            
            //echo "<br> for tyhe subject $comm_subs[$i] <br>";
            //echo "u1 list of units: <br>";
            //for ($k = 0; $k < count($u1u); $k++)
            //echo $u1u[$k] . "   ";
           // echo "<br>";

            /* echo "<br>";
            echo "u2 list of units: <br>";
            for ($k = 0; $k < count($u2w); $k++)
            echo $u2w[$k] . "   ";
            echo "<br>"; */
        
            // for each string in either user , we have a string each
            // we have the lists of units derieved from either string.
            // check for common units now
            
            //echo "<br> common units: for each string for given subject: ";
            $comm_units = [] ;
           
            if($u1u[0]=='@')
            {
              for($b = 0 ; $b < count($u2w) ; $b++)
              {
                $comm_units[] = $u2w[$b];
                //echo $u2w[$b]."  ";

              }
              
            }
            else if($u2w[0] =='@')
            {
              for( $a = 0 ; $a < count($u1u); $a++)
              {
                  $comm_units[] = $u1u[$a];
                 // echo $u1u[$a]."  ";
              }
            }
            else
            {
              for( $a = 0 ; $a < count($u1u); $a++)
              {
                for($b = 0 ; $b < count($u2w) ; $b++)
                {
                  if($u1u[$a] == $u2w[$b])
                  {
                    //echo $u1u[$a] . "   ";
                    $comm_units[] = $u1u[$a];
                  }
                }
              }
            }

            //echo "no.ogg". count($comm_units)."<br>";
            //if(count($comm_units)>0)
            //for($a = 0 ; $a < count($comm_units); $a++)
            //echo $comm_units[$a]."  ";
            //else 
            //echo "none";
            echo "<br>";

            // to get list of common subtopics from each unit from comm units
            // the 3rd level bitch
            $com_st_u1 = [] ;
            $com_st_u2= [] ;

             if(count($comm_units) == 0);
            /* {
              echo "no common units<br>";
            }  */

            else if($comm_units[0]=='@')
            {
              $Ustring = $Ustring."_". $comm_subs[$i]."@" ; 
              //echo "entire subject is common <br>";
              // all subtopics of all units.. the subject whole is common.
            }
            else
            {
              if($strings_of_u1[$i]=='@')
              { 
                //echo "the 2nd user is common <br>";
                $com_st_u2=  getBucket($com_st_u2,$strings_of_u2, $i, $comm_units);
              //  displaybucket($com_st_u2);
                //echo"<br>"; 
                
                //echo"before decodebucket ".$Ustring."<br>";
                $Ustring =decodeBucket($Ustring,$comm_subs[$i],$com_st_u1 , $com_st_u2, 1);

                //echo"after decodebucket ".$Ustring."<br>";
              }
              else if($strings_of_u2[$i]=='@')
              {
                //echo "the 1st user is common <br>";
                $com_st_u1=  getBucket($com_st_u1,$strings_of_u1, $i, $comm_units);
                //displaybucket($com_st_u1);
                //echo"<br>"; 
                //echo"before decodebucket ".$Ustring."<br>";
                $Ustring =decodeBucket($Ustring,$comm_subs[$i],$com_st_u1 , $com_st_u2, 2);
                
                //echo"after decodebucket ".$Ustring."<br>";
                
              }
              else
              {
                //echo "common things of both users ought to b efounda <br>";
                $com_st_u2=  getBucket($com_st_u2,$strings_of_u2, $i, $comm_units);
                //displaybucket($com_st_u2);
                //echo"<br>"; 
                $com_st_u1 = getBucket($com_st_u1,$strings_of_u1, $i, $comm_units);
                //displaybucket($com_st_u1);
                //echo"<br>";

                $Ustring = decodeBucket($Ustring,$comm_subs[$i],$com_st_u1 , $com_st_u2, 3);

              }
            }
      }     
  }
  else 
  {
    //echo "no common subjects"
    ;
  }
}

return $Ustring ;
}


/************************************************************* */

  $servername = "localhost";
  $username = "zenyuzien";
  $dbname = "match";
  $password = "Zenyuzien@123";
  
  $mysqli = mysqli_connect($servername, $username, $password,$dbname);
  //$mysqli = new mysqli($servername, $username, $password,$dbname);
  // Check connection
  //if ($mysqli->connect_error) {
    if(mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
  }

$bg_color = "#0fa0f0"; // Red background color 
$font = "#ffffff" ;
echo "<body style='background-color: $bg_color;'>"; 
echo "<body style='font color: $font;'>"; 

function checkExists($unit, $sbt , $str)
{
  if($str[0]=='@')
  return 1;

    for($i = 0 ; $i < strlen($str); $i++)
    {
        if($str[$i]=='*')
        {
          $i=$i+1;//
         // echo "new tmpunit<br>";
            $tmpunit="";
            while($str[$i]!='@' && $str[$i]!='#')
            {
              //echo "str[$i] = $str[$i] <br>";
              $tmpunit=$tmpunit.$str[$i]; 
              $i++;
            }
           // echo "recieved tmpunit $tmpunit <br>";
            if($tmpunit==$unit)
            {
              if($str[$i]=='@')
              {
                return 1;
              }
              else if($str[$i]=='#')
              {
                gf1:;
                $tmpsbt="";
                while($i<strlen($str) && ($str[$i]!='#' && $str[$i]!='*' ))
                {
                //  echo "str[$i] = $str[$i] <br>";
                  $tmpsbt = $tmpsbt.$str[$i]; 
                  $i++;
                }
                if($tmpsbt == $sbt)
                {
                  return 1; 
                }
                else
                {
                  if(($i<strlen($str))&& $str[$i]=='#')
                  {
                    $i++;
                    goto gf1 ;
                  }
                  else
                  {
                    return 0;
                  }
                }
              }
            }
            else
            {
              while($i<strlen($str) && $str[$i]!='*')
              {
                //echo "str[$i] = $str[$i] <br>";
                $i++;
              }$i--;
            }
        }
    }
    return 0 ;
}
function countSbts($unit, $str)
{
  $count = 0 ;
  for($i = 0 ; $i < strlen($str); $i++)
  {
     // echo "str[$i] = $str[$i] <br>";

      if($str[$i]=='*')
      {
        $i=$i+1;//
       // echo "new tmpunit<br>";
          $tmpunit="";
          while($str[$i]!='@' && $str[$i]!='#')
          {
            //echo "str[$i] = $str[$i] <br>";
            $tmpunit=$tmpunit.$str[$i]; 
            $i++;
          }
         // echo "recieved tmpunit $tmpunit <br>";
          if($tmpunit==$unit)
          {
            if($str[$i]=='@')
            {
              return -1;
            }
            else if($str[$i]=='#')
            {
              while($i<strlen($str) && $str[$i]!='*')
              {
                if($str[$i]=='#')
                $count++;
                $i++;
              }
              return $count ;
            }
          }
          else
          {
            while($i<strlen($str) && $str[$i]!='*')
            {
              //echo "str[$i] = $str[$i] <br>";
              $i++;
            }$i--;
          }
      }
  }return -2; // no unit present
} 
function copystrtill($str, $i)
{
  $newstr= "";
  for($j = 0 ; $j < $i ; $j++)
  $newstr=$newstr.$str[$j];
  return $newstr;
}
function countUnits($str)
{
  if($str[0]=='@')
  return -1 ; 

  $n = 0 ; 
  for($i=0;$i<strlen($str);$i++)
  {
    if($str[$i]=='*')
    $n++;
  }
  return $n; 
}
function updateStr($nT, $nU, $unit , $sbt , $str)
{
    if(checkExists($unit, $sbt , $str))
    {
    //  echo "no change " ;
      return $str; 
    }
    
    $did = 0 ; 
    $f = countSbts($unit,$str) +1 == $nT ; 
    $g = countUnits($str) ;

    //echo "@ ify " ;
    $newstr ="" ;
    for($i =0 ; $i < strlen($str) ; $i++)
    {
      if($str[$i]=='*')
      {
        $i=$i+1;
        $tmpunit="";
        while($str[$i]!='@' && $str[$i]!='#')
        {
          $tmpunit=$tmpunit.$str[$i]; 
          $i++;
        }
        if($tmpunit==$unit)
        { 
          $did = 1 ;
          if($f)
          {
            $newstr = copystrtill($str, $i);
           // echo "  ".$newstr;
            $newstr = $newstr."@" ; 
          }
            
          while($i<strlen($str) && $str[$i]!='*')
          {$i++;}

          if(! $f)
          {
            $newstr = copystrtill($str, $i);
          //  echo "  ".$newstr;
            $newstr= $newstr."#".$sbt; 
          }
          while($i<strlen($str))
          {
            $newstr=$newstr.$str[$i];
            $i++;
          }       
          
         // echo "<br>$newstr";
          return $newstr; 
        }
        else
        {
          while($i<strlen($str) && $str[$i]!='*')
          {$i++;}$i--;
        }
      }
    }
    if($did == 0)
    {
      //echo "again" ; 
      // iterate till end
      for($i = 0 ; $i < (strlen($str)-1) ;$i++ )
      $i++;

      $newstr=copystrtill($str,$i);

      $newstr=$newstr."*".$unit."#".$sbt;
      //echo "    $newstr";
      return $newstr;
    }

}

// needs work


session_start();
$sbt = $_GET['sbt'];
$sub = $_GET['sub'];
$unit = $_GET['unit'];

echo"$sub $unit $sbt";  

/********************************************** U algo ******** */

$username = "U1" ;


// didnt handle the @ subjects case. 
function updateSW($user, $sub, $unit, $sbt, $sw)
{
  if($sw == 1)
  {
    echo "update strength ";
  }
  else 
  {
    echo "update weakness ";
  }
}

function Ualgo($mysqli, $user)
{
  ;
  // remove all entries from match which invlolves $user 
  $sql1 = "select username from users where username!='$user'" ;

  if ($result1 = mysqli_query($mysqli, $sql1) )
  {
    if(mysqli_num_rows($result1)>0)
    {
      while($row = mysqli_fetch_assoc($result1))
      {
        $tmpstr ="username";
        echo "<br> $row[$tmpstr]";

        $U1S = $user."_s" ;  
        $U1W = $user."_w" ;
        $U2S = $row[$tmpstr]."_s" ;
        $U2W = $row[$tmpstr]."_w" ;

        $Ustr_1s2w = algo_utility($U1S,$U2W,$mysqli);
        $Ustr_1w2s = algo_utility($U2S,$U1W,$mysqli);
        

        echo  "u1s u2w   ".$Ustr_1s2w."<br>u1wu2    ".$Ustr_1w2s."<br>";
        
        if( strlen($Ustr_1s2w) && strlen($Ustr_1w2s) )
        {
          echo "mutual match ! <br>";
          
          $sql2 = "insert into matches(U1, U2, U1SU2W, U1WU2S, U12, U21) values('$user','$row[$tmpstr]','$Ustr_1s2w','$Ustr_1w2s',0,0) "; 
          if (mysqli_query($mysqli, $sql2) )
          {
            echo "success <br>";
          }
        }
      }
    }
  }
  

}

//Ualgo($mysqli, 'U1');

?>