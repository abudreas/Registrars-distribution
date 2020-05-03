
<form action="" method="GET">
    <label for = "tele"><?=$message??""?></label>
    <input type="tel" id="tele" name="tele" value="<?=$myregistrar['tele']??""?>"
    pattern="[0]{1}[0-9]{9}"
     required>
     <button type="submit">عرض</button>
</form>
<?=$output??""?>