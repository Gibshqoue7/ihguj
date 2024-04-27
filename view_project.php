<?php
if (isset($_GET['project_id'])) {
    $project_id = intval($_GET['project_id']); // Securely get project ID from the query parameter
    
    try {
        $db = new SQLite3('projects.db'); // Connect to SQLite database
        $stmt = $db->prepare("SELECT * FROM projects WHERE project_id = ?");
        $stmt->bindValue(1, $project_id, SQLITE3_INTEGER);
        
        $result = $stmt->execute(); // Execute the query
        
        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Return the project details as JSON or as a formatted HTML response
            echo json_encode($row); // Or render the details as HTML
        } else {
            echo "Project not found.";
        }
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred while fetching the project details.";
    }
} else {
    echo "No project ID provided.";
}
?>
