<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio Login">
    <title>Login • My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--color-mid) 0%, var(--color-dark) 100%);
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        
        .login-header h1 {
            color: #000;
            margin: 0 0 8px 0;
            font-size: 2rem;
            font-weight: 800;
        }
        
        .login-header p {
            color: #666;
            margin: 0 0 32px 0;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #000;
        }
        
        .login-btn {
            width: 100%;
            background: #000;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-bottom: 16px;
        }
        
        .login-btn:hover {
            background: #333;
        }
        
        .back-link {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        
        .back-link:hover {
            color: #000;
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Portfolio Login</h1>
                <p>Access your portfolio dashboard</p>
            </div>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    Invalid credentials. Please try again.
                </div>
            <?php endif; ?>
            
            <form method="POST" action="auth.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-btn">Login</button>
            </form>
            
            <a href="about.php" class="back-link">← Back to Portfolio</a>
        </div>
    </div>
</body>
</html>