<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';


// Lấy danh sách danh mục
$sql = "SELECT * FROM category";
$result = $conn->query($sql);
?>


<h2>Category List</h2>
<style>
    /* Add Category button */
    a.btn {
        display: inline-block;
        margin: 20px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        font-size: 16px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    a.btn:hover {
        background-color: #0056b3;
    }

    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #ffffff;
        border: 1px solid #ddd;
    }

    /* Table headers */
    th {
        padding: 12px;
        background-color: #007BFF;
        color: white;
        font-size: 16px;
        text-align: left;
    }

    th:hover {
        background-color: #0056b3;
    }

    /* Table data cells */
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    /* Table rows hover effect */
    tr:hover {
        background-color: #f2f2f2;
    }

    /* Actions links */
    td a {
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
        margin: 0 5px;
    }

    td a:hover {
        color: #0056b3;
    }

    /* Optional: Styling for when there's no data */
    tbody.empty {
        text-align: center;
        font-style: italic;
        color: #999;
    }

    /* Pagination and other button styles can go here if needed */
</style>
<a href="../../admin/tabs/add_category.php" class="btn">Add Category</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <a href="../../admin/tabs/edit_category.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="../../admin/tabs/delete_category.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>

            </tr>
        <?php endwhile; ?>
    </tbody>
</table>