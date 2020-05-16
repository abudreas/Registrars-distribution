<html dir="rtl" lang="ar" >
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>إدارة</title>
 <link href="admin.css" rel="stylesheet">
</head>
<body>
<header>التقديم الإلكتروني</header>
<main>
    <?=$output?>
</main>
<footer>
    
    <button onclick="window.location.href='adminhome.php';">الرئيسية</button>
    <?php if (session_status() == PHP_SESSION_ACTIVE && ! empty($_SESSION)&& isset($_SESSION['admin'])
    && $_SESSION['admin'] > 0){?>
    <button onclick="window.location.href='login.php?action=logout';">تسجيل خروج</button>
    <?php }else{?>
        <button onclick="window.location.href='login.php';">تسجيل دخول</button>
        <?php } ?>

</footer>

</body>
</html>