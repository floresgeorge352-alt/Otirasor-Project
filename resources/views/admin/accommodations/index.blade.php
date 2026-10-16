<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Accommodation Management - Otirasor Beach and Resort
    </title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            color: #1f2937;
        }

        /* =========================================
           NAVBAR
        ========================================= */

        nav {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 35px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            color: #023e8a;
            font-size: 18px;
            font-weight: bold;
        }

        .brand-subtitle {
            color: #6b7280;
            font-size: 12px;
            margin-top: 2px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a,
        .logout-btn {
            border: none;
            background: transparent;
            color: #374151;
            text-decoration: none;

            padding: 9px 12px;
            border-radius: 8px;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .nav-links a:hover,
        .logout-btn:hover {
            background: #eff6ff;
            color: #0077b6;
        }

        /* =========================================
           CONTAINER
        ========================================= */

        .container {
            max-width: 1180px;
            margin: 32px auto;
            padding: 0 20px;
        }

        /* =========================================
           PAGE HEADER
        ========================================= */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;

            margin-bottom: 24px;
        }

        .page-header h1 {
            color: #023e8a;
            font-size: 28px;
            margin-bottom: 7px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;
            border: none;

            padding: 11px 16px;
            border-radius: 9px;

            font-size: 14px;
            font-weight: bold;

            cursor: pointer;
            white-space: nowrap;
        }

        .back-btn {
            background: #e5e7eb;
            color: #374151;
        }

        .back-btn:hover {
            background: #d1d5db;
        }

        .add-btn {
            background: #0077b6;
            color: white;
        }

        .add-btn:hover {
            background: #023e8a;
        }

        /* =========================================
           SUCCESS MESSAGE
        ========================================= */

        .message {
            background: #ecfdf3;
            border: 1px solid #86efac;
            color: #166534;

            padding: 13px 15px;
            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 14px;
            font-weight: 600;
        }

        /* =========================================
           FILTER PANEL
        ========================================= */

        .filter-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;

            padding: 18px;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 15px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 12px;
        }

        .filter-top {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
        }

        .search-box {
            flex: 1;
        }

        .search-box input {
            width: 100%;

            border: 1px solid #d1d5db;
            border-radius: 9px;

            padding: 12px 14px;

            font-size: 14px;
            color: #111827;

            outline: none;
        }

        .search-box input:focus {
            border-color: #0077b6;
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.10);
        }

        .filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-btn {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #4b5563;

            padding: 9px 14px;
            border-radius: 8px;

            cursor: pointer;

            font-size: 13px;
            font-weight: bold;
        }

        .filter-btn:hover {
            background: #f3f4f6;
        }

        .filter-btn.active {
            background: #0077b6;
            border-color: #0077b6;
            color: white;
        }

        /* =========================================
           TABLE CARD
        ========================================= */

        .table-container {
            background: #ffffff;

            border: 1px solid #e5e7eb;
            border-radius: 14px;

            overflow: hidden;
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #f8fafc;
            color: #374151;

            padding: 14px 16px;

            text-align: left;

            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;

            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 15px 16px;

            border-bottom: 1px solid #eef0f3;

            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .name {
            font-weight: bold;
            color: #111827;
        }

        .type {
            display: inline-block;

            background: #eff6ff;
            color: #075985;

            padding: 5px 9px;
            border-radius: 999px;

            font-size: 12px;
            font-weight: bold;
        }

        .description {
            max-width: 240px;
            color: #6b7280;
            line-height: 1.4;
        }

        .price {
            font-weight: bold;
            color: #111827;
            white-space: nowrap;
        }

        .capacity {
            white-space: nowrap;
            color: #4b5563;
        }

        /* =========================================
           STATUS
        ========================================= */

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            padding: 5px 9px;
            border-radius: 999px;

            font-size: 12px;
            font-weight: bold;
        }

        .available {
            background: #ecfdf3;
            color: #15803d;
        }

        .unavailable {
            background: #fef2f2;
            color: #b91c1c;
        }

        /* =========================================
           ACTIONS
        ========================================= */

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .edit-btn,
        .delete-btn {
            border: none;

            padding: 8px 11px;
            border-radius: 7px;

            font-size: 12px;
            font-weight: bold;

            cursor: pointer;
            text-decoration: none;

            white-space: nowrap;
        }

        .edit-btn {
            background: #e0f2fe;
            color: #0369a1;
        }

        .edit-btn:hover {
            background: #bae6fd;
        }

        .delete-btn {
            background: #fee2e2;
            color: #b91c1c;
        }

        .delete-btn:hover {
            background: #fecaca;
        }

        /* =========================================
           EMPTY STATE
        ========================================= */

        .empty {
            padding: 55px 20px;
            text-align: center;
        }

        .empty-icon {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .empty h2 {
            color: #374151;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .empty p {
            color: #6b7280;
            font-size: 14px;
        }

        /* =========================================
           PAGINATION
        ========================================= */

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 15px 16px;

            border-top: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .pagination-info {
            color: #6b7280;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .page-btn {
            min-width: 34px;
            height: 34px;

            border: 1px solid #d1d5db;
            background: white;
            color: #374151;

            border-radius: 7px;

            cursor: pointer;

            font-size: 13px;
            font-weight: bold;
        }

        .page-btn:hover:not(:disabled) {
            background: #f3f4f6;
        }

        .page-btn.active {
            background: #0077b6;
            border-color: #0077b6;
            color: white;
        }

        .page-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        /* =========================================
           FOOTER
        ========================================= */

        footer {
            text-align: center;
            color: #9ca3af;

            padding: 30px 20px;

            font-size: 12px;
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 760px) {

            nav {
                padding: 13px 18px;

                flex-direction: column;
                align-items: stretch;
            }

            .brand {
                justify-content: center;
            }

            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .header-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .btn {
                width: 100%;
            }

            .filter-top {
                flex-direction: column;
            }

            .filter-buttons {
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .filter-btn {
                width: 100%;
            }

            .pagination-container {
                flex-direction: column;
                align-items: stretch;
            }

            .pagination {
                justify-content: center;
            }

        }

        @media (max-width: 480px) {

            .container {
                margin: 22px auto;
                padding: 0 12px;
            }

            .brand-title {
                font-size: 16px;
            }

            .brand-subtitle {
                font-size: 11px;
            }

            .nav-links a,
            .logout-btn {
                font-size: 12px;
                padding: 8px 9px;
            }

            .header-actions {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =========================================
     NAVBAR
========================================= -->

<nav>

    <div class="brand">

        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
            alt="Otirasor Beach and Resort Logo"
        >

        <div class="brand-text">

            <div class="brand-title">
                Otirasor Beach and Resort
            </div>

            <div class="brand-subtitle">
                Admin Panel
            </div>

        </div>

    </div>


    <div class="nav-links">

        <a href="/admin/dashboard">
            🏠 Dashboard
        </a>

        <a href="/admin/bookings">
            📋 Bookings
        </a>

        <a href="/admin/notifications">
            🔔 Notifications
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
                🚪 Logout
            </button>

        </form>

    </div>

</nav>


<!-- =========================================
     MAIN
========================================= -->

<div class="container">


    <div class="page-header">

        <div>

            <h1>
                🏨 Accommodation Management
            </h1>

            <p>
                Manage rooms, cottages, and function halls.
            </p>

        </div>


        <div class="header-actions">

            <a
                href="/admin/management"
                class="btn back-btn"
            >
                ← Management
            </a>


            <a
                href="/admin/accommodations/create"
                class="btn add-btn"
            >
                + Add Accommodation
            </a>

        </div>

    </div>


    <!-- =========================================
         SUCCESS MESSAGE
    ========================================== -->

    @if(session('success'))

        <div class="message">

            ✓ {{ session('success') }}

        </div>

    @endif


    <!-- =========================================
         FILTERS
    ========================================== -->

    <div class="filter-box">

        <div class="filter-title">
            🔎 Search & Filter
        </div>


        <div class="filter-top">

            <div class="search-box">

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search accommodation..."
                >

            </div>

        </div>


        <div class="filter-buttons">

            <button
                type="button"
                class="filter-btn active"
                data-filter="all"
            >
                📋 All
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="Room"
            >
                🛏️ Rooms
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="Cottage"
            >
                🏡 Cottages
            </button>


            <button
                type="button"
                class="filter-btn"
                data-filter="Function Hall"
            >
                🏢 Function Halls
            </button>

        </div>

    </div>


    <!-- =========================================
         TABLE
    ========================================== -->

    <div class="table-container">


        @if($accommodations->count() > 0)


            <div class="table-scroll">

                <table id="accommodationTable">

                    <thead>

                        <tr>

                            <th>
                                Name
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Capacity
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody id="accommodationBody">


                        @foreach($accommodations as $accommodation)


                            <tr
                                class="accommodation-row"
                                data-type="{{ $accommodation->type }}"
                                data-search="{{ strtolower(
                                    $accommodation->name .
                                    ' ' .
                                    $accommodation->type .
                                    ' ' .
                                    $accommodation->description
                                ) }}"
                            >


                                <td>

                                    <div class="name">
                                        {{ $accommodation->name }}
                                    </div>

                                </td>


                                <td>

                                    <span class="type">
                                        {{ $accommodation->type }}
                                    </span>

                                </td>


                                <td>

                                    <div class="description">

                                        {{ $accommodation->description ?: 'No description' }}

                                    </div>

                                </td>


                                <td class="price">

                                    ₱{{ number_format(
                                        $accommodation->price,
                                        2
                                    ) }}

                                </td>


                                <td class="capacity">

                                    👥 {{ $accommodation->capacity }}
                                    persons

                                </td>


                                <td>


                                    @if($accommodation->status === 'available')

                                        <span class="status available">
                                            ● Available
                                        </span>

                                    @else

                                        <span class="status unavailable">
                                            ● Unavailable
                                        </span>

                                    @endif


                                </td>


                                <td>


                                    <div class="actions">


                                        <a
                                            href="/admin/accommodations/{{ $accommodation->id }}/edit"
                                            class="edit-btn"
                                        >
                                            ✏️ Edit
                                        </a>


                                        <form
                                            method="POST"
                                            action="/admin/accommodations/{{ $accommodation->id }}"
                                            onsubmit="return confirmDelete()"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="delete-btn"
                                            >
                                                🗑️ Delete
                                            </button>

                                        </form>


                                    </div>


                                </td>


                            </tr>


                        @endforeach


                    </tbody>

                </table>

            </div>


            <!-- =========================================
                 PAGINATION
            ========================================== -->

            <div class="pagination-container">

                <div
                    class="pagination-info"
                    id="paginationInfo"
                ></div>


                <div
                    class="pagination"
                    id="pagination"
                ></div>

            </div>


        @else


            <div class="empty">

                <div class="empty-icon">
                    🏨
                </div>

                <h2>
                    No accommodations yet.
                </h2>

                <p>
                    Click "Add Accommodation" to create one.
                </p>

            </div>


        @endif


    </div>


</div>


<footer>

    © 2026 Otirasor Beach and Resort. All Rights Reserved.

</footer>


<script>


    /* =========================================
       DELETE CONFIRMATION
    ========================================== */

    function confirmDelete()
    {
        return confirm(
            'Are you sure you want to delete this accommodation?'
        );
    }


    /* =========================================
       FILTER + SEARCH + PAGINATION
    ========================================== */

    const rows = Array.from(
        document.querySelectorAll(
            '.accommodation-row'
        )
    );


    const filterButtons =
        document.querySelectorAll(
            '.filter-btn'
        );


    const searchInput =
        document.getElementById(
            'searchInput'
        );


    const pagination =
        document.getElementById(
            'pagination'
        );


    const paginationInfo =
        document.getElementById(
            'paginationInfo'
        );


    const rowsPerPage = 10;


    let currentFilter = 'all';

    let currentPage = 1;


    function getFilteredRows()
    {

        const search =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : '';


        return rows.filter(
            function(row)
            {

                const type =
                    row.dataset.type;


                const searchableText =
                    row.dataset.search
                        .toLowerCase();


                const matchesFilter =
                    currentFilter === 'all' ||
                    type === currentFilter;


                const matchesSearch =
                    search === '' ||
                    searchableText.includes(
                        search
                    );


                return (
                    matchesFilter &&
                    matchesSearch
                );

            }
        );

    }


    function renderTable()
    {

        const filteredRows =
            getFilteredRows();


        const totalRows =
            filteredRows.length;


        const totalPages =
            Math.max(
                1,
                Math.ceil(
                    totalRows /
                    rowsPerPage
                )
            );


        if (
            currentPage >
            totalPages
        ) {

            currentPage =
                totalPages;

        }


        rows.forEach(
            function(row)
            {

                row.style.display =
                    'none';

            }
        );


        const start =
            (
                currentPage - 1
            ) *
            rowsPerPage;


        const end =
            start +
            rowsPerPage;


        filteredRows
            .slice(start, end)
            .forEach(
                function(row)
                {

                    row.style.display =
                        'table-row';

                }
            );


        renderPagination(
            totalPages,
            totalRows,
            start,
            end
        );

    }


    function renderPagination(
        totalPages,
        totalRows,
        start,
        end
    )
    {

        if (!pagination) {
            return;
        }


        pagination.innerHTML =
            '';


        if (totalRows === 0)
        {

            if (paginationInfo)
            {

                paginationInfo.textContent =
                    'No accommodations found.';

            }

            return;

        }


        const actualEnd =
            Math.min(
                end,
                totalRows
            );


        if (paginationInfo)
        {

            paginationInfo.textContent =
                'Showing ' +
                (start + 1) +
                '–' +
                actualEnd +
                ' of ' +
                totalRows +
                ' accommodations';

        }


        const previousButton =
            document.createElement(
                'button'
            );


        previousButton.type =
            'button';


        previousButton.className =
            'page-btn';


        previousButton.textContent =
            '←';


        previousButton.disabled =
            currentPage === 1;


        previousButton.addEventListener(
            'click',
            function()
            {

                if (
                    currentPage >
                    1
                ) {

                    currentPage--;

                    renderTable();

                }

            }
        );


        pagination.appendChild(
            previousButton
        );


        for (
            let page = 1;
            page <= totalPages;
            page++
        ) {


            const pageButton =
                document.createElement(
                    'button'
                );


            pageButton.type =
                'button';


            pageButton.className =
                'page-btn';


            pageButton.textContent =
                page;


            if (
                page ===
                currentPage
            ) {

                pageButton.classList.add(
                    'active'
                );

            }


            pageButton.addEventListener(
                'click',
                function()
                {

                    currentPage =
                        page;

                    renderTable();

                }
            );


            pagination.appendChild(
                pageButton
            );

        }


        const nextButton =
            document.createElement(
                'button'
            );


        nextButton.type =
            'button';


        nextButton.className =
            'page-btn';


        nextButton.textContent =
            '→';


        nextButton.disabled =
            currentPage ===
            totalPages;


        nextButton.addEventListener(
            'click',
            function()
            {

                if (
                    currentPage <
                    totalPages
                ) {

                    currentPage++;

                    renderTable();

                }

            }
        );


        pagination.appendChild(
            nextButton
        );

    }


    /* =========================================
       CATEGORY FILTER
    ========================================== */

    filterButtons.forEach(
        function(button)
        {

            button.addEventListener(
                'click',
                function()
                {

                    filterButtons.forEach(
                        function(btn)
                        {

                            btn.classList.remove(
                                'active'
                            );

                        }
                    );


                    this.classList.add(
                        'active'
                    );


                    currentFilter =
                        this.dataset.filter;


                    currentPage =
                        1;


                    renderTable();

                }
            );

        }
    );


    /* =========================================
       SEARCH
    ========================================== */

    if (searchInput)
    {

        searchInput.addEventListener(
            'input',
            function()
            {

                currentPage =
                    1;

                renderTable();

            }
        );

    }


    /* =========================================
       INITIAL LOAD
    ========================================== */

    renderTable();


</script>


</body>

</html>