<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
  /* The side navigation menu */
  .sidenav {
    padding-top: 60px;
    position: fixed;
    background-color: #111;
    top: 0;
    overflow-x: hidden;
    height: 100%;
    left: 0;
    transition: 0.5s;
    width: 250px;

  }

  .sidenav a,
  .sidenav div {

    text-decoration: none;
    padding: 8px 8px 8px 32px;
    display: block;
    color: #818181;
    transition: 0.3s;
    font-size: 25px;
  }

  .sidenav a:hover,
  .sidenav div:hover {
    color: #f1f1f1;
  }

  #main {

    padding: 20px;
    transition: margin-left .5s;
  }
</style>

<div id="sideNavbar" class="sidenav">
  <a href="<?php echo base_url('index.php/page/post') ?>">Home</a>
  <a href="<?php echo base_url('index.php/page/profile') ?>">Profile</a>
  <div onclick="onLogout()">Logout</div>
</div>

<script>
  function onLogout() {
    sessionStorage.clear();
    window.location = '<?php echo base_url('index.php/page/login') ?>';
  }
</script>