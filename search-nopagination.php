<?php
require('db-config.php');
//use _once on function definitions to prevent duplicates
include_once('functions.php');
//get the doctype and header area
include('header.php');

//Extract the keywords that the user is searching for
$keywords = clean_string( $_GET['keywords'] );
 ?>

    <main>
      <?php
      //Get all the published posts that contain the keywords in their title or body
      $query = "SELECT DISTINCT *
                FROM posts
                WHERE is_published = 1
                AND ( title LIKE '%$keywords%' OR body LIKE '%$keywords%')";
      //run the query. catch the returned info in a result
      $result = $db->query($query);

      //check to see if the result has rows (posts)
      if( $result->num_rows >= 1 ){
        //loop through each row found, displaying the article each time
        while( $row = $result->fetch_assoc() ){
       ?>
      <article>
        <h2>
          <a href="single.php?post_id=<?php echo $row['post_id']; ?>">
          <?php echo $row['title']; ?>
          </a>
        </h2>
        <div class="post-info">
          <?php echo convertTimestamp($row['date']); ?>
        </div>
        <p><?php echo $row['body']; ?></p>
      </article>
      <?php
        } //end while there are posts
    } //end if there are posts
      else{
        echo 'Sorry, no posts to show.';
      } ?>

      <a href="blog.php">Read All Posts</a>
    </main>
    <?php
    //get the aside
    include ('sidebar.php');

    //get the footer and close the open body and html tags
    include ('footer.php');
    ?>
