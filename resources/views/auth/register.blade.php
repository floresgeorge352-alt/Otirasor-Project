<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Otirasor Beach and Resort</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background image na may overlay */
            background: linear-gradient(rgba(2, 62, 138, 0.6), rgba(2, 62, 138, 0.8)), 
                        url('https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95); /* Semi-transparent white */
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-section img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .logo-section h2 {
            color: #023e8a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .logo-section p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            background: #f9fafb;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus {
            border-color: #0077b6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1);
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #023e8a, #0077b6);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(2, 62, 138, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(2, 62, 138, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-link a {
            color: #0077b6;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Error Styles */
        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="logo-section">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo">
            <h2>Join Otirasor</h2>
            <p>Create your account to start booking.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Enter your full name" 
                    required 
                    autofocus
                >
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Enter your email" 
                    required
                >
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Create a strong password" 
                    required
                >
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Confirm your password" 
                    required
                >
            </div>

            <button type="submit" class="btn-submit">
                Create Account
            </button>

            <div class="login-link">
                Already have an account? 
                <a href="{{ route('login') }}">Log In</a>
            </div>
        </form>
    </div>

</body>
</html>