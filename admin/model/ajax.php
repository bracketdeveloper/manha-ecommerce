<?php
require_once "functions.php";
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_GET['action']) && $_GET['action'] == 'add_new_category') {
  $category = mysqli_real_escape_string($conn, $_POST['new_category']);
  $checkExistingCategory = "SELECT * FROM `categories` WHERE `category` = '$category'";
  $checkExistingCategoryResult = mysqli_query($conn, $checkExistingCategory);
  if (mysqli_num_rows($checkExistingCategoryResult) > 0) {
    echo "Category already exists.";
  } else {
    $newCategoryInsertQuery = "INSERT INTO `categories`(`category`) VALUES ('$category')";
    if ($conn->query($newCategoryInsertQuery) === TRUE) {
      echo "Category has been added successfully.";
    } else {
      echo "An error occured while adding new category.";
    }
  }
}
if (isset($_GET['action']) && $_GET['action'] == 'edit_category') {
  $category = mysqli_real_escape_string($conn, $_POST['edit_category']);
  $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);
  $checkExistingCategory = "SELECT * FROM `categories` WHERE `category` = '$category'";
  $checkExistingCategoryResult = mysqli_query($conn, $checkExistingCategory);
  if (mysqli_num_rows($checkExistingCategoryResult) > 0) {
    echo "Category already exists.";
  } else {
    $categoryUpdateQuery = "UPDATE `categories` SET `category` = '$category' WHERE `category_id` = '$categoryId'";
    if ($conn->query($categoryUpdateQuery) === TRUE) {
      echo "Category has been edited successfully.";
    } else {
      echo "An error occured while editing category.";
    }
  }
}
if (isset($_GET['action']) && $_GET['action'] == 'delete_category') {
  $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);
  $deleteQuery = "DELETE FROM `categories` WHERE  `category_id` = '$categoryId'";
  if ($conn->query($deleteQuery) === TRUE) {
    echo "Category has been deleted successfully.";
  } else {
    echo "An error occured while deleting category.";
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'add_new_product') {
  $prefix = "PROD";
  $productId = $prefix . '_' . time();
  $productName = mysqli_real_escape_string($conn, $_POST['product_name']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $originalPrice = mysqli_real_escape_string($conn, $_POST['original_price']);
  $discountedPrice = mysqli_real_escape_string($conn, $_POST['discounted_price']);
  $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);


  $checkExistingProduct = "SELECT * FROM `products` WHERE `product_name` = '$productName'";
  $checkExistingProductResult = mysqli_query($conn, $checkExistingProduct);
  if (mysqli_num_rows($checkExistingProductResult) > 0) {
    echo "Product with same name already exists.";
  } else {
    $imageNames = [];
    $uploadDir = "../../uploads/";

    if (!empty($_FILES['images']['name'][0])) {
      foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = $productId . '_' . basename($_FILES['images']['name'][$key]);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
          $imageNames[] = $fileName;
        }
      }
    }
    $imageJson = json_encode($imageNames);
    $newProductInsertQuery = "INSERT INTO `products`(`product_id`, `product_name`, `description`,
                       `original_price`, `discounted_price`, `image`, `category_id`) VALUES
                        ('$productId', '$productName', '$description', '$originalPrice', '$discountedPrice',
                         '$imageJson', '$categoryId')";
    if ($conn->query($newProductInsertQuery) === TRUE) {
      $productDetails = getAllProducts($conn);
      $images = array();
      foreach ($productDetails as $product) {
        $decoded = json_decode($product['image'], true);
        if (is_array($decoded)) {
          $images = array_merge($images, $decoded);
        }
      }
      deleteUnusedProductImages("../../uploads/", $images);
      echo "Product has been added successfully.";
    } else {
      echo "An error occured while adding new product.";
    }
  }
}
if (isset($_GET['action']) && $_GET['action'] == 'edit_product') {
  $productId = mysqli_real_escape_string($conn, $_POST['edit_product_id']);
  $productName = mysqli_real_escape_string($conn, $_POST['edit_product_name']);
  $description = mysqli_real_escape_string($conn, $_POST['edit_description']);
  $originalPrice = mysqli_real_escape_string($conn, $_POST['edit_original_price']);
  $discountedPrice = mysqli_real_escape_string($conn, $_POST['edit_discounted_price']);
  $categoryId = mysqli_real_escape_string($conn, $_POST['edit_category_id']);
  $existingImages = isset($_POST['existing_images']) ? $_POST['existing_images'] : '[]';
  $existingProduct = getProductByName($conn,$productName);
  if($existingProduct[0]['product_id'] !== $productId){
    echo "Product with same name already exists.";
  }else{
    $imageNames = [];
    $uploadDir = "../../uploads/";

    if (!empty($_FILES['images']['name'][0])) {
      foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = $productId . '_' . basename($_FILES['images']['name'][$key]);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
          $imageNames[] = $fileName;
        }
      }
    }
    $existingImages = array_map('trim', explode(',', $existingImages));
    $finalImages = array_unique(array_merge($existingImages, $imageNames));
    $finalImageJson = json_encode($finalImages);


    $productUpdateQuery = "UPDATE `products` SET `product_name`='$productName', `description`='$description',
                      `original_price`='$originalPrice', `discounted_price` = '$discountedPrice',
                      `category_id` = '$categoryId', `image` = '$finalImageJson' WHERE
                        `product_id` = '$productId'";
    if ($conn->query($productUpdateQuery) === TRUE) {
      getProductImagesToDelete($conn);
      echo "Product has been edited successfully.";
    } else {
      echo "An error occured while editing product.";
    }
  }
}
if (isset($_GET['action']) && $_GET['action'] == 'delete_product') {
  $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
  $deleteQuery = "DELETE FROM `products` WHERE  `product_id` = '$productId'";
  if ($conn->query($deleteQuery) === TRUE) {
    getProductImagesToDelete($conn);
    echo "Product has been deleted successfully.";
  } else {
    echo "An error occured while deleting product.";
  }
}


