<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Feel Free To Make a List">
    <meta property="og:description" content="Mars Hub">
    <meta property="og:image" content="https://raw.githubusercontent.com/Aku-Mars/gambar/main/bannercps.png">
    <meta property="og:url" content="https://akumars.dev/">    
    <title>Make List In Here</title>
    <link rel="icon" href="https://raw.githubusercontent.com/Aku-Mars/gambar/main/neko.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            transition: background-color 0.5s, color 0.5s;
            background-color: #f0f0f0; /* Light mode background */
            color: #333; /* Light mode text color */
        }

        h1 {
            color: #4CAF50;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-size: 1.2em;
            color: #4CAF50;
            margin-right: 10px;
        }

        input {
            padding: 8px;
            width: 70%;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            margin-left: 10px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
            transform: scale(1.2);
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            background-color: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background-color 0.5s, color 0.5s;
        }

        .completed .wishlist-text {
            text-decoration: line-through;
            color: #abb2bf;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .wishlist-text {
            font-weight: bold;
            flex-grow: 1;
            margin-left: 10px;
            transition: color 0.3s ease;
            white-space: nowrap;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .chat-container {
            max-width: 600px;
            margin: auto;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #282c35; /* Dark mode background */
            color: #e0e0e0; /* Dark mode text color */
        }

        body.dark-mode ul {
            color: #e0e0e0;
        }

        body.dark-mode li {
            background-color: #3a3f4b;
        }

        body.dark-mode .completed .wishlist-text {
            color: #a0a0a0;
        }

        body.dark-mode .edit-button {
            background-color: #4CAF50;
        }

        body.dark-mode .edit-button:hover {
            background-color: #45a049;
        }

        body.dark-mode .delete-button {
            background-color: #ff4d4d;
        }

        body.dark-mode .delete-button:hover {
            background-color: #e60000;
        }

        .actions-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .delete-button {
            background-color: #ff4d4d;
            color: white;
            padding: 8px 12px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            display: none;
        }

        .delete-button:hover {
            background-color: #e60000;
            transform: scale(1.2);
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 20px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            margin-left: 10px;
        }

        .edit-button:hover {
            background-color: #45a049;
            transform: scale(1.2);
        }

        /* Mobile Styles */
        @media (max-width: 600px) {
            input {
                width: 100%;
                margin-bottom: 10px;
            }

            button {
                margin-top: 10px;
                width: 100%;
                margin-left: 0;
            }

            .chat-container {
                padding: 0 10px;
            }

            .actions-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .delete-button, .edit-button {
                width: 100%;
                margin: 5px 0;
            }

            li {
                flex-direction: row;
                align-items: center;
            }
        }

    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Wishlist</h1>
        <form action="add.php" method="POST">
            <input type="text" name="item" required>
            <button type="submit">Tambah</button>
            <button class="edit-button" id="edit-button" type="button" onclick="toggleDeleteButtons()">Edit</button>
        </form>
        <!-- <button id="theme-toggle" type="button">Toggle Dark Mode</button> -->
        <?php
        if (isset($_SESSION['messages'])) {
            echo '<ul>';
            foreach ($_SESSION['messages'] as $message) {
                echo "<li>$message</li>";
            }
            echo '</ul>';
            unset($_SESSION['messages']);
        }
        ?>
        <ul id="checklist">
            <?php
            include 'db.php';
            $result = $conn->query("SELECT * FROM wishlist");
            while ($row = $result->fetch_assoc()) {
                $completedClass = $row['completed'] ? 'completed' : '';
                $checked = $row['completed'] ? 'checked' : '';
                echo "<li class=\"$completedClass\">
                        <div class=\"checkbox-container\">
                            <input type=\"checkbox\" $checked onchange=\"location.href='complete.php?id={$row['id']}'\">
                            <span class=\"wishlist-text\">{$row['item']}</span>
                        </div>
                        <button class=\"delete-button\" id=\"delete-{$row['id']}\" onclick=\"location.href='delete.php?id={$row['id']}'\">Hapus</button>
                      </li>";
            }
            ?>
        </ul>
    </div>

    <script>
        const body = document.body;
        const themeToggle = document.getElementById('theme-toggle');

        // Check local storage for theme preference
        const isDarkMode = localStorage.getItem('dark-mode') === 'true';

        // Set initial theme based on local storage or browser preference
        body.classList.toggle('dark-mode', isDarkMode || (window.matchMedia('(prefers-color-scheme: dark)').matches));

        // Function to toggle theme
        const toggleTheme = () => {
            body.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', body.classList.contains('dark-mode'));
        };

        // Set up event listener for theme toggle button
        themeToggle.addEventListener('click', toggleTheme);

        // Function to toggle delete buttons visibility
        const toggleDeleteButtons = () => {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.style.display = button.style.display === 'block' ? 'none' : 'block';
            });
        };
    </script>

</body>
</html>
