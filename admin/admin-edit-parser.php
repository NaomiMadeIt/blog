<?php
if($_POST['did_post']){
  //sanitize all fields
    $title          = clean_string( $_POST['title'] );
    $body           = clean_string( $_POST['body'] );
    $category_id    = clean_integer( $_POST['category_id'] );
    $is_published   = clean_boolean( $_POST['is_published'] );
    $allow_comments = clean_boolean( $_POST['allow_comments'] );
    //convert null checkboxes to 0
  //validate
    $valid = true;
      //title is blank
        if( $title == ''){
          $valid = false;
          $errors['title'] = 'Title is required.';
        }
    //body is blank
      if( $body == ''){
        $valid = false;
        $errors['body'] = 'Post body is required.';
      }
    //category cannot be blank
      if( $category_id == ''){
        $valid = false;
        $errors['category_id'] = 'Category is required.';
      }
  //if valid, add the post to the database
    if( $valid ){
      //conver the constant into a variable so we can use it in a query
      $user_id = USER_ID;
      $query = "UPDATE posts
                SET
                title             = '$title',
                body              = '$body',
                category_id       = $category_id,
                is_published      = $is_published,
                allow_comments    = $allow_comments
                WHERE post_id = $post_id";

      $result = $db->query($query);
      if( $db->affected_rows == 1){
        //show user feedback
        $feedback = 'Success! Your post was saved.';
      }else{
        $feedback = 'No changes were made.';
      } //end if row added
    }else{
      $feedback = 'Please fix the errors in the from:';
    } //end if valid
}

//don't close PHP for php dedicated files (aka php only files)
