<textarea name="" id="" cols="60" rows="10" readonly>
    <?php 
    foreach ($result[0] as $hos) {
if (!empty($hos['registrar'])){
echo "////////////////////
";
 echo $hos['name']."
           ";
foreach ($hos['registrar'] as $reg) {
echo $reg['name']."
               ";
           }
       }
    } ?>
</textarea>
<button onclick="window.location.href='dist.php?action=edit';" >تعديل</button>