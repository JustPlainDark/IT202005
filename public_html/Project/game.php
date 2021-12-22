<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<div class="container-fluid">
    <h1>Power-Up Shot!</h1>
    <canvas tabindex="1" width = "600px" height="400px"></canvas>
</div>
<script>
    // Arcade Shooter game
    //Modified from http://jsfiddle.net/bencentra/q1s8gmqv/?utm_source=website&utm_medium=embed&utm_campaign=q1s8gmqv
    // Get a reference to the canvas DOM element
    var canvas = document.getElementsByTagName("canvas")[0];
    // Get the canvas drawing context
    var context = canvas.getContext('2d');
    var gameOver;
    var pickup = makeSquare(0, 0, 5, 0);


    // Create an object representing a square on the canvas
    function makeSquare(x, y, length, speed) {
    return {
        x: x,
        y: y,
        l: length,
        s: speed,
        draw: function() {
        context.fillRect(this.x, this.y, this.l, this.l);
        }
    };
    }

    // The ship the user controls
    var ship = makeSquare(50, canvas.height / 2 - 25, 50, 5);

    // Flags to tracked which keys are pressed
    var up = false;
    var down = false;
    var left = false;
    var right = false;
    var space = false;

    // Is a bullet already on the canvas?
    var shooting = false;
    var shootingUp = false;
    var shootingDown = false;
    // The bullet shot from the ship
    var bullet = makeSquare(0, 0, 10, 10);

    // An array for enemies (in case there are more than one)
    var enemies = [];

    //Session data
    var session_data = [];

    // Add an enemy object to the array
    var enemyBaseSpeed = 2;
    function makeEnemy() {
    var random = Math.floor(Math.random() * 11);
    var enemyX = canvas.width;
    var enemySize = Math.round((Math.random() * 15)) + 15;
    var enemyY = Math.round(Math.random() * (canvas.height - enemySize * 2)) + enemySize;
    var enemySpeed = Math.round(Math.random() * enemyBaseSpeed) + enemyBaseSpeed;
    enemies.push(makeSquare(enemyX, enemyY, enemySize, enemySpeed));
    }

    // Check if number a is in the range b to c (exclusive)
    function isWithin(a, b, c) {
    return (a > b && a < c);
    }

    // Return true if two squares a and b are colliding, false otherwise
    function isColliding(a, b) {
    var result = false;
    if (isWithin(a.x, b.x, b.x + b.l) || isWithin(a.x + a.l, b.x, b.x + b.l)) {
        if (isWithin(a.y, b.y, b.y + b.l) || isWithin(a.y + a.l, b.y, b.y + b.l)) {
        result = true;
        }
    }
    return result;
    }

    // Track the user's score
    var score = 0;
    // The delay between enemies (in milliseconds)
    var timeBetweenEnemies = 5 * 1000;
    // ID to track the spawn timeout
    var timeoutId = null;

    // Show the game menu and instructions
    function menu() {
    erase();
    context.fillStyle = '#000000';
    context.font = '36px Arial';
    context.textAlign = 'center';
    context.fillText('Shoot \'Em!', canvas.width / 2, canvas.height / 4);
    context.font = '24px Arial';
    context.fillText('Click to Start', canvas.width / 2, canvas.height / 2);
    context.font = '18px Arial';
    context.fillText('Arrow Keys to move, WSD to shoot.', canvas.width / 2, (canvas.height / 4) * 3);
    // Start the game on a click
    canvas.addEventListener('click', startGame);
    }

    // Start the game
    function startGame() {
        // Kick off the enemy spawn interval
    timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
    // Make the first enemy
    setTimeout(makeEnemy, 1000);
    pickup.x = Math.floor(Math.random() * 300) + ship.x;
    pickup.y = Math.floor(Math.random() * 400) + 1;
    // Kick off the draw loop
    draw();
    // Stop listening for click events
    canvas.removeEventListener('click', startGame);
    }

    // Show the end game screen
    function endGame() {
        session_data.push(Date.now());
        <?php
         //used to prevent duplicate game session data
        $_SESSION["nonce"] = get_random_str(6);
        ?>
        let data = {
            score: score,
            nonce: "<?php echo $_SESSION["nonce"]; ?>", //the php will echo the value so the JS will have it as if we hard coded it
            data: session_data
        }
        sessionData = []; //reset
        let http = new XMLHttpRequest();
        http.onreadystatechange = () => {
            if (http.readyState == 4) {
                if (http.status === 200) {
                    let data = JSON.parse(http.responseText);
                    console.log("received data", data);
                    console.log("Saved score");
                }
                window.location.reload(); //lazily reloading the page to get a new nonce for next game
            }
        }
        http.open("POST", "api/save_score.php", true);
        //Convert a simple object to query params
        {
            //examples to convert data to query string parameters (used for XMLHttpRequest send)
            //https://howchoo.com/javascript/how-to-turn-an-object-into-query-string-parameters-in-javascript
            let query = null;
            //ES6
            query = Object.keys(data).map(key => key + '=' + data[key]).join('&');
            console.log("query1", query);
            //ES5
            query = Object.keys(data).map(function(key) {
                return key + '=' + data[key]
            }).join('&');
            console.log("query2", query);
        }
        http.setRequestHeader('Content-Type', 'application/json');
        http.send(JSON.stringify({
            "data": data
        }));
        // Stop the spawn interval
        clearInterval(timeoutId);
        // Show the final score
        erase();
        context.fillStyle = '#000000';
        context.font = '24px Arial';
        context.textAlign = 'center';
        context.fillText('Game Over. Final Score: ' + score, canvas.width / 2, canvas.height / 2);
        context.font = '18px Arial';
        context.fillText('Click to restart', canvas.width / 2, canvas.height / 4);
        gameOver = false;
        score = 0;
        enemies = [];
        ship.x = 50;
        ship.y = canvas.height / 2 - 25;
        canvas.addEventListener('click', startGame);
    }

    // Listen for keydown events
    canvas.addEventListener('keydown', function(event) {
    if (event.keyCode === 38) { // UP
        up = true;
    }
    if (event.keyCode === 40) { // DOWN
        down = true;
    }
    if (event.keyCode === 37) { // LEFT
        left = true;
    }
    if (event.keyCode === 39) { // RIGHT
        right = true;
    }
    if (event.keyCode === 87){ //W
        shootUp();
    }
    if (event.keyCode === 68){ //D
        shoot();
    }
    if (event.keyCode == 83){ //S
        shootDown();
    }
    });

    // Listen for keyup events
    canvas.addEventListener('keyup', function(event) {
    if (event.keyCode === 38) { // UP 
        up = false;
    }
    if (event.keyCode === 40) { // DOWN
        down = false;
    }
    if (event.keyCode === 37) { // LEFT 
        left = false;
    }
    if (event.keyCode === 39) { // RIGHT
        right = false;
    }
    });

    // Clear the canvas
    function erase() {
    context.fillStyle = '#FFFFFF';
    context.fillRect(0, 0, 600, 400);
    }

    // Shoot the bullet (if not already on screen)
    function shoot() {
    if (!shooting) {
        shooting = true;
        bullet.x = ship.x + ship.l;
        bullet.y = ship.y + ship.l / 2;
    }
    }
    function shootUp() {
    if (!shootingUp) {
        shootingUp = true;
        bullet.x = ship.x + ship.l / 2;
        bullet.y = ship.y;
    }
    }
    function shootDown() {
    if (!shootingDown) {
        shootingDown = true;
        bullet.x = ship.x + ship.l / 2;
        bullet.y = ship.y + ship.l;
    }
    }

    // The main draw loop
    function draw() {
    erase(); 
    // Move and draw the enemies
    enemies.forEach(function(enemy) {
        enemy.x -= enemy.s;
        if (enemy.x < 0){
            gameOver = true;
        }
        context.fillStyle = '#00FF00';
        enemy.draw();
    });
    
    // Collide the ship with enemies
    enemies.forEach(function(enemy, i) {
        if (isColliding(enemy, ship)) {
        gameOver = true;
        }
    });
    
    //A pickup that increases the bullet size and speed
    
        if (isColliding(pickup, ship)){
        bullet.l = 20;
        pickup.x = -5;
        pickup.y = -5;
    }
    
    // Move the ship
    if (down) {
        ship.y += ship.s;
    }
    if (up) {
        ship.y -= ship.s;
    }
    if (left) {
        ship.x -= ship.s;
    }
    if (right) {
        ship.x += ship.s;
    }
    // Don't go out of bounds
    if (ship.y < 0) {
        ship.y = 0;
    }
    if (ship.y > canvas.height - ship.l) {
        ship.y = canvas.height - ship.l;
    }
    if (ship.x > canvas.width) {
        ship.x = canvas.width;
    }
    if (ship.x < 0 + ship.l) {
        ship.x = 0 + ship.l;
    }
    // Draw the ship
    context.fillStyle = '#FF0000';
    ship.draw();
    pickup.draw();
    // Move and draw the bullet
    if (shooting) {
        // Move the bullet
        bullet.x += bullet.s;
        // Collide the bullet with enemies
        enemies.forEach(function(enemy, i) {
        if (isColliding(bullet, enemy)) {
            enemies.splice(i, 1);
            score++;
            shooting = false;
            // Make the game harder
            if (score % 10 === 0 && timeBetweenEnemies > 1000) {
            clearInterval(timeoutId);
            timeBetweenEnemies -= 1000;
            timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
            } else if (score % 5 === 0) {
            enemyBaseSpeed += 1;
            }
        }
        });
        // Collide with the wall
        if (bullet.x > canvas.width) {
        shooting = false;
        }
        // Draw the bullet
        context.fillStyle = '#0000FF';
        bullet.draw();
    }
    if (shootingUp) {
        // Move the bullet
        bullet.y -= bullet.s;
        // Collide the bullet with enemies
        enemies.forEach(function(enemy, i) {
        if (isColliding(bullet, enemy)) {
            enemies.splice(i, 1);
            score++;
            shootingUp = false;
            // Make the game harder
            if (score % 10 === 0 && timeBetweenEnemies > 1000) {
            clearInterval(timeoutId);
            timeBetweenEnemies -= 1000;
            timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
            } else if (score % 5 === 0) {
            enemyBaseSpeed += 1;
            }
        }
        });
        // Collide with the wall
        if (bullet.y < 0) {
        shootingUp = false;
        }
        // Draw the bullet
        context.fillStyle = '#0000FF';
        bullet.draw();
    }
    if (shootingDown) {
        // Move the bullet
        bullet.y += bullet.s;
        // Collide the bullet with enemies
        enemies.forEach(function(enemy, i) {
        if (isColliding(bullet, enemy)) {
            enemies.splice(i, 1);
            score++;
            shootingDown = false;
            // Make the game harder
            if (score % 10 === 0 && timeBetweenEnemies > 1000) {
            clearInterval(timeoutId);
            timeBetweenEnemies -= 1000;
            timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
            } else if (score % 5 === 0) {
            enemyBaseSpeed += 1;
            }
        }
        });
        // Collide with the wall
        if (bullet.y > canvas.height) {
        shootingDown = false;
        }
        // Draw the bullet
        context.fillStyle = '#0000FF';
        bullet.draw();
    }
    // Draw the score
    context.fillStyle = '#000000';
    context.font = '24px Arial';
    context.textAlign = 'left';
    context.fillText('Score: ' + score, 1, 25)
    // End or continue the game
    if (gameOver) {
        endGame();
    } else {
        window.requestAnimationFrame(draw);
    }
    type1 = false;
    type2 = false;
    }

    // Start the game
    menu();
    canvas.focus();
</script>
<style>
    body {
        overflow: hidden;
    }

    canvas {
        width: 80%;
        max-height: 80vh;
        display: block;
        border: 1px solid black;
        margin-left: auto;
        margin-right: auto;

        left: 0;
        bottom: 0;
        right: 0;
    }
</style>