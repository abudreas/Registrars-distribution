
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
            <li>jfkd</li>
            <li>jgk</li>
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
        <div class="messages" >
            <h2>ملاحظات</h2>
            <p id="msgbox" class="msgcontainer">

            </p>
        </div>
</div>
        <form action="" method="GET" id="publish">
            <input name="action" value="publish" hidden>
            <button type="button" onclick="saveit()">حفظ</button>
            <button type="submit">نشر</button>
           
        </form>
        <script>
            <?="var result = ".$result.";"?>
        </script>
        <script src="dist.js"></script>