<form action="" method="post" id = "mainForm">
    <div><?=$message??""?></div>
 <ul>
  <li>
    <label for="name">الإسم:</label>
    <input value="<?=$myregistrar['name']??""?>" type="text" id="name" name="name" required pattern = "[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+|[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+|[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+|[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+[ ]+[ء-ي]+">
  </li>
  <label for="resid">الولاية:</label>
    <select id="resid" name="resid" required> 
    
    </select>
  </li>
  <li>
  <lable id = "citylable" for="city" hidden>أقرب مدينة</lable>
  <select id = "city" name = "resid" required hidden disabled></select>
  </li>
  <li>
    <label for="tele">رقم الهاتف :</label>
    <input type="tel" id="tele" name="tele" pattern="[0]{1}[0-9]{9}" required
   
    <?php if (isset($_GET['action']) && $_GET['action'] == 'edit'){ echo 'hidden';}?> value="<?=$myregistrar['tele']??""?>">
     <?php if (isset($_GET['action']) && $_GET['action'] == 'edit'){ ?>
     <input  disabled value="<?=$myregistrar['tele']??""?>">
     <?php } else{?>
      <small>الرقم يبدأ بصفر و من غير مفتاح</small>
     <?php }?>
  </li>
  <?php if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>
  <li>
    <label for="password">كلمة السر</label>
    <input type="password" id="password" name="password"
    hidden
     value="<?=$myregistrar['password']??""?>">
     <input type="password" disabled value=<?=$password?>>
     
  </li>
  <?php }?>
  <label for="currentShift" > رقم الشفت الحالي:</label>
 <li>
  <select name="shift" id="currentShift">
<option value=0>الكورس</option>
<option value=1> الشفت الأول</option>
<option value=2>الشفت الثاني </option>
<option value=3>الشفت الثالث</option>
<option value=4>الشفت الرابع</option>
<option value=5>الشفت الخامس </option>
<option value=6>الشفت السادس</option>
<option value=7>الشفت السايع</option>
</select>
<fieldset id = "prevShift">
<legend>الشفتات السابقة</legend>
 <li> <label for="firstShift">الشفت الأول (من غير الكورس)</label></li>
  <select name="shift1" id="firstShift" disabled required></select>
 <li> <label for="secondShift">الشفت الثاني</label></li>
  <select name="shift2" id="secondShift" disabled required></select>
 <li> <label for="shift3">الشفت الثالث</label></li>
  <select name="shift3" id="thirdShift" disabled required></select>
 <li> <label for="forthShift">الشفت الرابع</label></li>
  <select name="shift4" id="forthShift" disabled required></select>
 <li> <label for="fifthShift">الشفت الخامس</label></li>
  <select name="shift5" id="fifthShift" disabled required></select>
 <li><label for="sixShift">الشفت السادس</label></li>
  <select name="shift6" id="sixShift" disabled required></select>
  <li><label for="seventhtShift">الشفت السابع</label></li>
  <select name="shift7" id="seventhtShift" disabled required></select>

</fieldset>

<fieldset id = "application">
 <legend>الرغبات</legend>
 <small id="err" hidden>الرجاء إختيار ثلاث رغبات مختلفة</small>
 <li><label for="firstApplication">الرغبة الأولى</label></li>
 <select name="app1" id = "firstApplication" required></select>
 <li><label for ="seconApplication">الرغبة الثانية</label></li>
 <select name="app2" id ="seconApplication" required></select>
 <li><label for="thirdApplication">الرغبة الثالثة</label></li>
<select name="app3" id ="thirdApplication" required></select>
 </fieldset>
  <li class="button">
  <button type="submit">إرسال</button>
</li>
 </ul>
 
</form>
<div class = "popup" id = "popupform">
    <form action = "login.php" method = "post">
    <p>لقد تم إدخال هذا الرقم من قبل</p>
    <li>
    <input name = "tele"  hidden value="<?=$myregistrar['tele']??""?>">
    </li>
    <?=$revoutput??""?>
    <p>يمكنك التعديل بعد إدخال كلمة السر</p>
    <li>
    <label for="password">كلمة السر</label>
    <input type="password" id="password" name="password"
   
     required>
     <small>للحصول على كلمة السر عليك مراسلة المشرف</small>
  </li>
  <button type = "sumbit">تعديل</button>
  <button onclick = "closeit()">إلغاء</button> 
    </form>
</div>
<script> 
var isfound = <?=$isfound??0?>;
var prevshift = <?=$myregistrar['shift']??0?>;
var prevstate = <?=json_encode($myregistrar['resid'])??"[0,0]"?>;
var statsarry = <?=json_encode($stats,JSON_UNESCAPED_UNICODE)?>;
var myregprev = <?=json_encode($myregistrar['arrshift'])?>;
var myregapp = <?=json_encode($myregistrar['arrapp'])?>;
var availhops = <?=json_encode($availhosps,JSON_UNESCAPED_UNICODE)?>;
var notavailhops = <?=json_encode($notavailhosps,JSON_UNESCAPED_UNICODE)?>;
</script>
<script src="listG.js"></script>
