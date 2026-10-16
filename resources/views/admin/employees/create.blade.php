<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Employee - Otirasor Beach and Resort</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #2c3e50;
        }

        .navbar {
            background: #2c3e50;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .navbar h2 {
            margin: 0;
            font-size: 21px;
        }

        .navbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .back-btn,
        .dashboard-btn {
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .back-btn {
            background: #3498db;
        }

        .back-btn:hover {
            background: #2980b9;
        }

        .dashboard-btn {
            background: #6c757d;
        }

        .dashboard-btn:hover {
            background: #5a6268;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .subtitle {
            color: #6c757d;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.15);
        }

        .error {
            color: #c0392b;
            font-size: 13px;
            margin-top: 6px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .save-btn,
        .cancel-btn {
            flex: 1;
            padding: 13px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .save-btn {
            background: #27ae60;
            color: white;
        }

        .save-btn:hover {
            background: #219150;
        }

        .cancel-btn {
            background: #e9ecef;
            color: #2c3e50;
        }

        .cancel-btn:hover {
            background: #dfe3e6;
        }

        .note {
            background: #eef6ff;
            border-left: 4px solid #3498db;
            padding: 12px 14px;
            margin-bottom: 25px;
            font-size: 14px;
            line-height: 1.5;
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 15px;
                flex-direction: column;
                align-items: stretch;
            }

            .navbar h2 {
                font-size: 17px;
            }

            .navbar-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn,
            .dashboard-btn {
                text-align: center;
                width: 100%;
            }

            .container {
                margin: 25px auto;
                padding: 0 15px;
            }

            .card {
                padding: 22px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">

        <h2>
            Otirasor Beach and Resort
        </h2>


        <div class="navbar-actions">

            <a
                href="{{ route('admin.employees.index') }}"
                class="back-btn"
            >
                ← Back to Employee Management
            </a>

            <a
                href="{{ url('/admin/dashboard') }}"
                class="dashboard-btn"
            >
                Admin Dashboard
            </a>

        </div>

    </div>


    <div class="container">

        <div class="card">

            <h1>
                Add Employee
            </h1>

            <p class="subtitle">
                Create a new employee account for the resort.
            </p>


            <div class="note">

                Employee accounts created here are automatically assigned
                the <strong>Employee</strong> role.

            </div>


            @if ($errors->any())

                <div class="error" style="margin-bottom: 20px;">

                    <strong>Please fix the following:</strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.employees.store') }}"
            >

                @csrf


                <div class="form-group">

                    <label for="name">
                        Employee Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter employee name"
                        required
                    >

                    @error('name')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter employee email"
                        required
                    >

                    @error('email')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimum 8 characters"
                        required
                    >

                    @error('password')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="form-group">

                    <label for="password_confirmation">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Re-enter password"
                        required
                    >

                </div>


                <div class="buttons">

                    <a
                        href="{{ route('admin.employees.index') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="save-btn"
                    >
                        Create Employee
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>
</html>