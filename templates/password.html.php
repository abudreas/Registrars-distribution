<form action="" method="post">
    <?=$message?>
<li>
    <label for="tele">رقم الهاتف :</label>
    <input type="tel" id="tele" name="tele" value="<?=$_POST['tele']??""?>"
    pattern="[0]{1}[0-9]{9}"
     required>
    
  </li>
  <li>
    <label for="password">كلمة السر</label>
    <input type="password" id="password" name="password"
   
     >
     <small>للحصول على كلمة السر عليك مراسلة المشرف</small>
  </li>
  <button type="submit">موافق</button>
</form>