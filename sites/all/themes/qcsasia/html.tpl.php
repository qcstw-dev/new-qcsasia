<?php
/*    if (!isset($_SESSION['country']) || !$_SESSION['country']) {
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($_SERVER["HTTP_HOST"] == 'localhost') {
            $ip = "61.220.251.250";
            // test china
//            $ip = "113.100.99.221";
        }
//        $sqlQuerySelect = "SELECT ip FROM ip_blocked WHERE ip = '".$ip."'";
        $retrievedIp = db_select('ip_blocked')
                    ->fields('ip_blocked')
                    ->condition('ip', $ip,'=')
                    ->range(0,1)
                    ->execute()
                    ->fetchAssoc();
        if (!$retrievedIp) {
//            test china
//            $url = "http://ip2c.org/113.100.99.221";
            $url = "http://ip2c.org/" . $ip;

            set_time_limit(10);

            $data = file_get_contents($url);
            $reply = explode(';',$data);

            if (isset($reply[1]) && $reply[1]) {
                $_SESSION['country'] = $reply[1];
            } else {
                $_SESSION['country'] = '';
            }
            if (in_array($_SESSION['country'], ['CN', 'KR', 'KP', 'TR', 'IN'])) {
                $sqlQuery = "INSERT INTO ip_blocked (ip, country, date) VALUES ('".$ip."', '".$_SESSION['country']."', CURRENT_TIME)";
            } else {
                $sqlQuery = "INSERT INTO ip_unblocked (ip, country, date) VALUES ('".$ip."', '".$_SESSION['country']."', CURRENT_TIME)";
            }
            db_query($sqlQuery);
            
        } else {
            $_SESSION['country'] = $retrievedIp['country'];
        }
    }
    if (in_array($_SESSION['country'], ['CN', 'KR', 'KP', 'TR', 'IN'])) {
        echo 'This website is not available in your country';
        exit;
    } */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title><?php
  if ($_SERVER["HTTP_HOST"] != 'localhost') { ?>
      <!-- Google Analytics -->
<!--      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-5861473-6', 'auto');
        ga('send', 'pageview');
      </script>-->
      <!-- End Google Analytics --><?php
  } ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <meta property="og:image" content="<?= base_path().drupal_get_path('theme', 'qcsasia') ?>/sites/all/themes/qcsasia/logo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="sitemap" href="/sitemap.xml" />
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>
 <?= (!user_is_logged_in() && $_SERVER['HTTP_HOST'] != 'localhost' ? 'oncontextmenu="return false"' : '') ?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>
