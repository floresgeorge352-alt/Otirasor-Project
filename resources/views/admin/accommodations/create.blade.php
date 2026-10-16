<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Add Accommodation - Otirasor Beach
    </title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        nav {
            background: #0077b6;
            padding: 18px 50px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            margin-left: 25px;
            font-size: 16px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
        }

        .back-btn {
            display: inline-block;

            background: #6c757d;
            color: white;

            text-decoration: none;

            padding: 10px 18px;

            border-radius: 6px;

            margin-bottom: 25px;
        }

        .back-btn:hover {
            background: #545b62;
        }

        .form-box {
            background: white;

            padding: 30px;

            border-radius: 10px;

            box-shadow:
                0 3px 10px rgba(0,0,0,0.08);
        }

        h1 {
            color: #023e8a;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            font-weight: bold;

            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 15px;

            font-family: Arial, sans-serif;
        }

        textarea {
            min-height: 120px;

            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;

            border-color: #0077b6;
        }

        .error {
            background: #fdecec;

            border: 1px solid #dc3545;

            color: #842029;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 20px;
        }

        .error ul {
            margin-left: 20px;
        }

        .submit-btn {
            width: 100%;

            padding: 13px;

            background: #0077b6;

            color: white;

            border: none;

            border-radius: 6px;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        .submit-btn:hover {
            background: #005f8f;
        }

        .cancel-btn {
            display: block;

            width: 100%;

            text-align: center;

            margin-top: 12px;

            padding: 11px;

            background: #6c757d;

            color: white;

            text-decoration: none;

            border-radius: 6px;
        }

        .cancel-btn:hover {
            background: #545b62;
        }

        .image-help {
            display: block;

            margin-top: 6px;

            color: #666;

            font-size: 13px;
        }

    </style>

</head>


<body>


<nav>

    <div class="logo">
        Otirasor Beach Admin
    </div>


    <div>

        <a href="/admin/dashboard">
            Dashboard
        </a>


        <a href="/admin/bookings">
            Bookings
        </a>


        <a href="/admin/reports">
            Reports
        </a>


        <form
            method="POST"
            action="/logout"
            style="display:inline;"
        >

            @csrf

            <button
                type="submit"
                class="logout-btn"
            >
                Logout
            </button>

        </form>

    </div>

</nav>


<div class="container">


    <a
        href="/admin/accommodations"
        class="back-btn"
    >
        ← Back to Accommodations
    </a>


    <div class="form-box">


        <h1>
            Add Accommodation
        </h1>


        @if($errors->any())

            <div class="error">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul style="margin-top:10px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="/admin/accommodations"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="form-group">

                <label for="name">
                    Accommodation Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: Room 1"
                    required
                >

            </div>


            <div class="form-group">

                <label for="type">
                    Type
                </label>

                <select
                    id="type"
                    name="type"
                    required
                >

                    <option value="">
                        Select Type
                    </option>

                    <option
                        value="Room"
                        @selected(old('type') === 'Room')
                    >
                        Room
                    </option>

                    <option
                        value="Cottage"
                        @selected(old('type') === 'Cottage')
                    >
                        Cottage
                    </option>

                    <option
                        value="Function Hall"
                        @selected(old('type') === 'Function Hall')
                    >
                        Function Hall
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Enter accommodation description..."
                >{{ old('description') }}</textarea>

            </div>


            <div class="form-group">

                <label for="price">
                    Price
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price') }}"
                    min="0"
                    step="0.01"
                    placeholder="0.00"
                    required
                >

            </div>


            <div class="form-group">

                <label for="capacity">
                    Capacity
                </label>

                <input
                    type="number"
                    id="capacity"
                    name="capacity"
                    value="{{ old('capacity') }}"
                    min="1"
                    placeholder="Number of persons"
                    required
                >

            </div>


            <div class="form-group">

                <label for="image">
                    Accommodation Photo
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                >

                <small class="image-help">
                    JPG, JPEG, PNG, or WEBP. Maximum 10MB.
                </small>

            </div>


            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option
                        value="available"
                        @selected(old('status', 'available') === 'available')
                    >
                        Available
                    </option>

                    <option
                        value="unavailable"
                        @selected(old('status') === 'unavailable')
                    >
                        Unavailable
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="submit-btn"
            >
                Add Accommodation
            </button>


            <a
                href="/admin/accommodations"
                class="cancel-btn"
            >
                Cancel
            </a>

        </form>


    </div>


</div>


</body>

</html>