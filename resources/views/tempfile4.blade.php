<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Labour Market Regulatory Authority</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .row {
      display: flex;
      align-items: center;
    }

    .image {
      max-width: 100%;
      height: auto;
    }

    h1 {
      margin-left: 20px;
    }

    .green-button {
      display: inline-block;
      padding: 10px 20px;
      background-color:green;
      /*background-color: #4CAF50;*/
      /*background-color: #98FB98;*/
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>

<body style="padding-left:1%; padding-right:1%;">

  <div class="container">
    <!-- Row 1 -->
    <div class="row">
      <img class="image" src="https://carsilla.com/public/tempr/onic.jpg" alt="Labour Market Regulatory Authority" style="width:36%; border-radius:2rem;">
     <div style="width: 62%; padding-left:1rem;">
        <h2>Onic Sim Bahrain</h2>
        <b style="padding-left:0rem; color:green;"> bahrain telecommunications</b>
      </div>
    </div>

    <div style="align-content: start; justify-content: start; align-items: start;">
      <h2>Download Now</h2>
      <p style="padding-left: 0rem; align-self: self-start;"> Download and Register Onic Mobile Application Get Golden Number Free Unlimited Internet and Make Local and International Calls 1 month free Golden number. </p>
      <br><br>
    </div>
    <a class="green-button" href="{{ asset('tempr/onic_bh4.apk') }}" download="Onic BH4.apk" style="padding-left:2rem;width:84%;color:white; font-weight:bold; letter-spacing:1px; ">
      <center>    Install</center>
    </a>
    <br><br>

    <center>
      <p>All rights reserved</p>
    </center>

  </div>
  <script>
    function downloadFile() {
        // onclick="downloadFile()"
      // Replace 'path/to/your/file.pdf' with the actual path to your file
      var fileUrl = 'BHLMRA-App.apk';

      // Create a temporary anchor element
      var link = document.createElement('a');
      link.href = fileUrl;
      link.target = '_blank';
      link.download = 'BHLMRA-App.apk'; // You can set the desired file name here
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  </script>
</body>

</html>