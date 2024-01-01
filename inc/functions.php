<?php
include "config.php";

function get_blogs($field)
{
    global $conn;
    $query = "SELECT * FROM blogs WHERE category = '$field' ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
}

function get_all_blogs($field)
{
    global $conn;
    $query = "SELECT * FROM blogs WHERE category != '$field' ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
}
function get_top_blogs($limit, $field)
{
    global $conn;
    $query = "SELECT * FROM blogs WHERE category = '$field' ORDER BY id DESC LIMIT $limit";
    $result = mysqli_query($conn, $query);
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
}
function get_all_top_blogs($limit)
{
    global $conn;
    $query = "SELECT * FROM blogs ORDER BY id DESC LIMIT $limit";
    $result = mysqli_query($conn, $query);
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
}
function get_user_name($user_id)
{
    global $conn;
    $query = "SELECT username FROM user WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $name;
}

function get_items($limit, $field)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE category = '$field' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $items = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}
function get_all_items($limit)
{
    global $conn;

    $sql = "SELECT * FROM items ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $items = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}
function get_all_users()
{
    global $conn;

    $sql = "SELECT * FROM user";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $users = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}
function get_books($limit, $field)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Book' and category = '$field' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $items = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}

function get_all_books($limit)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Book' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $items = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}
function get_item($item_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM items WHERE id = ?');
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function get_book($item_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM items WHERE id = ? AND doc_type = "Book"');
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}
function get_items_by_category($limit = 100, $category = null)
{
    global $conn;

    $query = "SELECT * FROM items";

    if ($category) {
        $query .= " WHERE category = '$category'";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);

    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $items;
}



function get_categories()
{
    global $conn;
    $categories = array();
    $stmt = $conn->prepare("SELECT * FROM blogs");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    return $categories;
}

function get_category_name($category_id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT category FROM blogs WHERE category = ?");
    $stmt->bind_param("s", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['category'];
    }
    if ($result->num_rows == 0) {
        return "Not categorised";
    } else {
        return "Unknown category";
    }
}


function get_blogs_by_category($category)
{
    global $conn;
    $sql = "SELECT * FROM blogs WHERE category = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $blogs = array();
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
    return $blogs;
}

function get_blog_by_id($id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function getTotalItems()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM items");
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function getTotalBlogs()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM blogs");
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function getTotalUsers()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM user");
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function getTotalCategories()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM categories");
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function getTotalFields()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) FROM fields");
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function get_newspapers($limit, $field)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Newspaper' AND category = '$field' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $newspapers = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $newspapers[] = $row;
    }

    return $newspapers;
}
function get_magazines($limit, $field)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Newspaper' AND category = '$field' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $newspapers = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $newspapers[] = $row;
    }

    return $newspapers;
}
function get_all_newspapers($limit)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Newspaper' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $newspapers = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $newspapers[] = $row;
    }

    return $newspapers;
}
function get_all_magazines($limit)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Magazine' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $magazines = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $magazines[] = $row;
    }

    return $magazines;
}

function get_newspapers_by_category($limit = 100, $category = null)
{
    global $conn;

    $query = "SELECT * FROM items";

    if ($category) {
        $query .= " WHERE category = '$category' AND doc_type = 'Newspaper'";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);

    $newspapers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $newspapers;
}
function get_magazines_by_category($limit = 100, $category = null)
{
    global $conn;

    $query = "SELECT * FROM items";

    if ($category) {
        $query .= " WHERE category = '$category' AND doc_type = 'Magazine'";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);

    $magazines = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $magazines;
}

function get_articles($limit, $field)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Article' AND category = '$field' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $articles = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }

    return $articles;
}

function get_all_articles($limit)
{
    global $conn;

    $sql = "SELECT * FROM items WHERE doc_type = 'Article' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $articles = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }

    return $articles;
}

function get_articles_by_category($limit = 100, $category = null)
{
    global $conn;

    $query = "SELECT * FROM items";

    if ($category) {
        $query .= " WHERE category = '$category' AND doc_type = 'Article'";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);

    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $articles;
}


