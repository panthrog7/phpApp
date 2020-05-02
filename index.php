<?php
include_once 'includes/dbconn.php';

?>



<!DOCTYPE html>
<html lang="en">

<!-- HTML KOMMENTAR -->


<head>
    <!-- UNBEDINGT TITLE -->
    <title>Panos Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        <?php
        include(__DIR__ . "/styles.css");
        ?>
    </style>
    <title>Document</title>
</head>

<body>

    <!-- __DIR__:
    <?php
    echo __DIR__;
    ?> -->


    <h2>Welcome to my new Website</h2>
    <?php

    // define variables and set to empty values
    $nameErr = $emailErr = $genderErr = $websiteErr = "";
    $name = $email = $gender = $duty = $website = "";

    $error = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
            $error = true;
            echo "Name leer";
        } else {
            $name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
                $error = true;
                echo "Name passt nicht";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            echo "Email passt nicht";
            $error = true;
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                echo "Email falsches format und passt nicht";
                $error = true;
            }
        }

        if (empty($_POST["website"])) {
            $website = "";
        } else {
            $website = test_input($_POST["website"]);
            // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                $websiteErr = "Invalid URL";
                echo "Url ist kacke";
                $error = true;
            }
        }

        if (empty($_POST["duty"])) {
            $duty = "";
            $error = true;
            echo "Duty darf nicht leer sein!";
        } else {
            $duty = test_input($_POST["duty"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
            echo "Gender darf nicht apache helikopter sein!";
            $error = true;
        } else {
            $gender = test_input($_POST["gender"]);
        }

        $sql = "INSERT INTO duties_db.duties_table (name, email, website, duty, gender) values ('" . $_POST["name"] . "', '" . $_POST["email"] . "', '" . $_POST["website"] . "', '" . $_POST["duty"] . "', '" . $_POST["gender"] . "')";

        if (!$error) {
            if ($conn->query($sql) === TRUE) {
                echo "Passt - Datensatz wurde eingefügt!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Fehler";
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>

    <h3>PHP Form Validation Example</h3>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <input type="text" name="name" value="<?php echo $name; ?>">
        <span class="error">* <?php echo $nameErr; ?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>
        Website: <input type="text" name="website" value="<?php echo $website; ?>">
        <span class="error"><?php echo $websiteErr; ?></span>
        <br><br>
        Duty: <textarea name="duty" rows="5" cols="40"><?php echo $duty; ?></textarea>
        <span class="error">* <?php echo $dutyErr; ?></span>
        <br><br>
        Gender:
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">Female
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male">Male
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other") echo "checked"; ?> value="other">Other
        <span class="error">* <?php echo $genderErr; ?></span>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    echo "<h4>Your Input:</h4>";
    echo $name;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $website;
    echo "<br>";
    echo $duty;
    echo "<br>";
    echo $gender;
    ?>

    <?php
    $sql = "SELECT * FROM duties_db.duties_table";
    $result = $conn->query($sql);

    ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Website</th>
            <th>Duty</th>
            <th>Gender</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["website"] . "</td><td>" . $row["duty"] . "</td><td>" . $row["gender"] . "</td></tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>

</html>