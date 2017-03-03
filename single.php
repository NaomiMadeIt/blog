<?php
require('db-config.php');
//use _once on function definitions to prevent duplicates
include_once('functions.php');
//get the doctype and header area
include('header.php');

//which post are we trying to show?
//URL looks like: ..blog/single.php?post_id=X
if( isset($_GET['post_id']) ){
  $post_id = $_GET['post_id'];
}else{
  $post_id = 0;
}

//parse the comment form
if( $_POST['did_comment'] ){
  //extract the value that the user typed in and sanitize it!
  $name = clean_string( $_POST['name'] );
  $email = clean_email( $_POST['email'] );
  $url = clean_url( $_POST['url'] );
  $body = clean_string( $_POST['body'] );

  //validate!
  $valid = true;

  //if name is blank
  if( $name == '' ){
    $valid = false;
    $errors['name'] = 'Name field is required';
  }

  //email is blank or invalid format
  if( ! filter_var($email, FILTER_VALIDATE_EMAIL) ){
    $valid = false;
    $errors['email'] = 'A valid email is required.';
  }

  //body of comment cannot be blank
  if( $body == '' ){
    $valid = false;
    $errors['body'] = 'Comment body is required.';
  }

  //if valid, add to the DB
  if( $valid ){
    //add one comment to the DB
    $query = "INSERT INTO comments
              ( name, date, body, post_id, email, url, is_approved )
              VALUES
              ( '$name', now(), '$body', $post_id, '$email', '$url', 1 )";
    //run it
    $result = $db->query($query);
    //check to see if one row was added
    if( $db->affected_rows == 1 ){
      $status = 'success';
      $message = 'Thanks for commenting on my blog!';
    }else{
      $status = 'error';
      $message = 'Database Error';
    } //end if now added
  }else{
    $status = 'error';
    $message = 'Invalid submission';
  }

  //user feedback

} //end of parser
 ?>

    <main>
      <?php //get all the information about the post we are trying to show (make sure it's published)
      $query = "SELECT posts.title, posts.body, users.username, posts.date, users.user_id
                FROM posts, users
                WHERE posts.user_id = users.user_id
                AND posts.is_published = 1
                AND posts.post_id = $post_id
                LIMIT 1";
      //run it
      $result = $db->query($query);
      //check it
      if( $result->num_rows >= 1 ){
        //loop it
        while( $row = $result->fetch_assoc() ){
      ?>
      <article>
        <h2><?php echo $row['title']; ?></h2>
        <p><?php echo $row['body']; ?></p>
        <div class="post-info">
            <?php show_userpic( $row['user_id'], 'small' ); ?>
            <br />
            By <?php echo $row['username']; ?>
            on <?php echo convertTimestamp($row['date']); ?>
        </div>
      </article>
      <?php } //end while ?>

      <?php
      //get all the approved comments about THIS post
      $query = "SELECT body, name, url, date
                FROM comments
                WHERE is_approved = 1
                AND post_id = $post_id
                ORDER BY date ASC
                LIMIT 20";
      //run it
      $result = $db->query($query);
      //check if we found any comments
      if( $result->num_rows >= 1 ){
       ?>
      <section class="comments">
        <h2>Comments on this post:</h2>

        <?php while( $row = $result->fetch_assoc() ){ ?>
        <div class="one-comment">
          <div class="comment-body">
            <?php echo $row['body']; ?>
          </div>
          <div class="comment-info">
            From <a href="<?php echo $row['url']; ?>">
                <?php echo $row['name']; ?>
                </a>
            on <?php echo convertTimestamp($row['date']); ?>
          </div>
        </div>
        <?php } //end while ?>

      </section>
      <?php } //end if there are comments
      else{
        echo 'This post does not have any comments yet.';
      } ?>

      <section class="add-comment" id="comment-form">
        <h2>Add a Comment</h2>

        <?php
        //user feedback
        echo $message;
         ?>
        <form action="#comment-form" method="post">
          <label>Name</label>
          <input type="text" name="name" id="the-name">

          <label for="the-email">Email</label>
          <input type="text" name="email" id="the-email">

          <label for="the-url">URL (optional)</label>
          <input type="text" name="url" id="the-url">

          <label for="the-body">Comment:</label>
          <textarea name="body" id="the-body"></textarea>

          <input type="submit" value="Leave Comment">
          <input type="hidden" name="did_comment" value="true">
        </form>
      </section>
      <?php
     } //end if one post found
      else{
        echo 'No Posts Found.';
      } ?>
    </main>
    <?php
    //get the aside
    include ('sidebar.php');

    //get the footer and close the open body and html tags
    include ('footer.php');
    ?>
