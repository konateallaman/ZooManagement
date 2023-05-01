 <?php
            ob_start();
            require './connection/connect.inc.php';
            // Retrieve all tickets from database
            $sql = "SELECT * FROM sale_tickets";
            // Check if any filter value is submitted
            if(isset($_GET['filter_value']) && !empty($_GET['filter_value'])) {
                $filter = $_GET['filter'];
                $filter_value = $_GET['filter_value'];
                // Add WHERE clause based on filter conditions
                if ($filter === 'ticket_price') {
                    $sql .= " WHERE ticket_price LIKE '%$filter_value%'";
                } else if ($filter === 'ticket_id') {
                    $sql .= " WHERE ticket_id LIKE '%$filter_value%'";
                } else if ($filter === 'ticket_type') {
                    $sql .= " WHERE ticket_type LIKE '%$filter_value%'";
                }
            } else if(isset($_GET['price_range']) && !empty($_GET['price_range'])) {
                $price_range = $_GET['price_range'];
                // Add WHERE clause based on price range selected
                if ($price_range === '0-50') {
                    $sql .= " WHERE ticket_price >= 0 AND ticket_price <= 50";
                } else if ($price_range === '50-100') {
                    $sql .= " WHERE ticket_price >= 50 AND ticket_price <= 100";
                } else if ($price_range === '100-150') {
                    $sql .= " WHERE ticket_price >= 100 AND ticket_price <= 150";
                } else if ($price_range === '150-200') {
                    $sql .= " WHERE ticket_price >= 150 AND ticket_price <= 200";
                } else if ($price_range === '200+') {
                    $sql .= " WHERE ticket_price >= 200";
                }
            }
            $result1 = $conn->query($sql);
            $num_rows = $result1->num_rows; // Get the number of rows returned
            if ($num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ticket_id'] . "</td>";
                    echo "<td>" . $row["ticket_type"] . "</td>";
                    echo "<td>" . $row["ticket_price"] . "</td>";
                    echo "<td>" . $row["event"] . "</td>";
                    echo "<td>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='ticket_id' value='" . $row["ticket_id"] . "'>";
                    echo "<input type='hidden' name='action' value='delete'>";
                    echo "<button type='submit' class='btn btn-danger'  onClick=\"return confirm('Are you sure you want to delete this animal?')\"><i class='bi bi-trash'></i>Delete</button>";
                    echo "&nbsp;";
                    echo "<td><a href='edit_sale_ticket.php?ticket_id=" . $row['ticket_id'] . "' class='btn btn-warning'><i class='bi bi-pencil'></i>Edit</a></td>";
                    echo "</tr>";
                }
                // Display the total number of tickets
               
echo "</tbody></table>";
echo "<p><b>Total number of tickets: " . $num_rows . "</b></p>";
} else {
echo "<tr><td colspan='4'>No tickets found.</td></tr>";
echo "</tbody></table>";
}
$conn->close();
ob_end_flush();
?>