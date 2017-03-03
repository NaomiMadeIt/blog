<?php
session_start();
require('../db-config.php');
include_once('../functions.php');
//header contains the security check, doctype, and <header> element
include('admin-header.php');
include('admin-nav.php');

//begin parsing the image upload
if( $_POST['did_upload'] ){
  //where is the uploads directory?
  $upload_path = '../uploads';

  //create a list of image sizes (max width in px)
  $sizes = array(
    'small' => 150,
    'medium' => 300,
  );

  //extract the image that was uploaded
  $uploadedfile = $_FILES['uploadedfile']['tmp_name'];
  //validate = make sure it has pixels
  list($width, $height) = getimagesize($uploadedfile);
  if( $width > 0 and $height > 0){
    //what type of image is it?
    $filetype = $_FILES['uploadedfile']['type'];
    switch($filetype){
      case 'image/gif':
          $source = imagecreatefromgif($uploadedfile);
        break;

      case 'image/jpeg':
      case 'image/pjpeg':
      case 'image/jpg':
        $source = imagecreatefromjpeg($uploadedfile);
      break;

      case 'image/png':
        ini_set( 'memory_limit', '16M' );
        $source = imagecreatefrompng($uploadedfile);
        ini_restore( 'memory_limit' );
      break;
      default:
        $message = 'Please upload an image that is a .gif, .png, or .jpeg';
    } //end switch

    //resize the image
    $uniquestring = sha1(microtime());
    foreach ($sizes as $name => $pixels) {
      if( $width < $pixels ){
        $new_width = $width;
        $new_height = $height;
      }else{
        //calculations to preserve the original aspect ratio
        $new_width = $pixels;
        $new_height = ( $new_width * $height ) / $width;
      }

      $tmp_canvas = imagecreatetruecolor($new_width, $new_height);

      imagecopyresampled($tmp_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

      $filename = $upload_path . '/' . $uniquestring . '_' . $name . '.jpg';
      $did_save = imagejpeg($tmp_canvas, $filename, 80);
    } //end foreach

    //if it saved the image, add the unique string to the DB
    if( $did_save ){

      //DELETE OLD FILE
            //look up the old image name
            $query_oldfile = "SELECT userpic FROM users where user_id = " . USER_ID . " LIMIT 1";
            $result_oldfile = $db->query($query_oldfile);
            if($result_oldfile->num_rows == 1){
                $row_oldfile = $result_oldfile->fetch_assoc();
                //delete old files
                foreach ($sizes as $size_name => $size_width) {
                   $old_file = ROOT_PATH . '/uploads/' . $row_oldfile['userpic'] . '_' . $size_name . '.jpg'  ;
                  //Delete the file from the directory with unlink()
                  @unlink($old_file);
                }
            }
            //END DELETE OLD FILE


      $user_id = USER_ID;
      $query = "UPDATE users
                SET userpic = '$uniquestring'
                WHERE user_id = $user_id";
      $result = $db->query($query);
      if( $db->affected_rows == 1 ){
        $message = 'Success! Your Profile Picture has been updated!';
      }else{
        $message = 'Sorry, your Profile Picture could not be saved in the DB.';
      }
    } //end if did_save
    else{
      $message = 'Sorry, it did not save in the folder.';
    }
  } //end if it has width and height (validator)
  else{
    $message = 'Sorry, your image contains no pixels.';
  }
} //end of parser
?>

<main role="main">
  <section class="panel important">
    <h2>Edit Profile Picture</h2>
    <?php show_feedback( $message ); ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="uploadedfile">
      <label>Choose a photo to upload:</label>
      <input type="file" name="uploadedfile" />

      <input type="submit" name="Edit Profile Pic" />

      <input type="hidden" name="did_upload" value="1" />
    </form>

    <?php show_userpic( USER_ID, 'medium' ); ?>

	</section>

	</main>
	<?php include('admin-footer.php'); ?>
