<?php 
    class Greetings { public function hello() { return "hello world"; }} 
?>

<html>
    <!-- to host: .\php -S localhost:8000 PHPprograms/serverPractice.php -->
    <script type="text/javascript">
        console.log("<?php $foo = new Greetings(); echo $foo->hello(); ?>");
        console.log("Server Started at: <?php date_default_timezone_set("America/New_York"); echo date("h:ia"); ?>");

        function TwelveHourTime(hour) { // defer am to pm time
            let realHour; // 12-hour time
            let AmPm = 'AM'; // am or pm
            if (hour >= 12) { // if afternoon
                if (hour !== 12) { realHour = Math.abs(hour - 12); }
                AmPm = 'PM';
            // if midnight
            } if (hour === 0 || hour === 24) { realHour = 12;
            // if morning
            } if (hour !== 0 && hour !== 24 && hour < 12) { realHour = hour; }
            let mins = new Date().getMinutes().toString()
            // if there is a 0 in minutes
            if (mins.length < 2) { mins = "0" + new Date().getMinutes(); }
            return realHour + ":" + mins + AmPm;
        }

        function getTime() { // set timeout and continually refresh time
            myTime = setTimeout("realtimeRefresh()",60000);
        }

        function realtimeRefresh() { // update the time on the page
            if (new Date().getMinutes() === 0) { 
                location.reload(); 
                console.log('reloaded site');
            }
            let timeVar = document.getElementById('realtime'); // current time header
            timeVar.innerHTML = "The time is: " + TwelveHourTime(new Date().getHours());
            getTime();
        }
    </script>

    <body onload="realtimeRefresh()" style="margin:20px;font-family:Verdana">
        <?php date_default_timezone_set("America/New_York"); ?>
        <h1> This is my PHP Server </h1>
        <h3> It is running on <?php echo $_SERVER["SERVER_NAME"]?> </h3>
        <h3 id='realtime'> The time is: <?php echo date("h:ia"); ?> </h3>
        <br/>
        <!-- POST -->
        <h4> Make a POST Request to Server </h4>
        <form id="make-post" autocomplete="off" method="POST">
            <label> Enter Some Text: </label>
            <input type="text" name="input_field" />
            <input type="submit" value="POST" />
        </form>
        <br/>
        <!-- PHP -->
        <div style="position:relative;right:-45%;top:-25%;font-size:125%;width:40%;">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $var = $_POST["input_field"];
                if (isset($var)) {
                    file_put_contents("logfile.log", print_r($var,true));
                    if (empty($var)) { // if there are no characters in post
                        echo "<p> An empty string was posted to the server. . . </p>";
                    } else { // otherwise, post the text
                        echo "<p><b>" . "\"" . $var . "\"</b>" . " was posted to the server!" . "</p>";
                    }
                }
            }
        ?>
        </div>
    </body>
</html>