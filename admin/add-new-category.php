<?php require_once("includes/head.php"); ?>

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
          <h1 class="h3 mb-0 text-gray-800">Add New Category</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
              <!-- Account -->
              <div class="card-body">
                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label class="form-label">Category</label>
                      <input class="form-control" type="text" id="new-category"
                             autofocus required/>
                    </div>

                  </div>
                  <div class="row">
                    <div class="mt-3 col-md-6">
                      <input type="button" onclick="return validateNewCategory()" class="btn btn-primary" value="Add Category">
                      <a  class="btn btn-success" href="categories.php">All Categories</a>
                    </div>
                  </div>
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
