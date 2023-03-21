
<?php

/*
function delStr($nU, $unit , $sbt , $str)
{
    if(! checkExists($unit, $sbt , $str))
    {
      echo "doesnt even exist" ;
      return $str; 
    }
    
    $did = 0 ; 
    $f = countSbts($unit,$str) +1 ;
    // if f is 0 , then remove @ and put all subtopics except the deleted one

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

*/
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
function substrcheck($str, $unit)
{
  if($str[0] == '@')
  return 1; 

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
        {return 1 ; }
        else
        {
          while($i<strlen($str) && $str[$i]!='*')
          {$i++;}$i--;
        }
      }
    }
    return 0 ;
}

function updateStr($nT, $nU, $unit , $sbt , $str)
{
    if(checkExists($unit, $sbt , $str))
    {
    //  echo "no change " ;
      return $str; 
    }
    
    $did = 0 ; 
    $f = ( countSbts($unit,$str) +1 == $nT ) ; 
    

    // complete @ ify-- when all subtopics of all units .
    $ff = 1; // assuming it is the @ify condition
    if((countUnits($str)  +1 == $nU)  && (!substrcheck($str, $unit)) )
    {
      for($i =0 ; $i < strlen($str) ; $i++)
      {
        if($str[$i]=='*')
        {
          $i=$i+1 ;
          $tmpunit="" ;
          while($str[$i]!='@' && $str[$i]!='#')
          {
            $tmpunit=$tmpunit.$str[$i]; 
            $i++;
          }
          
            if(($tmpunit != $unit) && (countSbts($tmpunit,$str) == -1) )             
            ;
            else
            {
              if($tmpunit == $unit && $f = 1)
              {
                ;
              }
              else 
              {
                
                $ff = 0 ;
                goto bf1; 
              }
            }

            while($i<strlen($str) && $str[$i]!='*')
            {$i++;}$i--;
          
        }
      }
      bf1:;
      if($ff==1)
      return '@';
      
    }
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

echo updateStr(1,2,'U2','T1','*U1#T2');

?>