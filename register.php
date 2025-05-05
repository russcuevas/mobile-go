<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shopping Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        /* Use system-ui font for exact match */
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
                sans-serif;
            background-image: url("https://img.freepik.com/premium-vector/online-data-protection-shield-abstract-with-computer-technology_29971-309.jpg?w=740");
            background-repeat: no-repeat;
            /* Prevents the background image from repeating */
            background-size: cover;
        }
    </style>

</head>

<body class="bg-black min-h-screen flex items-center justify-center p-4">
    <form action="" method="POST"
        class="bg-white rounded-2xl p-6 w-full max-w-md text-gray-900"
        aria-label="Shopping Registration Form">
        <h1 class="font-semibold text-base mb-1"> Registration Form</h1>
        <p class="text-xs mb-4"> fill out the form below to register.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 mb-4">
            <div>
                <label
                    for="firstName"
                    class="block text-[10px] font-semibold mb-1 leading-none">First Name</label>
                <input
                    id="firstName"
                    name="firstname"
                    type="text"
                    placeholder="Name"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
            </div>
            <div>
                <label
                    for="lastName"
                    class="block text-[10px] font-semibold mb-1 leading-none">Last Name</label>
                <input
                    id="lastname"
                    name="lastName"
                    type="text"
                    placeholder="Last Name"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
            </div>
        </div>

        <div class="mb-4">
            <label
                for="email"
                class="block text-[10px] font-semibold mb-1 leading-none">Email Address</label>
            <input
                id="email"
                name="email"
                type="email"
                placeholder="@example.com"
                class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 mb-4">
            <div>
                <label
                    for="password"
                    class="block text-[10px] font-semibold mb-1 leading-none">Password</label>
                <input
                    id="password"
                    name="password"
                    type="text"
                    placeholder=""
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
            </div>
            <div>
                <label
                    for="confirm_password"
                    class="block text-[10px] font-semibold mb-1 leading-none">Confirm Password</label>
                <input
                    id="confirm_password"
                    name="password"
                    type="text"
                    placeholder=""
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
            </div>
        </div>

        <div class="mb-4">
            <label
                for="phone"
                class="block text-[10px] font-semibold mb-1 leading-none">Phone Number</label>
            <input
                id="phone"
                name="phone"
                type="tel"
                placeholder="+"
                class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
        </div>

        <div class="mb-4">
            <label
                for="birthdate"
                class="block text-[10px] font-semibold mb-1 leading-none">Birthdate</label>
            <input
                id="birthdate"
                name="birthdate"
                type="date"
                class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
        </div>


        <h2 class="font-semibold text-base mb-2">Delivery Address</h2>

        <div class="mb-4">
            <label
                for="street"
                class="block text-[10px] font-semibold mb-1 leading-none">Street Address</label>
            <input
                id="street"
                name="street"
                type="text"
                placeholder="123 Example Street"
                class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 mb-4">
            <div>
                <label
                    for="city"
                    class="block text-[10px] font-semibold mb-1 leading-none">City</label>
                <input
                    id="city"
                    name="city"
                    type="text"
                    placeholder=""
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
            </div>
            <div>
                <label
                    for="zip"
                    class="block text-[10px] font-semibold mb-1 leading-none">Zip Code</label>
                <input
                    id="zip"
                    name="zip"
                    type="text"
                    placeholder="12345"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs placeholder:text-gray-300" />
            </div>
        </div>

        <button
            type="button"
            onclick="window.location.href='login.php'"
            class="bg-gray-300 text-black text-xs font-semibold rounded px-6 py-1.5 w-full mb-2">
            Back
        </button>
        <button
            type="submit" name="register-btn"
            class="bg-[#2980b9] text-black text-xs font-semibold rounded px-6 py-1.5 w-full">
            Register
        </button>
    </form>
</body>

</html>