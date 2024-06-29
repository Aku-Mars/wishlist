<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist App</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            transition: background-color 0.5s, color 0.5s;
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
        }

        li {
            background-color: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.5s;
        }

        .completed {
            text-decoration: line-through;
            color: #abb2bf;
        }

        .checkbox-container {
            margin-right: 10px;
        }

        #checklist {
            --background: #fff;
            --text: #414856;
            --check: #4f29f0;
            --disabled: #c3c8de;
            --width: 100px;
            --height: 180px;
            --border-radius: 10px;
            background: var(--background);
            width: var(--width);
            height: var(--height);
            border-radius: var(--border-radius);
            position: relative;
            box-shadow: 0 10px 30px rgba(65, 72, 86, 0.05);
            padding: 30px 85px;
            display: grid;
            grid-template-columns: 30px auto;
            align-items: center;
            justify-content: center;
        }

        #checklist label {
            color: var(--text);
            position: relative;
            cursor: pointer;
            display: grid;
            align-items: center;
            width: fit-content;
            transition: color 0.3s ease;
            margin-right: 20px;
        }

        #checklist label::before, #checklist label::after {
            content: "";
            position: absolute;
        }

        #checklist label::before {
            height: 2px;
            width: 8px;
            left: -27px;
            background: var(--check);
            border-radius: 2px;
            transition: background 0.3s ease;
        }

        #checklist label:after {
            height: 4px;
            width: 4px;
            top: 8px;
            left: -25px;
            border-radius: 50%;
        }

        #checklist input[type="checkbox"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
            height: 15px;
            width: 15px;
            outline: none;
            border: 0;
            margin: 0 15px 0 0;
            cursor: pointer;
            background: var(--background);
            display: grid;
            align-items: center;
            margin-right: 20px;
        }

        #checklist input[type="checkbox"]::before, #checklist input[type="checkbox"]::after {
            content: "";
            position: absolute;
            height: 2px;
            top: auto;
            background: var(--check);
            border-radius: 2px;
        }

        #checklist input[type="checkbox"]::before {
            width: 0px;
            right: 60%;
            transform-origin: right bottom;
            transition: width 0.4s ease;
        }

        #checklist input[type="checkbox"]::after {
            width: 0px;
            left: 40%;
            transform-origin: left bottom;
            transition: width 0.4s ease;
        }

        #checklist input[type="checkbox"]:checked::before {
            animation: check-01 0.6s ease forwards;
        }

        #checklist input[type="checkbox"]:checked::after {
            animation: check-02 0.6s ease forwards;
        }

        #checklist input[type="checkbox"]:checked + label {
            color: var(--disabled);
            animation: move 0.5s ease 0.1s forwards;
        }

        #checklist input[type="checkbox"]:checked + label::before {
            background: var(--disabled);
            animation: slice 0.6s ease forwards;
        }

        #checklist input[type="checkbox"]:checked + label::after {
            animation: firework 0.7s ease forwards 0.1s;
        }

        .wishlist-text {
            font-weight: bold;
            flex-grow: 1;
            transition: color 0.3s ease;
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
            background-color: #282c35;
        }

        li.dark-mode {
            background-color: #3a3f4b;
        }

        /* Additional Styling */
        .actions-container {
            display: flex;
            align-items: center;
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
            margin-left: 10px;
        }

        .delete-button:hover {
            background-color: #e60000;
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Wishlist</h1>
        <form action="add.php" method="POST">
            <input type="text" name="item" required>
            <button type="submit">Tambah</button>
        </form>
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
        <ul>
            <?php
            include 'db.php';
            $result = $conn->query("SELECT * FROM wishlist");
            while ($row = $result->fetch_assoc()) {
                $completedClass = $row['completed'] ? 'completed' : '';
                $checked = $row['completed'] ? 'checked' : '';
                echo "<li class=\"$completedClass\">
                        <div class=\"actions-container\">
                            <div class=\"checkbox-container\">
                                <input type=\"checkbox\" $checked onchange=\"location.href='complete.php?id={$row['id']}'\">
                            </div>
                            <span class=\"wishlist-text\">{$row['item']}</span>
                            <button class=\"delete-button\" onclick=\"location.href='delete.php?id={$row['id']}'\">Hapus</button>
                        </div>
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
    </script>

</body>
</html>
