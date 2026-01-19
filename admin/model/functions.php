<?php
require_once "db_connections.php";

function getAllCategories($conn)
{
  $query = "SELECT * FROM `categories`";
  return runSelectQuery($conn, $query);
}
function getCategoryById($conn, $categoryId)
{
  $query = "SELECT * FROM `categories` WHERE `category_id` = '$categoryId'";
  return runSelectQuery($conn, $query);
}

function getAllProducts($conn)
{
  $query = "SELECT * FROM `products` Order by `created_at` DESC";
  return runSelectQuery($conn, $query);
}
function getProductById($conn, $productId)
{
  $query = "SELECT * FROM `products` WHERE `product_id` = '$productId'";
  return runSelectQuery($conn, $query);
}
function getProductByName($conn, $productName)
{
  $query = "SELECT * FROM `products` WHERE `product_name` = '$productName'";
  return runSelectQuery($conn, $query);
}

function getAllUsers($conn)
{
  $query = "SELECT * FROM `users`";
  return runSelectQuery($conn, $query);
}

function runSelectQuery($conn, $query)
{
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);

  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = $row;
  }

  return $data;
}
function deleteUnusedProductImages($folder, $dbImages) {
  $allImages = glob($folder . "*.{jpg,jpeg,png,webp,gif}", GLOB_BRACE);

  foreach ($allImages as $filePath) {
    $fileName = basename($filePath);
    if (!in_array($fileName, $dbImages)) {
      unlink($filePath);
    }
  }
}
function getProductImagesToDelete($conn){
  $productDetails = getAllProducts($conn);
  $images = array();
  foreach ($productDetails as $product) {
    $decoded = json_decode($product['image'], true);
    if (is_array($decoded)) {
      $images = array_merge($images, $decoded);
    }
  }
  deleteUnusedProductImages("../../uploads/", $images);
}

function showAlret($message)
{
  echo "<script>alert('$message');</script>";
}
function getSpecificUserById($conn, $userId)
{
  $query = "SELECT * FROM `users` WHERE `user_id` = '$userId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getAllColors($conn)
{
  $query = "SELECT * FROM `colors`";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificColorById($conn, $colorId)
{
  $query = "SELECT * FROM `colors` WHERE `color_id` = '$colorId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificProductionColorById($conn, $colorId, $productionId)
{
  $query = "SELECT * FROM `colors`
        left outer join `production_colors` ON (production_colors.color_id = $colorId)
        WHERE colors.color_id = '$colorId' AND production_colors.production_id = '$productionId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificProductionRejectsById($conn, $colorId, $productionId)
{
  $query = "SELECT SUM(total_rejects) as 'total' FROM `production_rejects` WHERE
              `production_id` = '$productionId' AND color_id = '$colorId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}


function getSpecificProductById($conn, $productId)
{
  $query = "SELECT * FROM `products` WHERE `product_id` = '$productId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getAllMaterials($conn)
{
  $query = "SELECT * FROM `materials`";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificMaterialById($conn, $materialId)
{
  $query = "SELECT * FROM `materials` WHERE `material_id` = '$materialId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificProdcutionMaterialById($conn, $materialId, $productionId)
{
  $query = "SELECT * FROM `materials`
        left outer join `production_materials` ON (production_materials.material_id = $materialId)
        WHERE materials.material_id = '$materialId' AND production_materials.production_id = '$productionId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getAllCheckLists($conn)
{
  $query = "SELECT * FROM `check_lists`";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificCheckListById($conn, $checkListId)
{
  $query = "SELECT * FROM `check_lists` WHERE `check_list_id` = '$checkListId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificCheckListByName($conn, $checkListName)
{
  $query = "SELECT * FROM `check_lists` WHERE `check_list_name` = '$checkListName'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getAllMachines($conn)
{
  $query = "SELECT * FROM `machines`";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificMachineById($conn, $machineId)
{
  $query = "SELECT * FROM `machines` WHERE `machine_id` = '$machineId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getAllProductions($conn)
{
  $query = "SELECT * FROM `productions`";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}

function getSpecificProductionById($conn, $productionId)
{
  $query = "SELECT * FROM `productions`
        left outer join `production_materials` ON (production_materials.production_id = $productionId)
        left outer join `production_colors` ON (production_colors.production_id = $productionId)
        left outer join `machines` ON (machines.machine_id = productions.machine_id)
        left outer join `products` ON (products.product_id = productions.product_id)
        left outer join `users` ON (users.user_id = productions.start_user_id)
        WHERE productions.production_id = '$productionId'";
  $result = mysqli_query($conn, $query);
  echo mysqli_error($conn);
  $data = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    {
      $data[] = $row;
    }
  }
  return $data;
}
