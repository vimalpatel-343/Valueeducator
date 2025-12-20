<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - Value Educator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0052cc, #0747a6);
            color: white;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .coming-soon-container {
            text-align: center;
            max-width: 600px;
        }
        .logo {
            margin-bottom: 2rem;
        }
        .logo img {
            height: 80px;
        }
        h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 2rem 0;
        }
        .countdown-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            min-width: 100px;
        }
        .countdown-item span {
            display: block;
            font-size: 2rem;
            font-weight: 700;
        }
        .countdown-item small {
            font-size: 0.9rem;
        }
        .subscribe-form {
            margin-top: 2rem;
        }
        .subscribe-form input {
            border-radius: 50px;
            padding: 12px 20px;
            border: none;
        }
        .subscribe-form button {
            border-radius: 50px;
            padding: 12px 30px;
            background: #de350b;
            border: none;
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <div class="logo">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Value Educator">
        </div>
        <h1>Coming Soon</h1>
        <p class="lead">Our website is under construction. We're working hard to give you the best experience!</p>
        
        <div class="countdown">
            <div class="countdown-item">
                <span id="days">00</span>
                <small>Days</small>
            </div>
            <div class="countdown-item">
                <span id="hours">00</span>
                <small>Hours</small>
            </div>
            <div class="countdown-item">
                <span id="minutes">00</span>
                <small>Minutes</small>
            </div>
            <div class="countdown-item">
                <span id="seconds">00</span>
                <small>Seconds</small>
            </div>
        </div>
        
        <div class="subscribe-form">
            <p>Subscribe to get notified when we launch!</p>
            <form class="d-flex">
                <input type="email" class="form-control me-2" placeholder="Your email address">
                <button type="submit" class="btn">Notify Me</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set the date we're counting down to
        const countDownDate = new Date("Jan 1, 2025 00:00:00").getTime();
        
        // Update the count down every 1 second
        const x = setInterval(function() {
            // Get today's date and time
            const now = new Date().getTime();
            
            // Find the distance between now and the count down date
            const distance = countDownDate - now;
            
            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the result
            document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');
            
            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("days").innerHTML = "00";
                document.getElementById("hours").innerHTML = "00";
                document.getElementById("minutes").innerHTML = "00";
                document.getElementById("seconds").innerHTML = "00";
            }
        }, 1000);
    </script>
</body>
</html>