function checkEmptyInput(inputEl, message) {
  var input = inputEl.value
  var input = input.trim();
  if (input == "") {
    alert(message);
    inputEl.focus()
    return false;
  }
  return true;
}
$(document).on('click', '.remove-image-btn', function () {
  $(this).parent().remove();
});
function sendAjaxRequest(url, formData, redirectUrl) {
  $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    processData: false,
    data: formData
  }).done(function (data) {
    // console.log(data)
    alert(data);
    let isData = redirectUrl && data!=="Product with same name already exists.";
    if (isData) {
      window.location.href = redirectUrl;
    }
  });
}
function sendAjaxLoginRequest(url, formData, redirectUrl) {
  $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    processData: false,
    data: formData
  }).done(function (data) {
    // console.log(data)
    alert(data);
    if (redirectUrl && data == "Login successful.") {
      window.location.href = redirectUrl;
    }
  });
}
function checkValidEmail(inputEl) {
  const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!pattern.test(inputEl.value.trim())) {
    alert("Please enter a valid email address.");
    inputEl.focus()
    return false;
  }
  return true;
}


function validateNewCategory() {
  const newCategoryEl = document.getElementById('new-category');
  if (!checkEmptyInput(newCategoryEl, "Enter the category")) {
    return;
  }
  var formData = new FormData();
  formData.append('new_category', newCategoryEl.value);
  sendAjaxRequest("model/ajax.php?action=add_new_category", formData, "add-new-category.php");
}
function validateEditCategory(categoryId) {
  const editCategoryEl = document.getElementById('edit-category');
  if (!checkEmptyInput(editCategoryEl, "Enter the category")) {
    return;
  }
  var formData = new FormData();
  formData.append('edit_category', editCategoryEl.value);
  formData.append('category_id', categoryId);
  sendAjaxRequest("model/ajax.php?action=edit_category", formData, `edit-category.php?category_id=${categoryId}`);
}
function validateDeleteCategory(categoryId) {
  if (confirm("Do you want to delete this category?") == true) {
    var formData = new FormData();
    formData.append('category_id', categoryId);
    sendAjaxRequest("model/ajax.php?action=delete_category", formData, "categories.php");
  }
}

function validateNewProduct() {
  const productNameEl = document.getElementById('product-name');
  const descriptionEl = document.getElementById('description');
  const originalPriceEl = document.getElementById('original-price');
  const discountedPriceEl = document.getElementById('discounted-price');
  const imagesEl = document.getElementById('images').files;
  const categoryIdEl = document.getElementById('category-id');
  if (!checkEmptyInput(productNameEl, "Enter the product name")) {
    return;
  }
  if (!checkEmptyInput(descriptionEl, "Enter the description")) {
    return;
  }
  if (!checkEmptyInput(originalPriceEl, "Enter the original price")) {
    return;
  }
  if (!checkEmptyInput(discountedPriceEl, "Enter the discounted price")) {
    return;
  }
  if (+discountedPriceEl.value > +originalPriceEl.value) {
    alert("Discount price can't be grater than original price");
    discountedPriceEl.focus()
    return;
  }
  if (imagesEl.length === 0) {
    alert("Select at least one image");
    return;
  }
  if (!checkEmptyInput(categoryIdEl, "Select the category")) {
    return;
  }


  var formData = new FormData();
  formData.append(' product_name', productNameEl.value);
  formData.append('description', descriptionEl.value);
  formData.append('original_price', originalPriceEl.value);
  formData.append('discounted_price', discountedPriceEl.value);
  formData.append('category_id', categoryIdEl.value);
  for (let i = 0; i < imagesEl.length; i++) {
    formData.append('images[]', imagesEl[i]);
  }
  sendAjaxRequest("model/ajax.php?action=add_new_product", formData, "add-new-product.php");
}
function validateEditProduct(productId) {
  const productNameEl = document.getElementById('edit-product-name');
  const descriptionEl = document.getElementById('edit-description');
  const originalPriceEl = document.getElementById('edit-original-price');
  const discountedPriceEl = document.getElementById('edit-discounted-price');
  const imagesEl = document.getElementById('edit-images').files;
  const categoryIdEl = document.getElementById('edit-category-id');
  const existingImages = [];
  $('#existing-images img').each(function () {
    existingImages.push($(this).attr('src').split('/').pop());
  });
  if (!checkEmptyInput(productNameEl, "Enter the product name")) {
    return;
  }
  if (!checkEmptyInput(descriptionEl, "Enter the description")) {
    return;
  }
  if (!checkEmptyInput(originalPriceEl, "Enter the original price")) {
    return;
  }
  if (!checkEmptyInput(discountedPriceEl, "Enter the discounted price")) {
    return;
  }
  if (+discountedPriceEl.value > +originalPriceEl.value) {
    alert("Discount price can't be grater than original price");
    discountedPriceEl.focus()
    return;
  }
  if (imagesEl.length === 0 && existingImages.length === 0) {
    alert("Select at least one image");
    return;
  }
  if (!checkEmptyInput(categoryIdEl, "Select the category")) {
    return;
  }
  var formData = new FormData();
  formData.append('edit_product_id', productId);
  formData.append('edit_product_name', productNameEl.value);
  formData.append('edit_description', descriptionEl.value);
  formData.append('edit_original_price', originalPriceEl.value);
  formData.append('edit_discounted_price', discountedPriceEl.value);
  formData.append('edit_category_id', categoryIdEl.value);
  for (let i = 0; i < imagesEl.length; i++) {
    formData.append('images[]', imagesEl[i]);
  }

  formData.append('existing_images', existingImages);
  sendAjaxRequest("model/ajax.php?action=edit_product", formData, `edit-product.php?product_id=${productId}`);
}
function validateDeleteProduct(productId) {
  if (confirm("Do you want to delete this product?") == true) {
    var formData = new FormData();
    formData.append('product_id', productId);
    sendAjaxRequest("model/ajax.php?action=delete_product", formData, "products.php");
  }
}

