<?php
    $car = array("BMW", "Toyota", "Honda");
    print("<table border='1'>");
    print("<tr><th>Make</th><th>Made in</th></tr>");
    for($i=0;$i<count($car);$i++)
        if($i==0)
            print("<tr><td>".$car[$i]."</td><td>Germany</td></tr>");
        else print("<tr><td>".$car[$i]."</td><td>Japan</td></tr>");
    print("</table>");

    $carmade = array("BMW"=>"Germany", "Toyota"=>"Japan", "Honda"=>"Japan");
    print("<table border='1'>");
    print("<tr><th>Make</th><th>Made in</th></tr>");
    foreach($carmade as $k=>$v)
            print("<tr><td>".$k."</td><td>".$v."</td></tr>");
    print("</table>");
?>