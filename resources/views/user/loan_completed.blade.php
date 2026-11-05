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

  .good-sign {
    display: none;
    margin-top: 20px;
    animation: fadeIn 1s ease-in-out forwards;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0.5);
    }
    to {
      opacity: 1;
      transform: scale(1);
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
    <div class="good-sign">
      <svg
        fill="#0a5c5c"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        width="48px"
        height="48px"
        style="animation: fadeIn 1s ease-in-out forwards;"
      >
        <path fill="none" d="M0 0h24v24H0z"/>
        <path d="M9 16.2l-3.5-3.5 1.4-1.4L9 13.4l6.6-6.6 1.4 1.4z"/>
      </svg>
    </div>
    <p>Loan <b style="color: blue">is under review</b></p>
    <p>Please wait.... Redirecting in seconds</p>
  </div>

  <script>
    setTimeout(function() {
      document.querySelector('.spinner').style.display = 'none';
      document.querySelector('.good-sign').style.display = 'block';
      setTimeout(function() {
        window.location='../dashboard';
      }, 3000);
    }, 3000);
  </script>
</body>
</html>
