<html>
<body>
<form action="Func.php" method="post">
        Enter a number: <input type="text" name="number"/><br>
        <input type="submit" value="calculate"/>
</form>
<?php
// factorial
function fact($i)
{
    $f=1;
    for($j=2;$j<=$i;$j++) $f*=$j;
    return $f;
}
// fibonacci
function fib($i)
{
    // 1 2 3 5 8 13 ...
    if($i<3) return $i;
    return fib($i-1) + fib($i-2);
}

// main
if($_POST["number"])
{
    echo "Fib, Fact:<br>";
    for($i=1;$i<=$_POST["number"];$i++)
        echo fib($i) . ", ". fact($i). "<br>";
}
?>
</body>
</html>