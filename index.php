<?php
// Database connection
$servername = "localhost";
$username = "root"; // Adjust this as needed
$password = ""; // Adjust this as needed
$dbname = "profession_management"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$edit_id = "";
$first_name = "";
$last_name = "";
$gender = "";
$years_of_experience = "";
$specialization = "";
$programming_languages = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $years_of_experience = $_POST['years_of_experience'];
    $specialization = $_POST['specialization'];
    $programming_languages = $_POST['programming_languages'];

    // Insert or update logic here
    if (isset($_POST['id']) && $_POST['id'] != "") {
        $edit_id = $_POST['id'];
        // Update record logic here
        $sql = "UPDATE engineers SET first_name='$first_name', last_name='$last_name', gender='$gender', years_of_experience='$years_of_experience', specialization='$specialization', programming_languages='$programming_languages' WHERE id='$edit_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Insert record logic here
        $sql = "INSERT INTO engineers (first_name, last_name, gender, years_of_experience, specialization, programming_languages) VALUES ('$first_name', '$last_name', '$gender', '$years_of_experience', '$specialization', '$programming_languages')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}

// Check if an edit is requested
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    // Fetch the record to edit
    $sql = "SELECT * FROM engineers WHERE id='$edit_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $years_of_experience = $row['years_of_experience'];
        $specialization = $row['specialization'];
        $programming_languages = $row['programming_languages'];
    } else {
        echo "No record found for ID: $edit_id";
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    // Delete record logic here
    $sql = "DELETE FROM engineers WHERE id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all records
$sql = "SELECT * FROM engineers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Software Engineer Management System</title>
    <style>
        /* General Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #003300; /* Dark Green Background */
            color: #ffffff; /* White Text */
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            color: #d6b3ff; /* Light Purple Headings */
            text-align: center; /* Centered Headings */
        }

        /* Form Styles */
        form {
            background-color: #4b004b; /* Dark Purple Background for Form */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block; /* Stack labels vertically */
            margin-top: 10px;
            color: #d6b3ff; /* Light Purple for Labels */
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none; /* Remove border */
            border-radius: 4px;
        }

        input[type="text"] {
            background-color: #e6e6e6; /* Light Background for Input Fields */
            color: #000000; /* Black Text in Input Fields */
        }

        input[type="submit"] {
            background-color: #800080; /* Dark Purple for Submit Button */
            color: white;
            cursor: pointer;
            border: none; /* Remove border */
            transition: background-color 0.3s; /* Smooth transition */
        }

        input[type="submit"]:hover {
            background-color: #b300b3; /* Lighter Purple on Hover */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #4b004b; /* Dark Purple Background for Table */
        }

        th, td {
            border: 1px solid #cccccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #660066; /* Dark Purple Header */
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #550055; /* Slightly Darker Purple for Even Rows */
        }

        /* Link Styles */
        a {
            color: #d6b3ff; /* Light Purple Links */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <h2>Software Engineer Management System</h2>
    
    <form action="index.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo $first_name; ?>">

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $last_name; ?>">

        <label>Gender:</label>
        <input type="text" name="gender" value="<?php echo $gender; ?>">

        <label>Years of Experience:</label>
        <input type="text" name="years_of_experience" value="<?php echo $years_of_experience; ?>">

        <label>Specialization:</label>
        <input type="text" name="specialization" value="<?php echo $specialization; ?>">

        <label>Programming Languages:</label>
        <input type="text" name="programming_languages" value="<?php echo $programming_languages; ?>">

        <input type="submit" value="Submit">
    </form>

    <h3>List of Software Engineers</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Years of Experience</th>
            <th>Specialization</th>
            <th>Programming Languages</th>
            <th>Action</th>
        </tr>

        <?php if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['years_of_experience']; ?></td>
                    <td><?php echo $row['specialization']; ?></td>
                    <td><?php echo $row['programming_languages']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="8">No records found.</td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
