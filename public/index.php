<?php include "header.php"; ?>
<?php require_once dirname(__DIR__) . "/config/db.php"; ?>

<?php if (!isset($_SESSION['user_id'])): ?>

<div class="alert alert-info mt-4">
    You must <a href="login.php">login</a> to continue.
</div>

<?php else: ?>

<style>
.note-card {
    transition: 0.2s;
}
.note-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}
.badge-category {
    background: #eef2ff;
    color: #4f46e5;
    font-size: 0.75rem;
}
</style>

<h3 class="mt-3">Welcome, <?= $_SESSION['username'] ?> 👋</h3>
<p class="text-muted">Manage your personal notes below</p>

<?php
$user_id = $_SESSION['user_id'];

$search    = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$category  = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";

// Build dynamic WHERE
$where = "user_id=$user_id";

if (!empty($search)) {
    $where .= " AND (title LIKE '%$search%' OR content LIKE '%$search%')";
}

if (!empty($category)) {
    $where .= " AND category='$category'";
}

$categories = mysqli_query($conn, 
    "SELECT DISTINCT category FROM notes WHERE user_id=$user_id AND category != ''"
);

$notes = mysqli_query($conn,
    "SELECT * FROM notes WHERE $where ORDER BY created_at DESC"
);
?>

<!-- Search + Filter Bar -->
<div class="card shadow-sm p-3 mb-4">

    <form class="row g-3" method="GET">

        <div class="col-md-6">
            <input type="text" name="search" class="form-control" 
                   placeholder="Search by title or content…" 
                   value="<?= $search ?>">
        </div>

        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['category'] ?>" 
                        <?= ($category == $cat['category']) ? "selected" : "" ?>>
                        <?= $cat['category'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

    </form>

</div>

<a href="note_create.php" class="btn btn-success mb-3">
    + Add New Note
</a>

<div class="row g-4">
<?php if (mysqli_num_rows($notes) == 0): ?>

    <div class="col-12">
        <div class="alert alert-secondary text-center shadow-sm">
            No notes found. Try changing the search or create a new note!
        </div>
    </div>

<?php else: ?>

    <?php while ($row = mysqli_fetch_assoc($notes)): ?>
    <div class="col-md-4">
        <div class="card note-card shadow-sm">

            <div class="card-body">

                <h5 class="card-title">
                    <?= htmlspecialchars($row['title']) ?>
                </h5>

                <?php if (!empty($row['category'])): ?>
                <span class="badge badge-category mb-2">
                    <?= htmlspecialchars($row['category']) ?>
                </span>
                <?php endif; ?>

                <p class="text-muted small mb-3">
                    Created: <?= $row['created_at'] ?>
                </p>

                <p class="card-text" style="max-height: 60px; overflow:hidden;">
                    <?= nl2br(substr($row['content'],0,120)) ?>...
                </p>

                <div class="d-flex justify-content-between mt-3">
                    <a href="note_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                    <a href="note_delete.php?id=<?= $row['id'] ?>" 
                       onclick="return confirm('Delete this note?')" 
                       class="btn btn-sm btn-danger">
                        Delete
                    </a>
                </div>

            </div>

        </div>
    </div>
    <?php endwhile; ?>

<?php endif; ?>
</div>

<?php endif; ?>

<?php include "footer.php"; ?>
