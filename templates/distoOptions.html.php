<div>
    <p>مرحبا بك <?=$_SESSION['name']?>, الرجاء الإختيار</p>
    <form class="choose" method="GET" action="dist.php""><input name="action" value="edit" hidden><button>تعديل توزيع</button></form>
    <form class="choose" method="GET" action="dist.php"><input name="action" value="new" hidden><button>توزيع جديد</button></form>
    <form class="choose" method="GET" action="dist.php""><input name="action" value="publish" hidden><button>نشر التوزيع</button></form>
    <?php if (session_status() == PHP_SESSION_ACTIVE && ! empty($_SESSION)&& isset($_SESSION['admin'])
&& $_SESSION['admin'] > 2){ ?>
    <form class="choose" method="GET" action="dist.php""><input name="action" value="reset" hidden><button>Reset</button></form>

<?php } ?>
</div>