if (isset($_GET['action']) && $_GET['action'] == 'add_new_user') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $name = ucwords(strtolower($name));
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $password = password_hash($password, PASSWORD_BCRYPT);
  $role = mysqli_real_escape_string($conn, $_POST['role']);
  $checkExistingUser = "SELECT * FROM `users` WHERE `email` = '$email'";
  $checkExistingUserResult = mysqli_query($conn, $checkExistingUser);
  if (mysqli_num_rows($checkExistingUserResult) > 0) {
    echo "User already exists.";
  } else {
    $newUserInsertQuery = "INSERT INTO `users`(`user_name`, `email`, `password`, `role`) VALUES
                               ('$name', '$email', '$password', '$role')";
    if ($conn->query($newUserInsertQuery) === TRUE) {
      echo "User has been added successfully.";
    } else {
      echo "An error occured while adding new user.";
    }
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'login_user') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $loginQuery = "SELECT * FROM `users` WHERE `email` = '$email'";
  $loginQueryResult = mysqli_query($conn, $loginQuery);
  if (mysqli_num_rows($loginQueryResult) === 1) {
    $row = mysqli_fetch_array($loginQueryResult, MYSQLI_ASSOC);
    if (password_verify($password, $row['password'])) {
      $_SESSION['user'] = 'True';
      $_SESSION["user_id"] = $row['user_id'];
      $_SESSION["email"] = $row['email'];
      $_SESSION["name"] = $row['user_name'];
      $_SESSION["role"] = $row['role'];
      $_SESSION["password"] = $password;
      echo "Login successful.";
    }else{
      echo "Incorrect login details.";
    }
  } else {
    echo "User not found.";
  }
}
if (isset($_GET['action']) && $_GET['action'] == 'logout_user') {
  session_destroy();
  echo "Logged out successfully.";
}
if (isset($_GET['action']) && $_GET['action'] == 'change_password') {
  $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
  $currentPassword = mysqli_real_escape_string($conn, $_POST['current_password']);
  $userId = $_SESSION["user_id"];
  if($currentPassword !== $_SESSION['password']){
    echo "Current password is incorrect.";
    exit();
  }

  $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
  $productUpdateQuery = "UPDATE `users` SET `password` = '$newPasswordHash' WHERE
                        `user_id` = '$userId'";
  if ($conn->query($productUpdateQuery) === TRUE) {
    $_SESSION["password"] = $newPassword;
    echo "Password has been changed successfully.";
  } else {
    echo "An error occured while changing password.";
  }

}

if (isset($_GET['action']) && $_GET['action'] == 'get_user_data_by_id') {
  $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
  $specificUser = getSpecificUserById($conn, $userId);
  echo json_encode($specificUser);
}


