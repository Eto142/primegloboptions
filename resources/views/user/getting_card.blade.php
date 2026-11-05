<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
<style>
  body {
    text-align: center;
    padding: 40px 0;
    background: #EBF0F5;
    font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
  }
  .card {
    background: white;
    padding: 60px;
    border-radius: 4px;
    box-shadow: 0 2px 3px #C8D0D8;
    display: inline-block;
    margin: 0 auto;
    max-width: 100%;
    box-sizing: border-box;
  }
  h1 {
    color: skyblue;
    font-weight: 900;
    font-size: 40px;
    margin-bottom: 10px;
  }
  p {
    color: #404F5E;
    font-size: 20px;
    margin: 0;
  }
  .spinner {
    border: 5px solid rgba(0, 0, 0, 0.1);
    border-left-color: #333;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  @media only screen and (min-width: 768px) {
    .card {
      max-width: 500px;
    }
  }
</style>
</head>
<body>
  <div class="card">
    <div class="spinner"></div>
    {{-- <h1>100%</h1> --}}
    <p>Card <b style="color: blue">is under review</b></p>
    <p>Please wait.... Redirecting in seconds</p>
  </div>

  <script>
    var timer = setTimeout(function() {
        window.location='../card'
    }, 3000);
  </script>
</body>
</html>