function validateNewUser() {
  const nameEl = document.getElementById('name');
  const emailEl = document.getElementById('email');
  const roleEl = document.getElementById('role');
  if (!checkEmptyInput(nameEl, "Enter the name")) {
    return;
  }
  if (!checkEmptyInput(emailEl, "Enter the email")) {
    return;
  }
  if (!checkValidEmail(emailEl)) {
    return;
  }
  if (!checkEmptyInput(roleEl, "Select the role")) {
    return;
  }
  var formData = new FormData();
  formData.append('name', nameEl.value);
  formData.append('email', emailEl.value);
  formData.append('password', 123);
  formData.append('role', roleEl.value);
  sendAjaxRequest("model/ajax.php?action=add_new_user", formData, "add-new-user.php");
}
function validateChangePassword() {
  const newPasswordEl = document.getElementById('new-password');
  const confirmPasswordEl = document.getElementById('confirm-password');
  const currentPasswordEl = document.getElementById('current-password');

  if (!checkEmptyInput(newPasswordEl, "Enter the new password")) {
    return;
  }
  if (newPasswordEl.value !== confirmPasswordEl.value) {
    alert("New password does not match to confirm password")
    confirmPasswordEl.focus();
    return;
  }
  if (!checkEmptyInput(currentPasswordEl, "Enter current password")) {
    return;
  }
  var formData = new FormData();
  formData.append('new_password', newPasswordEl.value);
  formData.append('current_password', currentPasswordEl.value);
  sendAjaxRequest("model/ajax.php?action=change_password", formData, "settings.php");
}


function validateUserLogin(){
  const emailEl = document.getElementById('email');
  const passwordEl = document.getElementById('password');


  if (!checkEmptyInput(emailEl, "Enter the email")) {
    return;
  }

  if (!checkValidEmail(emailEl)) {
    return;
  }
  if (!checkEmptyInput(passwordEl, "Enter the password")) {
    return;
  }
  var formData = new FormData();
  formData.append('email', emailEl.value);
  formData.append('password', passwordEl.value);
  sendAjaxLoginRequest("model/ajax.php?action=login_user", formData, "index.php");
}
function validateUserLogout(){
  sendAjaxRequest("model/ajax.php?action=logout_user", null, "login.php");
}

