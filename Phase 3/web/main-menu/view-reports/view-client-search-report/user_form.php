First Name:<br>
<input type="text" name="firstname" value="<?php echo isset($firstname)?$firstname:''; ?>"><br>
Last Name:<br>
<input type="text" name="lastname" value="<?php echo isset($lastname)?$lastname:''; ?>"><br>
ID Number:<br>
<input type="text" name="idnumber" value="<?php echo isset($idnumber)?$idnumber:''; ?>"><br>
<?php
if ($is_enroll_or_edit) {
?>
ID Description:<br>
<input type="text" name="iddescription" value="<?php echo isset($iddescription)?$iddescription:''; ?>"><br>
Is head of household?:<br>
<select name="ishead">
  <option value="0" <?php echo isset($ishead)&&$ishead==0?'selected':''?>>No</option>
  <option value="1" <?php echo isset($ishead)&&$ishead==1?'selected':''?>>Yes</option>
</select><br>
Phone:<br>
<input type="text" name="phone" value="<?php echo isset($phone)?$phone:''; ?>"><br>
<?php
}
?>
<?php echo isset($clientid)?"<input type='hidden' name='clientid' value='$clientid'>":''; ?>
<br>
<input type="submit" name="submit" value="Submit">
