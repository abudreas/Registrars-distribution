<textarea name="" id="" cols="60" rows="10" readonly>
<?php 
    foreach ($result[0] as $hos) {
if (!empty($hos['registrar'])){
    $hos['registrar']= insertionsort($hos['registrar'],'shift',true);
echo "
////////////////////
";
echo $hos['name'].":

";
$i=1;
foreach ($hos['registrar'] as $reg) {
    
    $x=($reg['shift']+2)/2+0.5;
echo $i.") ".$reg['name']." R ".(int)$x."
";
$i++;
           }
       }
    } ?>
</textarea>
<button onclick="window.location.href='dist.php?action=edit';" >تعديل</button>