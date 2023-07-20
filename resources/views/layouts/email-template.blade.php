<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Jakarta Trading</title>

  <style>
    .logo-img{
      height: "60px";
    }

    .content-card{
      text-align: center; 
      background-color: white; 
      border-radius: 5px;
      padding: 8px;
      margin: 0 150px;
    }

    .content-card p{
      margin-bottom: 0;
    }

    @media only screen and (max-width: 600px) {
      .logo-img{
        height: "50px";
      }
      .content-card{
        margin: 0 5px;
      }
      .content-card p{
        margin-bottom: 5px;
      }
    }
  </style>
</head>

<body style="padding: 30px; background-color: #edf2f7;">
  <div style="text-align: center; margin-bottom: 15px">
    <img class="logo-img" src="https://jakartatrading.my.id/logo/logo1.png" alt="">
  </div>
  
  <div class="content-card">
    <p>Akses kode OTP {{ env('APP_NAME') }} dashboard:</p>
    <h2 style="margin-top: 0">{{ $otp_code }}</h2>
  </div>
</body>

</html>