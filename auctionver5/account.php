<?php
    include('connect_to_pms.php');
    $_SESSION['redirect']="account.php";
    if(!isset($_SESSION['userId'])){
        include('homepageparent.php');
        echo "<center><h1>Please Log in!</h1></center>";
        return;
    }
    else{ 
        $user = $_SESSION['userId'];
        include('accessgrantedparent.php');
        $get_bidder = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Bidders 
                                                        INNER JOIN tbl_Cities
                                                        ON tbl_bidders.bidder_city = tbl_Cities.city_ID
                                                        INNER JOIN tbl_Provinces
                                                        ON tbl_cities.province_ID = tbl_Provinces.province_ID
                                                        WHERE bidder_ID = $user"));
        $bidder_firstname = $get_bidder['bidder_firstname'];
        $bidder_middlename = $get_bidder['bidder_middlename'];
        $bidder_lastname = $get_bidder['bidder_lastname'];
        $bidder_province = $get_bidder['province_name'];
        $provincecode = $get_bidder['province_ID'];
        $bidder_city = $get_bidder['city_name'];
        $citycode = $get_bidder['city_ID'];
        $bidder_barangay = $get_bidder['bidder_barangay'];
        $bidder_street = $get_bidder['bidder_street'];
        $bidder_housenumber = $get_bidder['bidder_housenumber'];
        $bidder_contact = $get_bidder['bidder_contact'];
        $bidder_email = $get_bidder['bidder_email'];
    }
?>

<script type="text/javascript" src="admin/getCity.js"></script>
<script type="text/javascript" src="admin/validation.js"></script>
    <div class="black divider"></div><div id="listingcontainer" class="container myfont center row-width2">
        <div class="row card blue-grey lighten-4"> <!-- AS A WHOLE -->
            <div class="col l12 m12">
                <br><h4><center>ACCOUNT INFORMATION</center></h4>
                <div class="black divider"></div>
                    <form method="POST" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row myfont">
            <div class="input-field col l4 m4 s12">
                <input name="firstname" id="firstname" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'firstname')" value="<?php echo $bidder_firstname?>" REQUIRED>
                <label for="firstname">First Name</label>
            </div>
            <div class="input-field col l4 m4 s12">
                <input name="middlename" id="middlename" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'middlename')" value="<?php echo $bidder_middlename?>">
                <label for="middlename">Middle Name</label>
            </div>
            <div class="input-field col l4 m4 s12">
                <input name="lastname" id="lastname" type="text" class="validate"  onkeyup = "validateTextOnly(this.value,'lastname')" value="<?php echo $bidder_lastname?>" REQUIRED>
                <label for="lastname">Last Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l4 m4 s12">
                <input name="housenumber" id="housenumber" type="text" class="validate" onkeyup = "validateNoSpecs(this.value,'housenumber')" value="<?php echo $bidder_housenumber?>" REQUIRED>
                <label for="housenumber">House Number</label>
            </div>
            <div class="input-field col l4 m4 s12">
                <input name="street" id="street" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'street')" value="<?php echo $bidder_street?>" REQUIRED>
                <label for="street">Street</label>
            </div>
            <div class="input-field col l4 m4 s12">
                <input name="barangay" id="barangay" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'barangay')"value="<?php echo $bidder_barangay?>" REQUIRED>
                <label for="barangay">Barangay</label>
            </div>

        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select class="browser-default" name='province' id='province' onchange="setCity(this.value)" value="<?php echo $provincecode?>" REQUIRED>
                    <option value = "" selected disabled>Select Province:</option>
                    <?php
                        $get = mysql_query("SELECT * FROM tbl_Provinces ORDER BY province_name ASC");
                        if(!mysql_num_rows($get)==0){
                            while($get_row = mysql_fetch_assoc($get)){
                            ?><option value = "<?php echo $get_row['province_ID']; ?>"><?php echo $get_row['province_name']; ?></option>
                        <?php
                            }
                        }
                    ?>
                </select>
                <label class="black-text active" for="itemid">Province</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="browser-default" name='city' id='delivery_city' value="<?php echo $citycode?>" REQUIRED>
                        <option value="" selected disabled>Select City</option> 
                            <?php
                            $get = mysql_query("SELECT * FROM tbl_Cities ORDER BY city_name ASC");
                            if(!mysql_num_rows($get)==0){
                                while($get_row = mysql_fetch_assoc($get)){
                                ?><option value = "<?php echo $get_row['city_ID']; ?>"><?php echo $get_row['city_name']; ?></option>
                            <?php
                                }
                            }
                        ?>
                </select>

                <label class="black-text active" for="itemid">City</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m6 s12">
                <input name="contact" id="contact" type="text" class="validate" maxlength="11" onkeyup = "validateNumberOnly(this.value,'contact')" value="<?php echo $bidder_contact?>" REQUIRED>
                <label for="contact">Contact Number</label>
            </div>
            <div class="input-field col l6 m6 s12">
                <input name="email" id="email" type="email" class="validate" value="<?php echo $bidder_email?>" REQUIRED>
                <label for="email">Email Address</label>
            </div>
        </div>

        
        <div class="row" >
            <div class="col s12">
                <button class="btn black white-text waves-effect waves-light right" type="submit" name="submit">Update
                </button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        document.getElementById("province").value = "<?php echo $provincecode?>";
        setCity(<?php echo $provincecode?>);
        document.getElementById("delivery_city").value = "<?php echo $citycode?>";
    </script>
<?php
    if(isset($_POST['submit'])){
        echo "shit";
        $firstname = ucwords(strtolower(trim($_POST['firstname'])));
        $middlename = ucwords(strtolower(trim($_POST['middlename'])));
        $lastname = ucwords(strtolower(trim($_POST['lastname'])));
        $province = trim($_POST['province']);
        $city = trim($_POST['city']);
        $barangay = ucwords(strtolower(trim($_POST['barangay'])));
        $street = ucwords(strtolower(trim($_POST['street'])));
        $housenumber = ucwords(strtolower(trim($_POST['housenumber'])));
        $contact = trim($_POST['contact']);
        $email = trim($_POST['email']);

        $sql = "UPDATE tbl_Bidders SET bidder_firstname = '$firstname',bidder_middlename = '$middlename',bidder_lastname = '$lastname',bidder_province = '$province',bidder_city = '$city',bidder_barangay = '$barangay',bidder_street = '$street',bidder_housenumber = '$housenumber',bidder_contact = '$contact',bidder_email = '$email' WHERE bidder_ID = $user";
        $res = mysql_query($sql) or die("Error in Query: ".mysql_error());

        echo "
            <script>
            window.location.href = 'account.php';
            alert('Information Updated!');
            </script>
        ";
    }

?>