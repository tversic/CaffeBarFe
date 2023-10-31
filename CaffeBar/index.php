<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Busy caffe bar</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/nav.css">
  <link rel="stylesheet" href="style/mainStyle.css">
</head>

<body>
  <div class="p-3 text-white lightBrownBg">
    <div class="flexMain">
      <div class="flex1">

      </div>
      <div class="flex2 text-center">
        <div><strong>EAT, DRINK, SLEEP, REPEAT</strong></div>
      </div>
      <div class="flex1">

      </div>
    </div>
  </div>
  <div id="menuHolder">
    <div role="navigation" class="sticky-top border-bottom border-top" id="mainNavigation">
      <div class="flexMain">
        <div class="flexLeft">
        </div>
        <div class="flexCenter" id="siteBrand">
          MY AWESOME SITE
        </div>
        <div class="flexRight" id="loginButton">
          <a href="login.php">
            <?php if (!isset($_COOKIE["username"])): ?>
              <button class="siteLink">Admin login</button>
            <?php else: ?>
              <button class="siteLink">Logout</button>
            <?php endif; ?>
          </a>
        </div>
      </div>
    </div>


    <!-- IMAGE -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <img src="img/baia.jpg" class="img-fluid" alt="Image 1">
        </div>
      </div>
    </div>

    <div class="container mt-5">
      <!-- Article 2 -->
      <div class="row mb-4" style="margin-top: 2%;">
        <div class="col-md-3">
          <img src="img/coctails.jpg" class="img-fluid" alt="Article 2 Image">
        </div>
        <div class="col-md-9">
          <div id="headerContainer">
            <h2 id="header">Article 2</h2>
          </div>
          <div id="articleTextContainer">
            <p id="articleText">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus
              ante
              dapibus diam.
            </p>
          </div>
          <?php if (isset($_COOKIE["username"])): ?>
            <button id="editHeaderButton" onclick="toggleEdit('header')">Edit Header</button>
            <button id="editParagraphButton" onclick="toggleEdit('paragraph')">Edit Paragraph</button>
            <div id="editForm" style="display: none;">
              <input type="text" class="inputClass" id="editInput" placeholder="Edit the text">
              <button onclick="saveEdit()">Save</button>
              <button onclick="cancelEdit()">Cancel</button>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>


  </div>

  <div class=" container" style="margin-bottom: 3%;">
    <div class="row">
      <div class="col-md-12">
        <iframe width="100%" height="500" src="https://www.youtube.com/embed/UwkoRq_L8pE?si=tIw7LjnCe_QDU7v_"
          title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen></iframe>
      </div>
    </div>
  </div>


  <div id="menuDrawer" class="lightYellow">
    <div>
      <a href="#" class="nav-menu-item"><i class="fas fa-home me-3"></i>Home</a>
      <a href="#" class="nav-menu-item"><i class="fab fa-product-hunt me-3"></i>Products</a>
      <a href="#" class="nav-menu-item"><i class="fas fa-search me-3"></i>Explore</a>
      <a href="#" class="nav-menu-item"><i class="fas fa-wrench me-3"></i>Services</a>
      <a href="#" class="nav-menu-item"><i class="fas fa-dollar-sign me-3"></i>Pricing</a>
      <a href="#" class="nav-menu-item"><i class="fas fa-file-alt me-3"></i>Blog</a>
      <a href="#" class="nav-menu-item"><i class="fas fa-building me-3"></i>About Us</a>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>


<script>
  var header = document.getElementById("header");
  var articleText = document.getElementById("articleText");
  var headerContainer = document.getElementById("headerContainer");
  var articleTextContainer = document.getElementById("articleTextContainer");
  var editForm = document.getElementById("editForm");
  var editButton = document.getElementById("editHeaderButton");
  var editHeaderButton = document.getElementById("editHeaderButton");
  var editInput = document.getElementById("editInput");
  var elementToEdit = null;

  function toggleEdit(elementToEditParam) {
    elementToEdit = elementToEditParam;
    if (elementToEdit === "header") {
      editInput.value = header.textContent;
    } else if (elementToEdit === "paragraph") {
      editInput.value = articleText.textContent;
    }

    headerContainer.style.display = "none";
    articleTextContainer.style.display = "none";
    editForm.style.display = "inline-block";
  }

  function saveEdit() {
    if (elementToEdit === "header") {
      header.textContent = editInput.value;
    } else if (elementToEdit === "paragraph") {
      articleText.textContent = editInput.value;
    }

    headerContainer.style.display = "block";
    articleTextContainer.style.display = "block";
    editForm.style.display = "none";
    editButton.style.display = "inline- block";
    editInput.value = "";
    elementToEdit = null; // Reset the elementToEdit
  }

  function cancelEdit() {
    headerContainer.style.display = "block";
    articleTextContainer.style.display = "block";
    editForm.style.display = "none";
    editButton.style.display = "inline-block";
    editInput.value = "";
    elementToEdit = null; // Reset the elementToEdit
  }
</script>


</html>