<?php
	session_start();

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>We made an idle game!</title>

    <style type="text/css">
    button {
        visibility: hidden;
    }

    #sellCodeButton {
        visibility: visible;
    }

    .extraPowerUpButton {
        visibility: visible;
    }
    </style>

</head>
<body>
	<div id="logout">
		<form method="post" action=logout.php>
			<input type="submit" name="logout" value="Logout">
		</form>
	</div>

	<div id="menu">
	<h2>Welcome <label id="user"><?php echo $_SESSION['user'];?></label><br></h2>
	<p>You've written <label id="lines">0</label> lines of code!</p>
    <p>You've grown <label id="hands">0</label> extra hands.</p>
    <p>You've had <label id="cups">0</label> cups of coffee.</p>
	<p>You've been coding for <label id="seconds">0</label> seconds.</p>
    <p>You've made $<label id="money">0</label>.</p>
    <button id="sellCodeButton" onclick="sellCode()" style>Sell Code for $<label id="codeValue">0</label></button>
	<button id="powerUpButton" onclick="powerUp(1, powerUpCost)">Power Up! ($<label id="powerUpPrice">5</label>)</button>
	<button id="speedUpButton" onclick="speedUp(1, speedUpCost)">Speed Up! ($<label id="speedUpPrice">15</label>)</button><br><br>


	<div id="extraPowerUps"></div>
    <script type="text/javascript">



        var codeValue = document.getElementById("codeValue");
        var lines = document.getElementById("lines");
        var hands = document.getElementById("hands");
        var cups = document.getElementById("cups");
        var money = document.getElementById("money");


		//--------------------------------------------------------------------------
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					array = JSON.parse(xhttp.responseText);
					lines = array[0]['lines_'];
					hands = array[0]['hands_'];
					cups = array[0]['cups_'];
					money = array[0]['money_'];
				}
			};
			xhttp.open("GET", "button.php?username=" + document.getElementById("user") + "&lines=" + lines + "&hands=" + hands + "&cups=" + cups + "&money=" + money, true);
			xhttp.send();
		}
		//--------------------------------------------------------------------------





        var sellCodeButton = document.getElementById("sellCodeButton");
        var powerUpButton = document.getElementById("powerUpButton");
        var speedUpButton = document.getElementById("speedUpButton");
        var superPowerUpButton = document.getElementById("superPowerUpButton");
        var powerUpTwentyButton = document.getElementById("powerUpTwentyButton");


        var powerUpPrice = document.getElementById("powerUpPrice");
        var powerUpCost = 5;
        var speedUpPrice = document.getElementById("speedUpPrice");
        var speedUpCost = 15;

        var extraPowerMultiplier = 5;
        var extraPowerCost = 4;
        var extraPowerUps = document.getElementById("extraPowerUps");

        var cash = 0.00;
        var codeDollars = 0.00;
        var linesPer = 1;
        var totalLines = 0.00;
        var counter = 0;
        var speed = 10;
        var coffee = 0;
        setInterval(update, 100);

        var numButtons = 0;
        var buttonCosts = [powerUpCost, speedUpCost];
        var buttonsArray = [powerUpButton, speedUpButton];

        var seconds = document.getElementById("seconds");
        var time = 0;

        setInterval(setSeconds, 1000);

        function setSeconds() {
            time++;
            seconds.innerHTML = time;
        }

        function update() {
            counter++;
            if (counter >= speed) {
                totalLines += linesPer;
                lines.innerHTML = totalLines;
                codeDollars = dollars(totalLines * (Math.pow(1.000001, totalLines)));
                //console.log("multiplier: " + Math.pow(1.0000001, totalLines));
                codeValue.innerHTML = codeDollars;
                counter = 0;
            }
        }

        function setLines() {
            totalLines += linesPer;
            lines.innerHTML = totalLines;
        }

        function powerUp(power, cost) {
        	if (cash >= (cost)) {
                cash -= cost;
                linesPer += power;
                for (var i = 0; i < power; i++) {
                    powerUpCost *= 1.01;
                }
                powerUpCost = dollars(powerUpCost);
                powerUpPrice.innerHTML = powerUpCost;
                for (var i = 0; i < document.getElementsByClassName("extraPowerPrice").length; i++) {
                    document.getElementsByClassName("extraPowerPrice")[i].innerHTML = dollars(powerUpCost * 4 * Math.pow(3, i));
                }
                cash = Math.floor(cash * 100) / 100;
                money.innerHTML = cash;
            }
            hands.innerHTML = linesPer - 1;
        }

        function speedUp(accel, cost) {

            if (cash >= cost) {
                cash -= cost;
                cash = dollars(cash);
                money.innerHTML = cash;
                for (var i = 0; i < accel; i++) {
                    speed = speed/2;
                    coffee++;
                    speedUpCost *= 10;

                }
                speedUpCost = Math.floor(speedUpCost * 100) / 100;
                if (speed <= 1) {
                    speedUpButton.disabled = true;
                }
                else {
                    speedUpPrice.innerHTML = speedUpCost;
                }
                cups.innerHTML = coffee;
                console.log(speed);
            }
        }


        function sellCode() {
            cash += codeDollars;
            cash = dollars(cash);
            codeDollars = 0;
            totalLines = 0;
            money.innerHTML = cash;
            lines.innerHTML = 0;
            codeValue.innerHTML = 0;
            checkButtons();
        }

        function checkButtons() {
            var buttonsFull = false;
            while(!buttonsFull) {
                if (numButtons < buttonCosts.length && cash >= buttonCosts[numButtons]) {
                    buttonsArray[numButtons].style.visibility = "visible";
                    numButtons++;
                }
                else {
                    buttonsFull = true;
                }
            }
            while (cash >= (powerUpCost * extraPowerCost)) {
                extraPowerUps.innerHTML += "<button class=\"extraPowerUpButton\" onclick=\"powerUp(" + extraPowerMultiplier + ", powerUpCost*" + extraPowerCost + ")\">Power Up x" + extraPowerMultiplier + " ($<label class=\"extraPowerPrice\">" + dollars(extraPowerCost*powerUpCost) + "</label>)</button> ";
                extraPowerMultiplier *= 4;
                extraPowerCost *= 3;
                if (document.getElementsByClassName("extraPowerUpButton").length % 4 == 0) {
                    extraPowerUps.innerHTML += "<br><br>";
                }
            }
        }

        function dollars(num) {
            return Math.floor(num * 100) / 100;
        }
    </script>
	</div>
</body>
</html>
