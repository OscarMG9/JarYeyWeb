<?php include("../backend/conexion.php")?>
<?php
$sql = "SELECT s.StudentName, c.CourseName
        FROM StudentCourses sc
        JOIN Students s ON sc.StudentID = s.StudentID
        JOIN Courses c ON sc.CourseID = c.CourseID
        ORDER BY s.StudentName, c.CourseName";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<select multiple>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["StudentName"] . ", " . $row["CourseName"] . "'>" . $row["StudentName"] . " - " . $row["CourseName"] . "</option>";
    }
    echo "</select>";
} else {
    echo "0 results";
}

$conn->close();
?>