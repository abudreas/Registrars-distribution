<?=$message?>
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

