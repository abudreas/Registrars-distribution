<div class="legend">
        <h2>دلالة الألوان</h2>
        <div class="flexcontainer">
        <div class="explain">
            <p>نائب شفت أول</p>
        <div draggable="false" class="dragon shift0">الإسم</div>
    </div>
    <div class="explain">
        <p>نائب شفت ثاني</p>
    <div draggable="false" class="dragon shift1">الإسم</div>
</div>
<div class="explain">
    <p>نائب شفت ثالث</p>
<div draggable="false" class="dragon shift2">الإسم</div>
</div>
<div class="explain">
    <p>نائب شفت رابع</p>
<div draggable="false" class="dragon shift3">الإسم</div>
</div>
<div class="explain">
    <p>نائب شفت خامس</p>
<div draggable="false" class="dragon shift4">الإسم</div>
</div>
<div class="explain">
    <p>نائب شفت سادس</p>
<div draggable="false" class="dragon shift5">الإسم</div>
</div>
<div class="explain">
    <p>نائب شفت سابع</p>
<div draggable="false" class="dragon shift6">الإسم</div>
</div>
<div class="explain">
    <p>نائب شفت ثامن</p>
<div draggable="false" class="dragon shift7">الإسم</div>
</div>
<div class="explain">
    <p>توجد ملاحظة عادية تخص النائب</p>
<div draggable="false" class="dragon warning">الإسم</div>
</div>
<div class="explain">
    <p>توجد ملاحظة مهمة تخص النائب</p>
<div draggable="false" class="dragon danger">الإسم</div>
</div>
<div class="explain">
    <p>تم تخطي السعة الإستيعابية للمستشفى</p>
    <div class="warning">المستشفى</div>
</div>
</div>   
    </div>
        <div class="flexcontainer">
        <div class="hoscontain" id="hoscontain">
            
       <div class="drop" id="hos">
        <label for="hos" id="hosname">makkah</label>
        <small></small>
       </div>
    </div>
    <div id="infowindow" class="info">
        <h1>name</h1>
        <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <small> الشفتات السابقة</small>
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <small>الرغبات</small>
        <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <small>ملاحظات</small>
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>

    </div>
</div>
<div class="flexcontainer">
       <div class="remains" id="remBox"> 
        </div>
        <div class="remainscount" id="remcnt">
            
        </div>
        <div  class="messagesDivcontainer">
            <h2 id="messagesTitle">ملاحظات</h2>
        <div class="messages" >
            
            <p id="msgbox" class="msgcontainer">

            </p>
        </div>
    </div>
</div>
        <form action="" method="GET" id="publish">
            <input name="action" value="publish" hidden>
            <button id="saveitbtn" type="button" onclick="saveit()">حفظ</button>
            <button type="submit">نشر</button>
           
        </form>
        <script>
            <?="var result = ".$result.";"?>
        </script>
        <script src="dist.js"></script>