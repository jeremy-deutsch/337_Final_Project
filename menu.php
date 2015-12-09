<?php
	session_start();

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title id="title">We made an idle game!</title>


</head>
<body>
	<div id="logout">
		<form method="post" action=logout.php>
            <input type="hidden" name="lines" id="linesPHP" value="">
            <input type="hidden" name="hands" id="handsPHP" value="">
            <input type="hidden" name="cups" id="cupsPHP" value="">
            <input type="hidden" name="seconds" id="secondsPHP" value="">
            <input type="hidden" name="money" id="moneyPHP" value="">
			<input onclick="saveGame()" type="submit" name="logout" value="Logout">
		</form>
	</div>

	<div id="menu">
	<h2>Welcome, <label id="user"><?= $_SESSION['user'];?></label>!<br></h2>
	<p>You've written <label id="lines"><?= $_SESSION['lines'] ?></label> lines of code!</p>
    <p>You've grown <label id="hands"><?= $_SESSION['hands'] ?></label> extra hands.</p>
    <p>You've had <label id="cups"><?= $_SESSION['cups'] ?></label> cups of coffee.</p>
	<p>You've been coding for <label id="seconds"><?= $_SESSION['seconds'] ?></label> seconds.</p>
    <p>You've made $<label id="money"><?= $_SESSION['money'] ?></label>.</p>
    <button id="sellCodeButton" onclick="sellCode()" class="otherButton">Sell Code for $<label id="codeValue">0</label></button>
	<button id="powerUpButton" onclick="powerUp(1, powerUpCost)" class="otherButton">Power Up! ($<label id="powerUpPrice">5</label>)</button>
	<button id="speedUpButton" onclick="speedUp(1, speedUpCost)" class="otherButton">Speed Up! ($<label id="speedUpPrice"><?= 15 * pow(10, $_SESSION['cups']) ?></label>)</button><br><br>


	<div id="extraPowerUps"></div><br>
    <button id="resetButton" onclick="resetGame()">Reset Game</button><br><br>
    </div>
    <div id="fancyText">></div>
    <script type="text/javascript">



        var codeValue = document.getElementById("codeValue");
        var lines = document.getElementById("lines");
        var hands = document.getElementById("hands");
        var cups = document.getElementById("cups");
        var money = document.getElementById("money");




        var sellCodeButton = document.getElementById("sellCodeButton");
        var powerUpButton = document.getElementById("powerUpButton");
        var speedUpButton = document.getElementById("speedUpButton");
        var superPowerUpButton = document.getElementById("superPowerUpButton");
        var powerUpTwentyButton = document.getElementById("powerUpTwentyButton");


        var powerUpPrice = document.getElementById("powerUpPrice");
        var powerUpCost = 5 * <?= ($_SESSION['hands'] + 1) * log($_SESSION['hands'] + 1) * log($_SESSION['hands'] + 1) ?>;//Math.pow(1.001, <?= $_SESSION['hands'] ?>);
        var speedUpPrice = document.getElementById("speedUpPrice");
        var speedUpCost = 15 * Math.pow(10, <?= $_SESSION['cups'] ?>);

        var extraPowerMultiplier = 5;
        var extraPowerCost = 4;
        var extraPowerUps = document.getElementById("extraPowerUps");

        var cash = <?= $_SESSION['money'] ?>;
        var codeDollars = 0.00;
        var linesPer = 1 + <?= $_SESSION['hands'] ?>;
        var totalLines = <?= $_SESSION['lines'] ?>;
        var counter = 0;
        var speed = <?= 10 / pow(2, $_SESSION['cups']) ?>;
        var coffee = <?= $_SESSION['cups'] ?>;
        setInterval(update, 100);

        var fancyText = document.getElementById("fancyText");
        var printCounter = 0;

        var numButtons = 0;
        var buttonCosts = [5, 15];
        var buttonsArray = [powerUpButton, speedUpButton];

        var seconds = document.getElementById("seconds");
        var time = <?= $_SESSION['seconds'] ?>;

        setInterval(setSeconds, 1000);

        window.onload = powerUp(0, 0);
        window.onload = speedUp(0, 0);
        window.onload = checkButtons();

        function setSeconds() {
            time++;
            seconds.innerHTML = time;
        }

        function update() {
            counter++;
            if (counter >= speed) {
                totalLines += linesPer;
                lines.innerHTML = totalLines;
                codeDollars = dollars(totalLines * Math.log(totalLines));
                //console.log("multiplier: " + Math.pow(1.0000001, totalLines));
                codeValue.innerHTML = codeDollars;
                printStuff();
                counter = 0;
            }
        }

        function printStuff() {
            printCounter++;
            if (printCounter >= 20) {
                fancyText.innerHTML = "\>";
                printCounter = 0;
            }
            fancyText.innerHTML = Math.random().toString(36).substring(2) + Math.random().toString(36).substring(2) + Math.random().toString(36).substring(2) + "<br>" + fancyText.innerHTML;
        }

        function powerUp(power, cost) {
        	if (cash >= (cost)) {
                cash -= cost;
                linesPer += power;
                powerUpCost = dollars(5 * linesPer * Math.log(linesPer) * Math.log(linesPer)) + 5;
                powerUpPrice.innerHTML = dollars(powerUpCost);
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
                    speedUpButton.style.color = '#a3a3c2';
                    speedUpPrice.innerHTML = "MAX";
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
                extraPowerUps.innerHTML += "<button class=\"extraPowerUpButton\" onclick=\"powerUp(" + extraPowerMultiplier + ", powerUpCost*" + extraPowerCost + ")\">Power Up x" + extraPowerMultiplier + " ($<label class=\"extraPowerPrice\">" + dollars(extraPowerCost*powerUpCost) + "</label>)</button> "; //Makes new buttons
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


        function saveGame() {
            document.getElementById("linesPHP").value = totalLines;
            document.getElementById("handsPHP").value = linesPer - 1;
            document.getElementById("cupsPHP").value = coffee;
            document.getElementById("secondsPHP").value = time;
            document.getElementById("moneyPHP").value = cash;
        }

        function resetGame() {
            if (confirm("Are you sure you want to reset your game?")) {
                totalLines = 0;
                time = 0;
                linesPer = 1;
                coffee = 0;
                cash = 0;
                speed = 10;
                speedUpCost = 15;
                numButtons = 0;
                speedUpButton.style.color = 'white';
                speedUpButton.disabled = false;
                powerUpButton.style.visibility = 'hidden';
                speedUpButton.style.visibility = 'hidden';
                extraPowerMultiplier = 5;
                extraPowerCost = 4;
                extraPowerUps.innerHTML = "";
                powerUp(0, 0);
                speedUp(0, 0);
            }
        }
    </script>
</body>
</html>