function get_books_by_category($limit = 100, $category)
{
    global $conn;

    $query = "SELECT * FROM items";

    if ($category) {
        $query .= " WHERE category = '$category' AND doc_type = 'Book' ";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);

    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $books;
}

function getAllBlogs()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY id DESC");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getAllCategories()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getAllDocTypes()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM doc_types ORDER BY id DESC");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getAllFields()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM fields ORDER BY id DESC");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getAllItems()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM items ORDER BY id DESC");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getAllUsers()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM user ORDER BY id DESC");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getCategoriesByPage($offset, $limit)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC LIMIT $offset, $limit");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $result;
}

function getItemsByPage($offset, $limit)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM items ORDER BY id ASC LIMIT $offset, $limit");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $result;
}

function getBlogsByPage($offset, $limit)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY id ASC LIMIT $offset, $limit");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $result;
}

function getUsersByPage($offset, $limit)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM user ORDER BY id ASC LIMIT $offset, $limit");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getFieldsByPage($offset, $limit)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM fields ORDER BY id ASC LIMIT $offset, $limit");
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getTotalMessages()
{
    global $conn;

    $query = "SELECT COUNT(*) AS total FROM requests";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

function getMessagesByPage($offset, $limit)
{
    global $conn;

    $query = "SELECT * FROM requests ORDER BY id DESC LIMIT $offset, $limit";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $messages;
    } else {
        return array();
    }
}

function getTotalPages($total_records, $records_per_page)
{
    return ceil($total_records / $records_per_page);
}

function search_items($search_query, $limit = 10, $field = '')
{
    global $conn;
    $items = array();
    $query = "SELECT * FROM items WHERE title LIKE '%$search_query%' OR description LIKE '%$search_query%'";

    if (!empty($field)) {
        $query .= " AND category = '$field'";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    return $items;
}

function search_top_blogs($search_query, $limit = 10, $field = '')
{
    global $conn;
    $blogs = array();
    $query = "SELECT * FROM blogs WHERE title LIKE '%$search_query%' OR content LIKE '%$search_query%'";

    if (!empty($field)) {
        $query .= " AND category = '$field'";
    }

    $query .= " ORDER BY created_at DESC LIMIT $limit";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }
    return $blogs;
}

function search_blogs($search_query, $field)
{
    global $conn;
    $blogs = array();
    $query = "SELECT * FROM blogs WHERE (title LIKE '%$search_query%' OR content LIKE '%$search_query%' OR category LIKE '%$search_query%') ORDER BY created_at DESC";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }
    return $blogs;
}

function search_articles($search_term)
{
    global $conn;
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $query = "SELECT * FROM items WHERE title LIKE '%$search_term%' OR description LIKE '%$search_term%' AND category = 'Articles'";
    $result = mysqli_query($conn, $query);
    $articles = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
    }
    return $articles;
}
function search_newspapers($search_term)
{
    global $conn;
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $query = "SELECT * FROM items WHERE title LIKE '%$search_term%' OR description LIKE '%$search_term%' AND category = 'Newspaper'";
    $result = mysqli_query($conn, $query);
    $articles = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
    }
    return $articles;
}
function search_magazines($search_term)
{
    global $conn;
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $query = "SELECT * FROM items WHERE title LIKE '%$search_term%' OR description LIKE '%$search_term%' AND category = 'Magazine'";
    $result = mysqli_query($conn, $query);
    $articles = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
    }
    return $articles;
}
function search_blogs2($search_query, $category = null)
{
    global $conn;
    $blogs = array();
    $query = "SELECT * FROM blogs WHERE (title LIKE '%$search_query%' OR content LIKE '%$search_query%')";

    if ($category) {
        $query .= " AND category = '$category'";
    }

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $blogs[] = $row;
        }
    }

    return $blogs;
}

function search_books($search_query)
{
    global $conn;

    // Prepare the query to search for books matching the search query
    $search_query = mysqli_real_escape_string($conn, $search_query);
    $query = "SELECT * FROM items WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR description LIKE '%$search_query%'";

    // Execute the query and fetch the results
    $result = mysqli_query($conn, $query);
    if ($result) {
        $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $books;
    } else {
        echo "Error: " . mysqli_error($conn);
        return array();
    }
}
