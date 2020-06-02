<?php

function assign(&$hos,$applicans) {
    $hos['registrar'] = array_slice($applicans, 0,$hos['capacity']);
    return array_slice($applicans, $hos['capacity']);
}
function insertionsort($arr,$index,$decend = false) {
    //this $x to reverse sorting order
    //$index is the value to be compared
    if ($decend){
        $x = -1;
    }else{
        $x=1;
    }
    for ($i = 0; $i < count($arr); $i++) {
      $val = $arr[$i];
      $j=$i-1;
      while ($j >= 0 && ($arr[$j][$index])*$x > ($val[$index])*$x) {
         $arr[$j+1]=$arr[$j] ;
         $j--;
      }
      $arr[$j+1]=$val;
    }
    return $arr;
}
function take($index,&$arr) {
    $temp = $arr[$index];
    unset($arr[$index]);
    //rearrange index:
    $arr = array_values($arr);
    return  $temp;
}
Function takeApplicans ($hos,&$regarray){
    
    if (empty($regarray)){
        return false;
    }else{
    $i = 0;
    while ($i < count($regarray)) {
        if ($regarray[$i]['apps'][$regarray[$i]['currentapplicans']]['id']===$hos['id']) {
            $regarray[$i]['currentapplicans']++;
            $applicans[] = take($i, $regarray) ;
            
        }else{
            $i++;
        }
    }
    }   
    if (empty($applicans)){
        return false;
    }else {
        return $applicans;
    }
}
function checkPrevById($reg,$hos) {
    $x=0;
    foreach ($reg['prev'] as $value) {
       if ($value['id']===$hos['id']) {
           $x++;
       }
    }
    return $x;
}
function checkPrevByTier($reg,INT $tier) {
    $x=0;
    foreach ($reg['prev'] as $value) {
        if ($value['tier']== $tier) {
            $x++;
        }
    }
    return $x;
}
function shift(&$arr,$index,$newpos) {
    $value = $arr[$index];
    if ($index < $newpos) {
      
        for ($i = $index; $i < $newpos; $i++) {
            $arr[$i]=$arr[$i+1];
        }
       
    }elseif ($index > $newpos) {
       
        for ($i = $index; $i > $newpos; $i--) {
            $arr[$i]=$arr[$i-1];
        }
      
    }
    $arr[$newpos]= $value;
    
}
function clalculate($regarray,$hosarray) {
    $remains[0]=$regarray;$remains[1]=[];$remains[2]=[];$remains[3]=[];
    $kill =0;
    $iterationIndex = 0;
    do {
        /*the $bool is an array,added so
        i can remove any left over registrars
        from the itration, this happen when a hospital
        ['available'] value is changed after the registrar
        has entered his/her application
        so th Alghorithm won't pick him/her,
        very long comment XD*/
        $bool = $remains[$iterationIndex];
        $remains[$iterationIndex] =[];  
        foreach ($hosarray as &$hospital) {
            switch ($hospital['tier']) {
                case 1:
                    /*if there is no application break the cycle*/
                    if (!$applicans = takeApplicans($hospital,$bool ) ) break;
                        
                      $applicans = array_merge($hospital['registrar'],$applicans);
                      if (!count($applicans)<=$hospital['capacity']){
                           /*Giving Advantage to Registrars According to their previous shifts*/
                           $applicans = insertionsort($applicans, 'tier',true);
                          /*insertion sort: senior first*/
                          $applicans = insertionsort($applicans, 'shift',true);
                          //////////                      
                          /*if the registrar has previous shift in the same hospital 
                           * moov to end of the list
                           */
                          $m =count($applicans);
                          for ($i = 0; $i < $m; $i++) {
                              if (checkPrevById($applicans[$i], $hospital)) {
                                  shift($applicans, $i, count($applicans)-1);
                                  $m--;
                              }
                          }
                        //assign registrar to their hospitals
                        $arr = assign($hospital, $applicans);
                        foreach ($arr as $registrar) {
                            $remains[$registrar['currentapplicans']][]=$registrar;
                        }
                          
                      }else {
                          $hospital['registrar']=$applicans;
                      }
                break;
                case 2:
                    if (!$applicans = takeApplicans($hospital,$bool ) ) break;
                    $applicans = array_merge($hospital['registrar'],$applicans);
                    if (!count($applicans)<=$hospital['capacity']){
                        //Arrange according to shift number jonior first
                        $applicans = insertionsort($applicans, 'shift',false);
                        //////////////////
                        //put registrars who has done shift outside Khartoum first
                        $m =count($applicans);
                          for ($i = 0; $i < $m; $i++) {
                              if (checkPrevByTier($applicans[$i], 4)) {
                                  shift($applicans, $i, 0);
                                  
                              }
                          }
                          //////////////
                          //if a registrar had two previous shift in the same hospital
                          // moov to the end
                          $m =count($applicans);
                          for ($i = 0; $i < $m; $i++) {
                              if (checkPrevById($applicans[$i], $hospital)>1) {
                                  shift($applicans, $i, count($applicans)-1);
                                  $m--;
                              }
                          }
                           //assign registrar to their hospitals
                        $arr = assign($hospital, $applicans);
                        foreach ($arr as $registrar) {
                            $remains[$registrar['currentapplicans']][]=$registrar;
                        }
                    }else {
                        $hospital['registrar']=$applicans;
                    }
                    break;
                    case 3:
                        if (!$applicans = takeApplicans($hospital,$bool ) ) break;
                         $applicans = array_merge($hospital['registrar'],$applicans);
                         /*senior first*/
                         $applicans = insertionsort($applicans, 'shift',true);
                         //////////////
                         // if a registrar had `the` previous shift in the same hospital remoov entirly :
                            $m =count($applicans);
                            for ($i = 0; $i < $m; $i++) {
                              if ($applicans[$i]['prev'][count($applicans[$i]['prev'])-1]['id']== $hospital['id']) {
                                  $reg = take($i,$applicans);
                                  $remains[$reg['currentapplicans']][]=$reg;
                              }
                          }
                          /*if the registrar has `a` previous shift in the same hospital 
                           * moov to end of the list
                           */
                          $m =count($applicans);
                          for ($i = 0; $i < $m; $i++) {
                              if (checkPrevById($applicans[$i], $hospital)) {
                                  shift($applicans, $i, count($applicans)-1);
                                  $m--;
                              }
                          }
                      //assign registrar to their hospitals
                          if (!count($applicans)<=$hospital['capacity']){
                          $arr = assign($hospital, $applicans);
                          foreach ($arr as $registrar) {
                              $remains[$registrar['currentapplicans']][]=$registrar;
                          }
                          
                         }else {
                          $hospital['registrar']=$applicans;
                         }
                        break;
                        case 4:
                         if (!$applicans = takeApplicans($hospital,$bool ) ) break;
                         $applicans = array_merge($hospital['registrar'],$applicans);
                         /*senior first*/
                         $applicans = insertionsort($applicans, 'shift',true);
                         //////////////
                         //if A registrar is residant of the same city put first
                         $m =count($applicans);
                         for ($i = 0; $i < $m; $i++) {
                             if ($applicans[$i]['city'] == $hospital['city']) {
                                 shift($applicans, $i, count($applicans)-1);
                                 
                             }
                         }
                         //if a registrar has four previous shift in the same hospital
                         // moov to the end
                         $m =count($applicans);
                          for ($i = 0; $i < $m; $i++) {
                              if (checkPrevById($applicans[$i], $hospital)>3) {
                                  shift($applicans, $i, $m-1);
                                  $m--;
                              }
                          }
                           //assign registrar to their hospitals
                           if (!count($applicans)<=$hospital['capacity']){
                            $arr = assign($hospital, $applicans);
                            foreach ($arr as $registrar) {
                                $remains[$registrar['currentapplicans']][]=$registrar;
                            }
                            
                           }else {
                            $hospital['registrar']=$applicans;
                           }
                        break;
               
            }
        }
        //empty each registrar in bool into 
        //corresponding remain array:
        foreach ($bool as $registrar) {
            $registrar['currentapplicans']++;
            $remains[$registrar['currentapplicans']][]=$registrar;
        }
        $iterationIndex ++;
        if ($iterationIndex>2)$iterationIndex=0;
        //this a safty kill switch
        $kill++;
    }while ((!empty($remains[0])||!empty($remains[1])||!empty($remains[2]))&& $kill <100);
   //assign a ['distro'] `hospital ID`,propertiy to each registrar
   foreach($hosarray as &$hospital){
       foreach($hospital['registrar'] as &$registrar){
           $newhos = $hospital;
           unset($newhos['registrar']);
        $registrar['distro']=$newhos;
       }
   }
   $zeroHospital = ['id'=>0,'name'=>'0','capacity'=>0,'state'=>0,'city'=>0,'tier'=>0];
foreach ($remains[3] as &$registrar) {
    $registrar['distro']=$zeroHospital;
}
   return [$hosarray,$remains[3]];
}

