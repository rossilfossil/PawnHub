<?php
    include('connect_to_pms.php');
    if(isset($_SESSION['branchId'])){
      echo "
          <script>
          window.location.href = 'admin/dashboard.php';
          </script>
        ";    
    }
    if(isset($_SESSION['userId'])){
        echo "
          <script>
              window.location.href = 'home.php';
          </script>
        ";
    }
    include('homepageparent.php');
?>
<link rel="stylesheet" type="text/css" href="css/mycss.css">

  <div class="black slider">
    <ul class="slides">
      <li>
        <img src="homepage/slide1.jpg"> <!-- random image -->
        <div class="black-text caption center-align">
          <!-- <h3>This is our big Tagline!</h3> -->
          <!-- <h5>Here's our small slogan.</h5> -->
        </div>
      </li>
      <li>
        <img src="homepage/slide2.jpg"> <!-- random image -->
        <div class="black-text caption left-align">
          <!-- <h3>Left Aligned Caption</h3> -->
          <!-- <h5>Here's our small slogan.</h5> -->
        </div>
      </li>
      <li>
        <img src="homepage/slide3.jpg"> <!-- random image -->
        <div class="black-text caption right-align">
          <!-- <h3>Right Aligned Caption</h3> -->
          <!-- <h5>Here's our small slogan.</h5> -->
        </div>
      </li>
      <li>
        <img src="homepage/slide4.jpg"> <!-- random image -->
        <div class="black-text caption center-align">
          <!-- <h3>This is our big Tagline!</h3> -->
          <!-- <h5>Here's our small slogan.</h5> -->
        </div>
      </li>
    </ul>

<div class="parallax-container">
    <div class="parallax">

  </div>

    </div>
</div>


<div class="section black">
    <div class="row container">
        <p class="header" ><center><label style="color:whitesmoke; font-size:120%;">  B I D &nbsp;&nbsp; A U T H E N T I C &nbsp;&nbsp; I T E M S &nbsp;&nbsp; F R O M &nbsp;&nbsp; P A W N S H O P</label></center></p>    
            <div class="row">
                <div class="col l4 s12">
                    <div class="card small">
                        <div class="card-image">
                            <img src="homepage/camera.jpg">
                            <span class="card-title black-text myfont"><b>BIDDING RULES</b></span>
                        </div>
                        <div class="card-content myfont">
                            <p><center>Register and you're ready to bid on our items. </center></p>
                        </div>
                    </div>
                </div>
                <div class="col l4 s12">
                    <div class="card small">
                        <div class="card-image">
                            <img src="homepage/rings.jpg">
                            <span class="card-title black-text myfont"><b>PRE-LOVED ITEMS</b></span>
                        </div>
                        <div class="card-content myfont">
                            <p><center>Get pre-loved items forfeited from our pawnshop.</center></p>
                        </div>
                    </div>
                </div>
                <div class="col l4 s12">
                    <div class="card small">
                        <div class="card-image">
                            <img src="homepage/laptop.jpg">
                            <span class="card-title black-text myfont"><b>ITEM CAUGHT YOUR EYES?</b></span>
                        </div>
                        <div class="card-content myfont" >
                            <p><center><a class="black-text" href="home.php">Bid from your comfort zone!</a></center></p>
                        </div>                                    
                    </div>
                </div>
            </div>
</div></div>


<div class="parallax-container">
    <div class="parallax"><img src="homepage/auction1.jpg"></div>
</div>
<div class="section gray ">
    <div class="container myfont" id="about" >
        <center>
            <h5><b>About</b></h5>
            <h6>Thousands of happy customers have already gotten cash for their pre-loved items</h6>
            <h6>It's safe, fast and convenient.</h6>
            <h6>We accept just about everything.</h6>
        </center>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

$('.parallax').parallax();
}); 

    $(document).ready(function(){
      $('.slider').slider({
        full_width: true,
        height :550,
    });
    });
</script>
