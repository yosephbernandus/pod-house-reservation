<!DOCTYPE html>
<html> 
<head> 
  <title>Codeignier 3 Image Upload with Resize Example from Scratch</title> 
</head>

<body> 


  <?php echo form_open_multipart('gallery/uploadImage');?> 
     <input type="file" name="image" size="20" />
     <input type="submit" value="upload" /> 
  </form> 

</body>
</html>