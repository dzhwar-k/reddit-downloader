<?php
if (count($_POST) > 0 && !is_null($_POST['url'])) {

  if (strpos($_POST['url'], 'redgifs.com')) {
    $page = file_get_contents($_POST['url']);
    preg_match_all("/(?<=\<meta\sproperty\=\"og:video\" content\=\")https?:\/\/\w+\.redgifs\.com\/\w+\.mp4/i", $page, $out);
    if (count($out) == 0) {
      $error = "link not found";
    } else {
      $url = $out[0][0];
      $video = file_get_contents($url);
      file_put_contents('video.mp4', $video);
    }
  } else if (strpos($_POST['url'], 'reddit.com')) {
    $url = rtrim(json_decode(file_get_contents(
      substr($_POST['url'], 0, strrpos($_POST['url'], "/")) . '.json'
    ))[0]->data->children[0]->data->secure_media->reddit_video->fallback_url, "?source=fallback");

    $video = file_get_contents($url);
    file_put_contents('video.mp4', $video);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" type="image/png" sizes="32x32" href="https://www.redditstatic.com/desktop2x/img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="96x96" href="https://www.redditstatic.com/desktop2x/img/favicon/favicon-96x96.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="https://www.redditstatic.com/desktop2x/img/favicon/favicon-16x16.png" />
  <meta charset="UTF-8">
  <meta name="author" content="Muhammed Kamaran">
  <meta name="description" content="developed by Muhammed Kamaran">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reddit Video Downloader</title>
  <link rel="icon" type="image/x-icon" href="https://avatars.githubusercontent.com/u/63434176?v=4">
  <style>
    *,
    html,
    body {
      padding: 0;
      font-family: sans-serif;
      margin: 0;
      box-sizing: border-box;
    }

    .container {
      margin: 0 auto;
      height: 100vh;
      display: flex;
      justify-content: flex-start;
      align-items: center;
    }

    .form-holder {
      /* border: 1px solid RGBA(255, 86, 0, 1); */
      border-radius: 3px;
      padding: 10px;
      width: 30%;
      background-color: #FFF;
    }

    .title-holder {
      display: flex;
      justify-content: center;
    }

    form h2 {
      color: RGBA(255, 86, 0, 1);
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 2px solid #EEEEEE;
      display: inline-block;

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
      background-color: RGBA(255, 86, 0, .7);
      transition: background-color 100ms ease-in-out;
      color: #FFF;
      font-weight: bold;
    }

    .url-info p {
      font-weight: bold;
      padding: 5px 0;
    }

    button:hover {
      background-color: RGBA(255, 86, 0, 1);
    }

    .left-side {
      order: 1;
      background-image: url("dog.jpg");
      background-position: center;
      background-size: cover;
      height: 100vh;
      width: 70%;
      box-shadow: -1px -4px 8px #000;
    }

    input:focus::placeholder {
      position: relative;
      top: -8px;
    }

    @media all and (max-width: 700px) {
      .container {
        flex-wrap: wrap;
        flex-direction: column;
      }

      .container>div {
        width: 100%;
        height: 50vh;
        box-shadow: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">

    <div class="left-side"></div>

    <div class="form-holder">
      <form action="" method="post">
        <div class="title-holder">
          <p><?= isset($error) ? $error : ''; ?></p>
          <h2>Reddit Video Downloader</h2>
        </div>

        <div class="form-control">
          <input type="url" name="url" placeholder="URL..">
        </div>

        <?php if (isset($url)) : ?>
          <div class="url-info">
            <p><small><b>URL: </b><?= $url ?></small></p>
          </div>
        <?php endif; ?>

        <div>
          <button type="submit">Download</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
<?php

if (isset($url)) {
  $filename = "video.mp4";

  header("Content-Type: video/mp4");
  header('Content-Disposition: attachment; filename="' . $filename . '"');
  header('Content-Length: ' . filesize($filename));
  header("Content-Transfer-Encoding: binary\n");
  ob_clean();

  readfile($filename);
  unlink($filename);
}
