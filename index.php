<!DOCTYPE html>
<html>
<head>
  <title>ShortestURL - Redirect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .container {
      text-align: center;
      max-width: 400px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      font-size: 48px;
      margin-bottom: 30px;
      color: #007bff;
    }
    .error-message {
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 id="countdown">10</h1>

    <div id="redirect-message">
      <p>Redirecting to the original URL...</p>
    </div>

    <div id="error-message" class="d-none">
      <p class="error-message">URL not found.</p>
    </div>
  </div>

  <script>
    var id = getUrlParameter('g');

    // Read the links.txt file
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'https://php-api.shortesturl.repl.co/links.txt', true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var fileContent = xhr.responseText;
        var lines = fileContent.split('\n');

        // Search for the matching original URL based on the ID
        var originalUrl = '';
        for (var i = 0; i < lines.length; i++) {
          var parts = lines[i].split(': ');
          if (parts[0] === id) {
            originalUrl = parts[1];
            break;
          }
        }

        if (originalUrl !== '') {
          // Update countdown and redirect after 10 seconds
          var countdownElement = document.getElementById('countdown');
          var countdown = 10;

          var countdownInterval = setInterval(function() {
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
              clearInterval(countdownInterval);
              window.location.href = originalUrl;
            }
            countdown--;
          }, 1000);
        } else {
          // Display error message
          document.getElementById('redirect-message').classList.add('d-none');
          document.getElementById('error-message').classList.remove('d-none');
        }
      }
    };
    xhr.send();

    function getUrlParameter(name) {
      name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
      var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
      var results = regex.exec(location.search);
      return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
  </script>
</body>
</html>
