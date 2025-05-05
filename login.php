<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Auth System</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("https://img.freepik.com/premium-vector/online-data-protection-shield-abstract-with-computer-technology_29971-309.jpg?w=740");
            background-repeat: no-repeat;
            /* Prevents the background image from repeating */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .card.active {
            display: block;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input,
        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }

        button {
            background-color: #2980b9;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #3498db;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-size: 1em;
            color: #444;
        }

        .admin {
            color: #e74c3c;
            font-weight: bold;
        }

        .limited {
            color: #27ae60;
        }
    </style>
</head>

<body>

    <!-- Login Page -->
    <div class="card" id="loginCard">
        <h2>Login</h2>
        <form id="loginForm">
            <input type="email" id="loginEmail" placeholder="Email" required />
            <input type="password" id="loginPassword" placeholder="Password" required />
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
        </form>
    </div>

</body>

</html>