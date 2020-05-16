<form id ="g" action="" method="post">
<input type="text" id="tosave" name="save" hidden>
<fieldset>
<legend>مستشفيات محفوظة</legend>
    <?php foreach ($var as $hospital) { ?>
     
    
       <div id="hos" <?php if (!$hospital['available']) echo 'class = "available"'?>>
           <input id="id" type="text" name="id[]" value="<?=$hospital['id']?>" hidden> 
       <label for="name">إسم المستشفى</label>
        <input type="text" id = "name" name ="name[]" value ="<?=$hospital['name']?>" required>
        
        <lable for ="cap">السعة</lable>
        <input type="number" id="cap" name="capacity[]" class="num" value="<?=$hospital['capacity']?>">
        <labale for="state">الولاية</labale>
        <select id="state" name="state[]"></select>
        <lable for="city" hidden>المدينة</lable>
        <select id="city" name="city[]" hidden></select>
        <label for="tier">الطبقة</label>
        <select name="tier[]" id="tier">
        <option value="1">الأولى</option>
        <option value="2">الثانية</option>
        <option value="3">الثالثة</option>
        <option value="4">الرابعة</option>
        </select>
        <label for="available">متاح للتوزيع</label>
        <input id="available" type="checkbox" class="check"  <?php if ($hospital['available']) echo "checked"?>>
        <input type="number" name ="avail[]" hidden value="<?=$hospital['available']?>"> 
        <button type="button" id="delet" class="warning">حذف</button>
        <input type="text" hidden name="delet[]" value =0 id ="deletbox">
    </div>
    <?php }?>
    </fieldset>
    <fieldset id="newhoscontainer">
    <legend>مستشفيات مضافة</legend>
    <div id="newhos">
           
       <label for="name">إسم المستشفى</label>
        <input type="text" id = "name" name ="name[]" required value="">
        
        <lable for ="cap">السعة</lable>
        <input type="number" id="cap" name="capacity[]" class="num" value="0">
        <labale for="state">الولاية</labale>
        <select id="state" name="state[]" value="0"></select>
        <lable for="city" hidden>المدينة</lable>
        <select id="city" name="city[]" hidden value="0"></select>
        <label for="tier">الطبقة</label>
        <select name="tier[]" id="tier">
        <option value="1">الأولى</option>
        <option value="2">الثانية</option>
        <option value="3" selected>الثالثة</option>
        <option value="4">الرابعة</option>
        </select>
        <label for="available">متاح للتوزيع</label>
        <input id="available" type="checkbox" class="check"  checked >
        <input type="number" name ="avail[]" value =1 hidden>
        <button type="button" id="deletnew" class="warning">حذف</button>
        
    </div>
    </fieldset>
    </form>
    <form id="popup" class="popup">
        <p>هل أنت متأكد ؟ .سيتم حذف المستشفى من جميع السجلات</p>
        <p>يجب عليك إختيار مستشفى لتحويل النواب في السجلات إليه</p>
        <select name="hospitals" id="hosSelect" required></select>
        <button type="button" onclick="closepopup()">إلغاء</button>
        <button  id="popsumbit" >تأكيد</button>
    </form>  
    <button onclick="addit()">إضافة</button>
    <div>
    <button onclick = "saveit()" class="saveit">حفظ التغييرات</button>
    </div>
    <script>
        var statsarry = <?=json_encode($stats,JSON_UNESCAPED_UNICODE)?>;
        var prevstate = <?=json_encode($prevstate)?>;
        var prevcity = <?=json_encode($prevcity)?>;
        var prevtier = <?=json_encode($prevtier)?>;
        var hosarray = <?=json_encode($hosarray,JSON_UNESCAPED_UNICODE)?>;
    </script>
   <script src="script.js"></script>