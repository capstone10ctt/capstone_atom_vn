<?php echo $header; ?>
 <!--<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php if($breadcrumb == end($breadcrumbs)){ ?>
    <a class="last" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php }else{ ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><span><?php echo $breadcrumb['text']; ?></span></a>
    <?php } ?>
    <?php } ?>
</div>-->
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php //echo $column_left; ?><?php //echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
 <div class="register_fr">
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_account_already; ?></p>
  <form class="register" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="left">
  <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form">
    <tr>
          <td><?php echo $entry_fullname; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="text" name="fullname" value="<?php echo $fullname; ?>" />
            <?php if ($error_fullname) { ?>
            <span class="error"><?php echo $error_fullname; ?></span>
            <?php } ?></td>
        </tr>


    <!--
        <tr>
          <td><?php echo $entry_firstname; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
            <?php if ($error_firstname) { ?>
            <span class="error"><?php echo $error_firstname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td> <?php echo $entry_lastname; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
            <?php if ($error_lastname) { ?>
            <span class="error"><?php echo $error_lastname; ?></span>
            <?php } ?></td>
        </tr>-->



        <tr>
          <td> <?php echo $entry_gender; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><select name="gender_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($genders as $gender) { ?>
              <?php if ($gender['gender_id'] == $gender_id) { ?>
              <option value="<?php echo $gender['gender_id']; ?>" selected="selected"><?php echo $gender['gender']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $gender['gender_id']; ?>"><?php echo $gender['gender']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_gender) { ?>
            <span class="error"><?php echo $error_gender; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td> <?php echo $entry_email; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td> <?php echo $entry_telephone; ?><span class="required">*</span></td>
    </tr>
        <tr>
          <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
            <?php if ($error_telephone) { ?>
            <span class="error"><?php echo $error_telephone; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td> <?php echo $entry_date_of_birth; ?><span class="required">*</span></td>
    </tr>

    <tr>
    <td>





<form method="post">
<div class="banana" style="width:115px; min-width:115px; display: inline-block">
<select name="datebirth" type="text" class="scroll" id="datebirth width="115" style="width: 115px"">
  <option value=0 <?php echo ($datebirth == 0) ? ' selected="selected"' : ''; ?>>Ngày</option>
  <?php
    for($i=1; $i<=31; $i++) {
        if ($datebirth == $i){
        echo '<option value='.$i.' selected="selected">'. $i .'</option>';
        }
        else {
         echo '<option value='.$i.'>'. $i .'</option>'; 
        }
    }
    ?>
</select>
</div>

<div class="banana" style="width:115px; min-width:115px; display: inline-block">
<select name="monthbirth" type="text" class="scroll" id="monthbirth" width="115" style="width: 115px">
  <option value=0 <?php echo ($monthbirth == 0) ? ' selected="selected"' : ''; ?>>Tháng</option>
  <?php
    for($i=1; $i<=12; $i++) {
        if ($monthbirth == $i){
        echo '<option value='.$i.' selected="selected">'. $i .'</option>';
        }
        else {
         echo '<option value='.$i.'>'. $i .'</option>'; 
        }
    }
    ?>
</select>
</div>

<div class="banana" style="width:115px; min-width:115px; display: inline-block">
<select name="yearbirth" type="text" class="scroll" id="yearbirth width="115" style="width: 115px"">
  <option value=0 <?php echo ($yearbirth == 0) ? ' selected="selected"' : ''; ?>>Năm</option>
  <?php
    for($i=2000; $i>=1950; $i--) {
        if ($yearbirth == $i){
        echo '<option value='.$i.' selected="selected">'. $i .'</option>';
        }
        else {
         echo '<option value='.$i.'>'. $i .'</option>'; 
        }
    }
    ?>
</select>
</div>

<?php if ($error_date_of_birth) { ?>
            <span class="error"><?php echo $error_date_of_birth; ?></span>
            <?php } ?>
</form>

<!--
          <input type="text" name="date_of_birth" value="<?php echo $date_of_birth; ?>" />
            <?php if ($error_telephone) { ?>
            <span class="error"><?php echo $error_date_of_birth; ?></span>
            <?php } ?>
-->
        </td>
        </tr>
        <tr>
          <td> <?php echo $entry_ethnic; ?><span class="required" >*</span></td>
    </tr>
    <tr>
          <td><input type="text" name="ethnic" value="<?php echo $ethnic; ?>" />
            <?php if ($error_ethnic) { ?>
            <span class="error"><?php echo $error_ethnic; ?></span>
            <?php } ?></td>
        </tr>
        <!--<tr>
          <td><?php echo $entry_fax; ?></td>
    </tr>
    <tr>
          <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
        </tr>-->
      
    <!-- /////////// END “you-id” - “your-name” modifications/////////////
        /////////////////////// Modification//////////////////////
        //       ID: 1051018          
        //       Name: Tran Thanh Toan          
        //   Class: 10CTT 
        //   Date 1/1/2014
        //   Description: add textbox password
        //   Date modified: 1/1/2014 
        //   Last updated: list the change by line number and goal, ex: 
        //     + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications///////////// -->
    




      <tr>
        <td> 
        <?php echo $text_your_address1; ?>
        </td>
        </tr>
        <tr>
          <td> 
            <!-- kah2914
             <div class="banana" style="width:45px; min-width:45px; display: inline-block"> <?php echo $entry_address_0; ?><span class="required" >*</span> </div>
             -->
             <div class="banana" style="width:120px; min-width:120px; display: inline-block"> <?php echo $entry_address_1; ?><span class="required" >*</span> </div>
             <div class="banana" style="width:45px;min-width:45px; display: inline-block"> <?php echo $entry_address_2; ?><span class="required" >*</span> </div>
             <div class="banana" style="width:45px;min-width:45px; display: inline-block"> <?php echo $entry_address_3; ?><span class="required" >*</span> </div>
             <div class="banana" style="width:90px;min-width:90px; display: inline-block"> <?php echo $entry_address_4; ?><span class="required" >*</span> </div>             
          </td>          
        </tr>

        <tr>
          <td >
          <!-- kah2914
            <div class="banana" style="width:45px; min-width:45px; display: inline-block">
              <input type="text" style="width:45px;" name="address_0" value="<?php echo $address_0; ?>" />              
            </div>
            -->

            <div class="banana" style="width:120px; min-width:120px; display: inline-block">
              <input type="text" style="width:120px;" name="address_1" value="<?php echo $address_1; ?>" />
              
            </div>

            <div class="banana" style="width:45px; min-width:45px; display: inline-block">
              <input type="text" style="width:45px;" name="address_2" value="<?php echo $address_2; ?>" />
              
            </div>

            <div class="banana" style="width:45px; min-width:45px; display: inline-block">
              <input type="text" style="width:45px;" name="address_3" value="<?php echo $address_3; ?>" />
              
            </div>

            <div class="banana" style="width:90px; min-width:90px; display: inline-block">     
                <select name="address_4" width="90" style="width: 90px">              
                  </select>                         
            </div>
          </td>
        </tr>
      
         <tr>
         <td>
         <!-- kah2914
         <div><?php if ($error_address_0) { ?>
              <span class="error"><?php echo $error_address_0; ?></span>
              <?php } ?></div>
              -->

          <div><?php if ($error_address_1) { ?>
              <span class="error"><?php echo $error_address_1; ?></span>
              <?php } ?></div>

          <div><?php if ($error_address_2) { ?>
              <span class="error"><?php echo $error_address_2; ?></span>
              <?php } ?></div>

          <div><?php if ($error_address_3) { ?>
              <span class="error"><?php echo $error_address_3; ?></span>
              <?php } ?></div>

          <div><?php if ($error_address_4) { ?>
              <span class="error"><?php echo $error_address_4; ?></span>
              <?php } ?></div>
         
         </td>        
         </tr>
    

      <tr>
       <td>         
    <?php echo $text_your_address2; ?>
         </td>        
         </tr>
        <tr>
          <td> 
            <!--kah2914
             <div class="banana" style="width:45px; min-width:45px; display: inline-block"> <?php echo $entry_address_5; ?><span class="required" >*</span> </div>
             -->
             <div class="banana" style="width:120px; min-width:120px; display: inline-block"> <?php echo $entry_address_6; ?> </div>
             <div class="banana" style="width:45px;min-width:45px; display: inline-block"> <?php echo $entry_address_7; ?> </div>
             <div class="banana" style="width:45px;min-width:45px; display: inline-block"> <?php echo $entry_address_8; ?> </div>
             <div class="banana" style="width:90px;min-width:90px; display: inline-block"> <?php echo $entry_address_9; ?> </div>             
          </td>          
        </tr>

        <tr>
          <td >
          <!--kah2914
            <div class="banana" style="width:45px; min-width:45px; display: inline-block">
              <input type="text" style="width:45px;" name="address_5" value="<?php echo $address_5; ?>" />
              
            </div>
            -->

            <div class="banana" style="width:120px; min-width:120px; display: inline-block">
              <input type="text" style="width:120px;" name="address_6" value="<?php echo $address_6; ?>" />
              
            </div>

            <div class="banana" style="width:45px; min-width:45px; display: inline-block">
              <input type="text" style="width:45px;" name="address_7" value="<?php echo $address_7; ?>" />
              
            </div>

            <div class="banana" style="width:45px; min-width:45px; display: inline-block">
              <input type="text" style="width:45px;" name="address_8" value="<?php echo $address_8; ?>" />
              
            </div>

            <div class="banana" style="width:90px; min-width:90px; display: inline-block">
                <select name="address_9" width="90" style="width: 90px">              
                  </select>                      
              
            </div>
          </td>
        </tr>
      
         <tr>
         <td>
         <!--kah2914
         <div><?php if ($error_address_5) { ?>
              <span class="error"><?php echo $error_address_5; ?></span>
              <?php } ?></div>
              

          <div><?php if ($error_address_6) { ?>
              <span class="error"><?php echo $error_address_6; ?></span>
              <?php } ?></div>

          <div><?php if ($error_address_7) { ?>
              <span class="error"><?php echo $error_address_7; ?></span>
              <?php } ?></div>

          <div><?php if ($error_address_8) { ?>
              <span class="error"><?php echo $error_address_8; ?></span>
              <?php } ?></div>

          <div><?php if ($error_address_9) { ?>
              <span class="error"><?php echo $error_address_9; ?></span>
              <?php } ?></div>
         -->
         </td>
         </tr>

<!-- kah2914 -->  
  <tr>
    <td>
    <h2 for="captcha">Captcha</h2>
    </td>
  </tr>    
  <tr>
    <td>
    <input type="text" name="txtCaptcha" value="" />      
    </td>    
  </tr>
  <tr>
    <td>
      <img id="imgCaptcha" src=<?php echo '"';?><?php echo ($url);?><?php echo "/catalog/controller/account/create_image.php";?> <?php echo '"'; ?>/>
    </td>
  </tr>  
  <tr>
  <td>  
  <?php if ($error_txtCaptcha) { ?>
            <span class="error"><?php echo $error_txtCaptcha; ?></span>
            <?php } ?>
  </td>
  </tr>  
<!-- kah2914 -->


        <!-- start -->
    <!--        
    <tr>
          <td> <?php echo $entry_city; ?><span class="required">*</span></td>
    </tr>
        <tr>
          <td><input type="text" name="city" value="<?php echo $city; ?>" />
            <?php if ($error_city) { ?>
            <span class="error"><?php echo $error_city; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
    </tr>
    <tr>
          <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" />
            <?php if ($error_postcode) { ?>
            <span class="error"><?php echo $error_postcode; ?></span>
            <?php } ?></td>
        </tr>-->
        
        <!-- end -->
        
        <!--<tr>
          <td> <?php echo $entry_country; ?><span class="required">*</span></td>
    </tr>-->
    <tr>
          <td><select name="country_id" style="display:none;"><!-- kah2914 : mình thêm style="display:none;" để dấu cái selectbox-->
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_country) { ?>
            <span class="error"><?php echo $error_country; ?></span>
            <?php } ?></td>
        </tr>
        <!--<tr>
          <td> <?php echo $entry_zone; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><select name="zone_id">
            </select>
            <?php if ($error_zone) { ?>
            <span class="error"><?php echo $error_zone; ?></span>
            <?php } ?></td>
        </tr>-->
      </table>
    </div>
    







    
    <!-- end -->
    
  </div>
    <div class="right">
  <h2><?php echo $text_your_studentinfo; ?></h2>
    <div class="content">
      <table class="form">
      
      <!-- start -->
       <!-- <tr>
          <td><?php echo $entry_company; ?></td>
    </tr>
    <tr>
          <td><input type="text" name="company" value="<?php echo $company; ?>" /></td>
        </tr>        
        <tr style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;">
          <td><?php echo $entry_customer_group; ?></td>
          <td><?php foreach ($customer_groups as $customer_group) { ?>
            <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
            <?php } else { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
            <?php } ?>
            <?php } ?></td>
        </tr>      
        <tr id="company-id-text">
          <td><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?></td>
    </tr>
    <tr  id="company-id-display">
          <td><input type="text" name="company_id" value="<?php echo $company_id; ?>" />
            <?php if ($error_company_id) { ?>
            <span class="error"><?php echo $error_company_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr id="tax-id-display">
          <td><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?></td>
          <td><input type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
            <?php if ($error_tax_id) { ?>
            <span class="error"><?php echo $error_tax_id; ?></span>
            <?php } ?></td>
        </tr>-->
        
        <!-- end -->
        
        <!-- /////////// END “you-id” - “your-name” modifications/////////////
        /////////////////////// Modification//////////////////////
        //       ID: 1051018          
        //       Name: Tran Thanh Toan          
        //   Class: 10CTT 
        //   Date 1/1/2014
        //   Description: update student id for NK (NK+ iddb)
        //   Date modified: 1/1/2014 
        //   Last updated: list the change by line number and goal, ex: 
        //     + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications///////////// -->
        <!--<tr>
          <td> <?php echo $entry_university; ?><span class="required">*</span></td>
    </tr>-->
    <tr>
          <td><select name="university_id" style="display:none;"><!-- kah2914 : mình thêm style="display:none;" để dấu cái selectbox-->
              <option value="-1"><?php echo $text_select; ?></option>
              <?php foreach ($universities as $university) { ?>
              <?php if ($university['category_id'] == $university_id) { ?>
              <option value="<?php echo $university['category_id']; ?>" selected="selected"><?php echo $university['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $university['category_id']; ?>"selected="selected"><!-- kah2914 : dòng này lúc đầu không có selected="selected". Mình thêm vào làm để select box luôn chọn dòng cuối cùng" --><?php echo $university['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <!--<?php if ($error_university) { ?>
            <span class="error"><?php echo $error_university; ?></span>
            <?php } ?></td>-->
        </tr>
         <!--<tr>
          <td> <?php echo $entry_faculty; ?><span class="required">*</span></td>
    </tr>-->
    <tr>
          <td><select name="faculty_id" style="display:none;"><!-- kah2914 : mình thêm style="display:none;" để dấu cái selectbox-->
              
            </select>
            <?php if ($error_faculty) { ?>
            <span class="error"><?php echo $error_faculty; ?></span>
            <?php } ?></td>
        </tr>
        <tr id="studentidblock_head">
          <td> <?php echo $entry_student_id; ?><span class="required">*</span></td>
    </tr>
    <tr id="studentidblock_tail">
          <td><input type="text" name="student_id" value="<?php echo $student_id; ?>" />
            <?php if ($error_student_id) { ?>
            <span class="error"><?php echo $error_student_id; ?></span>
            <?php } ?></td>
        </tr>
        <!-- end -->
         </table>
    </div>


    <!--<h2 class="password"><?php echo $text_id; ?></h2>-->
    <!--<div class="content">
      <table class="form">
        
        
        <tr>
          <td> <?php echo $entry_iddate; ?><span class="required">*</span></td>
    </tr>
    
    <tr>
          <td><input type="text" name="iddate" value="<?php echo $iddate; ?>" />
            <?php if ($error_iddate) { ?>
            <span class="error"><?php echo $error_iddate; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td> <?php echo $entry_idlocation; ?><span class="required">*</span></td>
    </tr>    
    <tr>
          <td>
          <select name="id_location">              
            </select>
            <?php if ($error_id_location) { ?>
            <span class="error"><?php echo $error_id_location; ?></span>
            <?php } ?>
          </td>
        </tr>    
    
    <tr>
          <td><select name="zone_id">
            </select>
            <?php if ($error_zone) { ?>
            <span class="error"><?php echo $error_zone; ?></span>
            <?php } ?></td>
        </tr>



      </table>
    </div>-->

    <!--<h2 class="password"><?php echo $text_your_password; ?></h2>-->
    <div class="content">
      <table class="form">
        <tr>
          <td> <?php echo $entry_password; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td> <?php echo $entry_confirm; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>

      <tr>
          <td> <?php echo $entry_idnum; ?><span class="required">*</span></td>
    </tr>
    <tr>
          <td><input type="text" name="id_num" value="<?php echo $id_num; ?>" />
            <?php if ($error_idnum) { ?>
            <span class="error"><?php echo $error_idnum; ?></span>
            <?php } ?></td>
        </tr>

      <!--kah2914 -->
      <tr>
          <td> <?php echo $entry_emailuniversity; ?></td>
    </tr>
    <tr>
          <td><input type="text" name="emailuniversity" value="<?php echo $emailuniversity; ?>" />
            </td>
        </tr>
        <!--kah2914-->

    <!-- kah2914 -->        
    <tr>
          <td> <?php echo $entry_portrait; ?><span class="required">*</span></td>
    </tr>
    <tr>
        <td>      
        <input name="userfile" type="file" />            
        <?php if ($error_portrait) { ?>
            <span class="error"><?php echo $error_portrait; ?></span>
          <?php } ?>
        </td>
    </tr>    
    <!-- kah2914 -->        
      </table>
    </div>

    <h2 class="Special"><?php echo $text_your_special; ?></h2>
    <div class="content">
      <table class="form">
      <!--<tr>
          <td>       
          <form method="post">     
            <input type='radio' name='policy' value=0 class="radio" <?php if ($policy == 0 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree0; ?> <br><br>
            <input type='radio' name='policy' value=1 class="radio" <?php if ($policy == 1 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree1; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=2 class="radio" <?php if ($policy == 2 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree2; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=3 class="radio" <?php if ($policy == 3 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree3; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=4 class="radio" <?php if ($policy == 4 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree4; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=5 class="radio" <?php if ($policy == 5 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree5; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=6 class="radio" <?php if ($policy == 6 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree6; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=7 class="radio" <?php if ($policy == 7 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree7; ?> <br><br>
            </form>
            <input type='radio' name='policy' value=8 class="radio" <?php if ($policy == 8 ){ ?>checked='checked'<?php } ?> /> <?php echo $text_agree8; ?> <br><br>
            </form>
          </td>            
        </tr>-->
        <!--<div>            
        <?php if ($agree1) { ?>
            <input type="checkbox" name="agree1" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree1" value="1" />
            <?php } ?><?php echo $text_agree1; ?>
        </div>
        <div>    
        <?php if ($agree2) { ?>
            <input type="checkbox" name="agree2" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree2" value="1" />
            <?php } ?><?php echo $text_agree2; ?>
        </div>
        <div>    
        <?php if ($agree3) { ?>
            <input type="checkbox" name="agree3" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree3" value="1" />
            <?php } ?><?php echo $text_agree3; ?>
        </div>
        <div>    
        <?php if ($agree4) { ?>
            <input type="checkbox" name="agree4" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree4" value="1" />
            <?php } ?><?php echo $text_agree4; ?>
        </div>
        <div>    
        <?php if ($agree5) { ?>
            <input type="checkbox" name="agree5" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree5" value="1" />
            <?php } ?><?php echo $text_agree5; ?>
        </div>
        <div>    
        <?php if ($agree6) { ?>
            <input type="checkbox" name="agree6" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree6" value="1" />
            <?php } ?><?php echo $text_agree6; ?>
        </div>
        <div>    
        <?php if ($agree7) { ?>
            <input type="checkbox" name="agree7" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree7" value="1" />
            <?php } ?><?php echo $text_agree7; ?>
        </div>
        <div>    
        <?php if ($agree8) { ?>
            <input type="checkbox" name="agree8" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="agree8" value="1" />
            <?php } ?><?php echo $text_agree8; ?>
        </div>-->
        <tr>
        <td>        
        Diện chính sách (chọn diện cao nhất) <span class="required">*</span>
        </td>
        </tr>
        <tr>
        <td>
        
        <div class="banana" style="width:90px; min-width:90px; display: inline-block">
            
        <select name="policy" type="text" class="scroll" id="policy" width="90" style="width: 90px">\
        <?php foreach($fields as $field) { ?>
       
        <option value="<?php echo $field['field_id'] ?>" <?php echo ($policy == $field['field_id']) ? ' selected="selected"' : ''; ?>><?php echo $field['field_name'] ?></option>
        
        <?php } ?>
        </select>
        </div>
        
        <div class="banana" style="width:115px; min-width:30px; display: inline-block">
          <a href="JavaScript:void(0)" onClick="alert('1) Sinh viên khuyết tật.\n\n2) Sinh viên là con liệt sỹ, con thương binh, con bệnh binh, con của người hưởng chính sách như thương binh, con của người có công.\n\n3) Sinh viên là người dân tộc thiểu số.\n\n4) Sinh viên mồ côi cả cha và mẹ. \n\n5) Sinh viên có hộ khẩu thường trú tại vùng cao, vùng có điều kiện kinh tế  - xã hội đặc biệt khó khăn.\n\n6) Sinh viên là con hộ nghèo, cận nghèo theo quy định hiện hành của Nhà nước.\n\n7) Sinh viên tích cực tham gia các hoạt động do nhà trường, Đoàn TNCS Hồ Chí Minh, Hội sinh viên, khu nội trú hoặc các tổ chức xã hội tổ chức.\n\n8) Các sinh viên không thuộc các đối tượng trên.(Ghi rõ lý do)')"><p style="color: #CC0000">Chi tiết các diện</p></a>
        </div>

        </td>
        </tr>      
        <tr>
          <td>                    
          <?php echo $entry_reason; ?>
          <TEXTAREA name="reason" ROWS=3 COLS=20 ><?php echo $reason; ?></TEXTAREA>
          <?php if ($error_reason) { ?>
            <span class="error"><?php echo $error_reason; ?></span>
            <?php } ?>
          <!--<input type="text" name="reason" value="<?php echo $reason; ?>" />-->                
          </td>
        </tr>

    </table>
    </div>
          
    
    
  </div>
  <div class="left newsletter">
    <div class="content">
  <!--<h2 class="newsletter"><?php echo $text_newsletter; ?></h2>
      <table class="form register_last">
        <tr>
          <td  class="subscribe"><?php echo $entry_newsletter; ?></td>
          <td class="input"><?php if ($newsletter) { ?>
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <span><?php echo $text_yes; ?></span>
            <input type="radio" name="newsletter" value="0" />
            <span><?php echo $text_no; ?></span>
            <?php } else { ?>
            <input type="radio" name="newsletter" value="1" />
            <span><?php echo $text_yes; ?></span>
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <span><?php echo $text_no; ?></span>
            <?php } ?></td>
        </tr>
      </table>-->
    </div>
  </div>
    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="left">
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>&nbsp;<?php echo $text_agree; ?>
        <a href="/capstone_atom_vn/image/ChinhsachsinhvienoKTX.JPG" download="chinhsachsinhvien" title="chinhsachsinhvien" style="color: #CC0000">
        chính sách sinh viên
        </a>
        </br></br></br>
        <span class="button_fr_ip"><input type="submit" value="<?php echo $button_continue; ?>" class="button cst" /></span>
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="left">
        <span class="button"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></span>
      </div>
    </div>
    <?php } ?>
  </form>
  <?php echo $content_bottom; ?></div></div>
<script type="text/javascript"><!--
$('input[name=\'customer_group_id\']:checked').live('change', function() {
  var customer_group = [];
  
<?php foreach ($customer_groups as $customer_group) { ?>
  customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
  customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
  customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
  customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
  customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
<?php } ?>  

  if (customer_group[this.value]) {
    if (customer_group[this.value]['company_id_display'] == '1') {
      $('#company-id-display').show();
    } else {
      $('#company-id-display').hide();
    }
    
    if (customer_group[this.value]['company_id_required'] == '1') {
      $('#company-id-required').show();
    } else {
      $('#company-id-required').hide();
    }
    
    if (customer_group[this.value]['tax_id_display'] == '1') {
      $('#tax-id-display').show();
    } else {
      $('#tax-id-display').hide();
    }
    
    if (customer_group[this.value]['tax_id_required'] == '1') {
      $('#tax-id-required').show();
    } else {
      $('#tax-id-required').hide();
    } 
  }
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
  $.ajax({
    url: 'index.php?route=account/register/country&country_id=' + this.value,
    dataType: 'json',
    beforeSend: function() {
      $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
    },
    complete: function() {
      $('.wait').remove();
    },      
    success: function(json) {
      if (json['postcode_required'] == '1') {
        $('#postcode-required').show();
      } else {
        $('#postcode-required').hide();
      }
      
      html = '<option value=""><?php echo $text_select; ?></option>';
      
      if (json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
              html += '<option value="' + json['zone'][i]['zone_id'] + '"';
            
          if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                html += ' selected="selected"';
            }
  
            html += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
      }
      
      $('select[name=\'zone_id\']').html(html);
      
      <!-- start /////////// END “you-id” - “your-name” modifications/////////////
        /////////////////////// Modification//////////////////////
        //       ID: 1051018          
        //       Name: Tran Thanh Toan          
        //   Class: 10CTT 
        //   Date 1/1/2014
        //   Description: add select box
        //   Date modified: 1/1/2014 
        //   Last updated: list the change by line number and goal, ex: 
        //     + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////-->
      html_id_location = '<option value=""><?php echo $text_select; ?></option>';
      
      if (json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
              html_id_location += '<option value="' + json['zone'][i]['zone_id'] + '"';
            
          if (json['zone'][i]['zone_id'] == '<?php echo $id_location; ?>') {
                html_id_location += ' selected="selected"';
            }
  
            html_id_location += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html_id_location += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
      }
      
      $('select[name=\'id_location\']').html(html_id_location);

      html_id_location = '<option value=""><?php echo $text_select; ?></option>';
      
      if (json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
              html_id_location += '<option value="' + json['zone'][i]['zone_id'] + '"';
            
          if (json['zone'][i]['zone_id'] == '<?php echo $id_location; ?>') {
                html_id_location += ' selected="selected"';
            }
  
            html_id_location += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html_id_location += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
      }
      
      $('select[name=\'id_location\']').html(html_id_location);
      $('select[name=\'address_9\']').html(html_id_location);
      $('select[name=\'address_4\']').html(html_id_location);


      <!-- end -->
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('select[name=\'country_id\']').trigger('change');

<!-- /////////// END “you-id” - “your-name” modifications/////////////
        /////////////////////// Modification//////////////////////
        //       ID: 1051018          
        //       Name: Tran Thanh Toan          
        //   Class: 10CTT 
        //   Date 1/1/2014
        //   Description: add textbox NK
        //   Date modified: 1/1/2014 
        //   Last updated: list the change by line number and goal, ex: 
        //     + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications///////////// -->
var nkid = '<?php echo $NKUniversity ?>';
$('select[name=\'university_id\']').bind('change', function() {
  $.ajax({
    url: 'index.php?route=account/register/childcategory&university_id=' + $('select[name=\'university_id\']').val(),
    dataType: 'json',
    beforeSend: function() {
      $('select[name=\'university_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
    },
    complete: function() {
      $('.wait').remove();
    },      
    success: function(json) {
      
      html = '<option value="-1"><?php echo $text_select; ?></option>';
      if (json) {
        for (i = 0; i < json.length; i++) {
              html += '<option value="' + json[i]['faculty_id'] + '"';
            
          if (json[i]['faculty_id'] == '<?php echo $faculty_id; ?>') {
                html += ' selected="selected"';
            }
  
            html += '>' + json[i]['name'] + '</option>';
        }
      } else {
        html += '<option value="-1" selected="selected"><?php echo $text_none; ?></option>';
      }
      
      $('select[name=\'faculty_id\']').html(html);
      
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
  //check Nang Khieu
  /*
  if($('select[name=\'university_id\']').val() == nkid) {
    var timestamp = +new Date();
    $('tr[id^=\'studentidblock_\']').hide();
    $('input[name=\'student_id\']').val('NK'+ timestamp.toString().substr(0,8));
    $('input[name=\'student_id\']').attr("readonly","readonly");
  }
  else{
    $('tr[id^=\'studentidblock_\']').show();
    $('input[name=\'student_id\']').val('');
    $('input[name=\'student_id\']').removeAttr("readonly");
  }*/
});

$('select[name=\'university_id\']').trigger('change');
<!--/////////// END “you-id” - “your-name” modifications/////////////
        /////////////////////// Modification//////////////////////
        //       ID: 1051018          
        //       Name: Tran Thanh Toan          
        //   Class: 10CTT 
        //   Date 1/1/2014
        //   Description: update student id for NK (NK+ iddb)
        //   Date modified: 1/1/2014 
        //   Last updated: list the change by line number and goal, ex: 
        //     + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////-->
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  $('.colorbox').colorbox({
    width: '80%', 
    height: '80%',
    maxWidth: 640,
        maxHeight: 480
  });
});
//--></script>  

<!--
<script type='text/javascript'>

 $(document).ready(function() { 
   $('input[name=policy]').change(function(){

        $('form').submit();

   });
  });

</script>-->

<!-- kah2914 -->
<script type="text/javascript">
//Gets the browser specific XmlHttpRequest Object
function getXmlHttpRequestObject() {
 if (window.XMLHttpRequest) {
    return new XMLHttpRequest(); //Mozilla, Safari ...
 } else if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP"); //IE
 } else {
    //Display our error message
    alert("Your browser doesn't support the XmlHttpRequest object.");
 }
}

//Our XmlHttpRequest object
var receiveReq = getXmlHttpRequestObject();

//Initiate the AJAX request
function makeRequest(url, param) {
//If our readystate is either not started or finished, initiate a new request
 if (receiveReq.readyState == 4 || receiveReq.readyState == 0) {
   //Set up the connection to captcha_test.html. True sets the request to asyncronous(default) 
   receiveReq.open("POST", url, true);
   //Set the function that will be called when the XmlHttpRequest objects state changes
   receiveReq.onreadystatechange = updatePage; 

   //Add HTTP headers to the request
   receiveReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   receiveReq.setRequestHeader("Content-length", param.length);
   receiveReq.setRequestHeader("Connection", "close");

   //Make the request
   receiveReq.send(param);
 }   
}

//Called every time our XmlHttpRequest objects state changes
function updatePage() {
 //Check if our response is ready
 if (receiveReq.readyState == 4) {
   //Set the content of the DIV element with the response text
   document.getElementById('result').innerHTML = receiveReq.responseText;
   //Get a reference to CAPTCHA image
   img = document.getElementById('imgCaptcha'); 
   //Change the image
   img.src = <?php echo '"';?><?php echo ($url);?><?php echo "/catalog/controller/account/create_image.php";?> <?php echo '?"'; ?> + Math.random();
 }
}

//Called every time when form is perfomed
function getParam(theForm) {
 //Set the URL
 var url = <?php echo '"';?><?php echo ($url);?><?php echo "/catalog/controller/account/captcha.php";?> <?php echo '"'; ?>;
 //Set up the parameters of our AJAX call
 var postStr = theForm.txtCaptcha.name + "=" + encodeURIComponent( theForm.txtCaptcha.value );
 //Call the function that initiate the AJAX request
 makeRequest(url, postStr);
}

</script>
<!-- kah2914 -->

<?php echo $footer; ?>  