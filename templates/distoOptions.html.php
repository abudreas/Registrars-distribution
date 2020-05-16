<div>
    <p>مرحبا بك <?=$_SESSION['name']?>, الرجاء الإختيار</p>
    <form class="choose" method="GET" action="dist.php""><input name="action" value="edit" hidden><button>تعديل توزيع</button></form>
    <form class="choose" method="GET" action="dist.php"><input name="action" value="new" hidden><button>توزيع جديد</button></form>
    <form class="choose" method="GET" action="dist.php""><input name="action" value="publish" hidden><button>نشر التوزيع</button></form>
</div>