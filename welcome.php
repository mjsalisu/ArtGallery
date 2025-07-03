<?php
    if (isset($_POST['name']) && isset($_POST['age'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        if (strlen($name) < 3) {
            echo "Name must be at least 3 characters long";
        } else {
            echo "Welcome $name, you are $age years old";
        }
    }