<?php

require '../../includes/init.php';

$db = require '../../includes/db.php';

// Instantiate job object;
$categories = new Category($db);

$results = $categories->getCategories();

$num = $results->rowCount();

if ($num > 0) {
    $cat_arr = [];
    $cat_arr['categories'] = [];

    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $cat_item = [
            'id' => $id,
            'name' => $name
        ];

        array_push($cat_arr['categories'], $cat_item);
    }
    echo json_encode($cat_arr);
} else {
    // no categories
    echo json_encode(['message' => 'No categories found']);
}
