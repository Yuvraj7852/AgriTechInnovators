<?php
include('php/db.php');

$sql = "SELECT u.username, r.report_type, r.report_content, r.submission_date, r.marks
        FROM intern_reports r
        JOIN internships i ON r.internship_id = i.id
        JOIN users u ON i.user_id = u.id
        WHERE u.role = 'intern'";

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>View Intern Reports</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Intern Name</th>
                    <th>Report Type</th>
                    <th>Report Content</th>
                    <th>Submission Date</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['username']}</td>
                            <td>{$row['report_type']}</td>
                            <td>{$row['report_content']}</td>
                            <td>{$row['submission_date']}</td>
                            <td>{$row['marks']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
