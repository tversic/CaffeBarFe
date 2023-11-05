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
          <a href="article.php">
            <?php if (isset($_COOKIE["username"])): ?>
              <button class="siteLink">Write new article</button>
            <?php endif; ?>
          </a>
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


  </div>



  </div>

  <div class=" container" style="margin-bottom: 3%; margin-top: 5%">
    <div class="row">
      <div class="col-md-12">
        <iframe width="100%" height="500" src="https://www.youtube.com/embed/UwkoRq_L8pE?si=tIw7LjnCe_QDU7v_"
          title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen></iframe>
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

  // Getting articles start
  window.onload = function () {
    // This code will be executed when the entire page, including its resources, has finished loading.
    fetch('http://localhost:8080/post/v1/getAll')
      .then(response => response.json())
      .then(data => {
        const jsonString = JSON.stringify(data);

        // Handle the data (list of posts) here
        createArticles(data); // Call a function to create articles with the data
      })
      .catch(error => console.error('Error:', error));

  };


  function createArticles(posts) {
    const container = document.querySelector('.container'); // Get the container element
    posts.forEach((post, index) => {
      // Create a new article container
      const articleContainer = document.createElement('div');
      articleContainer.className = 'article-container row mb-12'; // Add a new class for styling

      // Create the image element (on the left)
      const image = document.createElement('img');
      image.src = 'img/coctails.jpg';
      image.className = 'img-fluid article-image col-md-3'; // Add a class for styling
      image.alt = 'Article Image';
      articleContainer.appendChild(image);

      // Create a div for header and article content (on the right)
      const headerContentWrapper = document.createElement('div');
      headerContentWrapper.className = 'header-content-wrapper mb-4';

      // Create the header element (centered)
      const header = document.createElement('h2');
      header.className = 'article-header'; // Add a class for centering
      header.textContent = post.postTitle; // Use the data from the API
      headerContentWrapper.appendChild(header);

      // Create the article content
      const paragraph = document.createElement('p');
      paragraph.textContent = post.postContent; // Use the data from the API
      headerContentWrapper.appendChild(paragraph);

      articleContainer.appendChild(headerContentWrapper);

      // Create the edit buttons and form here, similar to the existing ones
      const editButton = document.createElement('button');
      editButton.textContent = 'Edit';
      editButton.className = 'edit-button';
      // Add an event listener to handle the edit action (you'll need to define the edit function)
      editButton.addEventListener('click', () => {
        turnToEditForm(header, paragraph, editButton, index, posts); // Call a function to handle the edit action
      });
      headerContentWrapper.appendChild(editButton);

      // Optionally, add an even-odd class for styling
      if (index % 2 === 0) {
        articleContainer.classList.add('even-article');
      } else {
        articleContainer.classList.add('odd-article');
      }

      // Add the article container to the main container
      container.appendChild(articleContainer);
    });
  }

  // Function to turn header and paragraph into input fields
  function turnToEditForm(header, paragraph, editButton, index, posts) {
    const headerInput = document.createElement('input');
    headerInput.type = 'text';
    headerInput.value = header.textContent;
    headerInput.className = "headerEdit";
    header.replaceWith(headerInput);

    const paragraphInput = document.createElement('textarea');
    paragraphInput.value = paragraph.textContent;
    paragraphInput.className = "articleEdit";

    paragraph.replaceWith(paragraphInput);

    const editButtonContainer = document.createElement('div');
    editButtonContainer.className = "edit-button-container";

    const submitButton = document.createElement('button');
    submitButton.textContent = 'Submit';
    submitButton.id = "edit";
    submitButton.style.marginTop = "2%";
    submitButton.style.marginRight = "1%";
    submitButton.className = 'edit-button';
    editButtonContainer.appendChild(submitButton);

    const backButton = document.createElement('button');
    backButton.textContent = 'Back';
    backButton.className = 'edit-button';
    backButton.style.marginTop = "2%";
    backButton.style.marginRight = "1%";
    backButton.addEventListener('click', () => {
      headerInput.replaceWith(header);
      paragraphInput.replaceWith(paragraph);
      editButtonContainer.replaceWith(editButton);
    });
    editButtonContainer.appendChild(backButton);


    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.className = 'edit-button';
    deleteButton.style.marginTop = "2%";
    deleteButton.addEventListener('click', () => {
      console.log("delete")
      const postId = posts[index].postId; // Assuming that postId is the property that holds the post ID

      fetch('http://localhost:8080/post/v1/delete', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ postId }),
      });
      window.location.href = 'index.php';
    });
    editButtonContainer.appendChild(deleteButton);

    editButton.replaceWith(editButtonContainer);


    document.getElementById("edit").addEventListener('click', function () {

      try {
        // GET PARAGRAPH INDEX 
        const data = {
          header: headerInput.value,
          content: paragraphInput.value,
          index: posts[index].postId
        };

        // Convert the data object to JSON
        const jsonData = JSON.stringify(data);

        console.log("edit " + jsonData);

        // Make a POST request to your server
        fetch('http://localhost:8080/post/v1/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: jsonData,
        });
      } catch (error) {
        console.error("Error while converting to JSON:", error);
      }
      window.location.href = 'index.php';
    });
  }

  // UPDATE / SAVE
  document.getElementById("saveButton").addEventListener('click', function () {
    // Get the value from the input field
    let editedText = "";
    let data = {};
    if (elementToEdit === "header") {
      editedText = header.textContent;
      // Prepare the data to send in the request
      data = {
        editedText: editedText,
        editPart: "header"
      };
    } else if (elementToEdit === "paragraph") {
      editedText = articleText.textContent;
      // Prepare the data to send in the request
      data = {
        editedText: editedText,
        editPart: "paragraph"
      };
    }


    // Make a PUT request to your API
    fetch('http://localhost:8080/post/v1/update', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    })
  });



  function toggleEdit(elementToEditParam) {
    elementToEdit = elementToEditParam;
    if (elementToEdit === "header") {
      editInput.value = header.textContent;
      elementToEdit = "header";
    } else if (elementToEdit === "paragraph") {
      editInput.value = articleText.textContent;
      elementToEdit = "paragraph";
    }

    headerContainer.style.display = "none";
    articleTextContainer.style.display = "none";
    editForm.style.display = "inline-block";
  }

  function saveEdit() {
    if (elementToEdit === "header") {
      header.textContent = editInput.value;
      elementToEdit = "header";
    } else if (elementToEdit === "paragraph") {
      articleText.textContent = editInput.value;
      elementToEdit = "paragraph";
    }

    headerContainer.style.display = "block";
    articleTextContainer.style.display = "block";
    editForm.style.display = "none";
    editButton.style.display = "inline- block";
    editInput.value = "";
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