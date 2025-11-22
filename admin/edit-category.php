<?php require_once("includes/head.php"); ?>
<?php
require_once("model/functions.php");
  $category_id = $_GET['category_id'];
  $category = getCategoryById($conn,$category_id);
  if($category == null){
    echo "<script>alert(`Invalid request`);
          window.location.href= 'categories.php'</script>";
  }
?>

<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <?php require_once("includes/sidebar.php"); ?>
  <!-- End of Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <!-- Topbar -->
      <?php require_once("includes/topbar.php"); ?>
      <!-- End of Topbar -->

      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
              <!-- Account -->
              <div class="card-body">
                <form id="new-category-form" method="POST">
                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label class="form-label">Category</label>
                      <input class="form-control" type="text" id="edit-category"
                             autofocus required value="<?php echo $category[0]['category']; ?>" />
                    </div>

                  </div>
                  <div class="row">
                    <div class="mt-3 col-md-6">
                      <label class="form-label">&nbsp;</label>
                      <input type="button" onclick="return validateEditCategory(<?php echo $category[0]['category_id']; ?>)" class="btn btn-primary" value="Edit Category">
                      <a  class="btn btn-success" href="categories.php">All Categories</a>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /Account -->
            </div>

          </div>
        </div>

        <!-- Content Row -->

        <div class="row">

        </div>

        <!-- Content Row -->
        <div class="row">


        </div>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <?php require_once("includes/footer.php"); ?>
