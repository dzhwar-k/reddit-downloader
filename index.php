<?php


if (count($_POST) > 0 && !is_null($_POST['url'])) {
  $page = file_get_contents($_POST['url']);
  preg_match_all("/((?<=\<meta\sproperty\=\"og:video\" content\=\")https?:\/\/\w+\.redgifs\.com\/\w+\.mp4)/i", $page, $out);
  var_dump($out);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reddit Downloader</title>
  <style>
    *,
    html,
    body {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-holder {
      border: 1px solid red;
      border-radius: 3px;
      padding: 10px;
      width: 50%;
    }

    form h2 {
      color: orangered;
      text-align: center;
      margin-bottom: 15px;
    }

    .form-control {
      margin: 5px 0;
      border: 2px solid #EEEEEE;
      border-radius: 2px;
    }

    .form-control input {
      border: none;
      outline: none;
      display: block;
      width: 100%;
      padding: 15px 5px;
    }

    button {
      cursor: pointer;
      margin-top: 7px;
      border-radius: 3px;
      border: none;
      outline: none;
      padding: 10px 20px;
      background-color: rgba(221, 10, 53, .8);
      transition: background-color 100ms ease-in-out;
      color: #FFF;
      font-weight: bold;
    }

    button:hover {
      background-color: rgba(221, 10, 53, 1)
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="form-holder">
      <form action="" method="post">
        <div>
          <h2>Reddit Downloader</h2>
        </div>

        <div class="form-control">
          <input type="url" name="url" placeholder="URL..">
        </div>

        <div>
          <button type="submit">Download</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>