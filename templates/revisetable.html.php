


<table>
    <thead>
        <tr>
            <th colspan="2"> <?=htmlspecialchars($myregistrar['name'])?> </th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>رقم الهاتف</td>
            <td><?=htmlspecialchars($myregistrar['tele'])?></td>
            
        </tr>
        <tr>
        <td>الشفت الحالي</td>
            <td><?=htmlspecialchars($myregistrar['shift'])?></td>
            
        </tr>
        <tr>
        <td>السكن</td>
            <td><?=htmlspecialchars($myregistrar['resid'][0])?></td>
            
        </tr>
        
    </tbody>
</table>
<?php if (isset($myregistrar['shift1'])&&!$small) { ?>
<table>
    <thead>
        <tr>
            <th colspan="2"> الشففتات السابقة </th>
        </tr>
    </thead>
    <tbody> <?php 
       for ($x = 1;isset($myregistrar['shift'.$x]);$x++){ ?>
      <tr>
        <td><?=$this->shiftlist[$x]?></td>
            <td><?=htmlspecialchars($myregistrar['shift'.$x])?></td>
            
      <?php } ?>
       </tbody>
</table>
       <?php } ?>
       <table> 
    <thead>
        <tr>
            <th colspan="2"> الرغبات </th>
        </tr>
    </thead>
    <tbody>
       
        <tr>
        <td>الرغبة الأولى</td>
            <td><?=htmlspecialchars($myregistrar['app1'])?></td>
            
        </tr>
        <tr>
        <td>الرغبة الثانية</td>
            <td><?=htmlspecialchars($myregistrar['app2'])?></td>
            
        </tr>
        <tr>
        <td>الرغبة الثالثة</td>
            <td><?=htmlspecialchars($myregistrar['app3'])?></td>
            
        </tr>
    </tbody>
</table>
<?php if (!$small) {?>
<form action="login.php" method="POST" disabled >
<input type="text" name="tele" value="<?=$myregistrar['tele']??''?>"  hidden >
<button type="submit">تعديل</button>
<?php }?>
</form>
