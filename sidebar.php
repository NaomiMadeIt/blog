<aside id="sidebar">
  <nav>
    <ul>
      <li><a href="admin/">Admin Panel</a></li>
      <li><a href="register.php">Sign Up</a></li>
    </ul>
  </nav>
  <section>
    <form action="search.php" method="get">
      <label for="the_keywords">Search:</label>
      <input type="search" name="keywords" id="the_keywords">
      <input type="submit" value="Go" class="search-button">
    </form>
  </section>
  <section>
    <h2>Recent Posts</h2>
    <?php
    //get the 5 latest published post titles
    //TODO: make this show the posts that have 0 comments
    $query = "SELECT posts.title, posts.post_id
              FROM posts
              WHERE posts.is_published = 1
              ORDER BY posts.date DESC
              LIMIT 5";
    //run it
    $result = $db->query($query);
    //check it
    if( $result->num_rows >=1 ){

     ?>
    <ul>
    <?php
    //loop it
    while( $row = $result->fetch_assoc() ){ ?>
    <li><a href="single.php?post_id=<?php echo $row['post_id']; ?>">
      <?php echo $row['title']; ?>
    </a> - <?php count_comments( $row['post_id'] ); ?>
    </li>
    <?php } //end while
    //free it after a select
    $result->free();
    ?>
    </ul>
    <?php } //end if there are posts
    else {
      echo 'No posts to show.';
    } ?>
  </section>
  <section>
    <h2>Categories</h2>
    <?php
    //get all category names in alphabetical order
    $query = "SELECT cats.name, COUNT(*) AS total
              FROM categories AS cats, posts
              WHERE cats.category_id = posts.category_id
              GROUP BY posts.category_id
              ORDER BY cats.name ASC
              LIMIT 5";
    //run it
    $result = $db->query($query);
    //check it
    if($result->num_rows >= 1){
     ?>
    <ul>
      <?php
      //loop it
      while( $row = $result->fetch_assoc() ){ ?>
    <li><?php echo $row['name']; ?> (<?php echo $row['total']; ?>)</li>
    <?php } //end while
    //free it after a select
    $result->free(); ?>
    </ul>
    <?php } //end category ?>
  </section>
  <section>
    <h2>Links</h2>
    <?php
    //get all links alphabetical by title
    $query = "SELECT title, url
              FROM links
              ORDER BY title ASC";
    //run it
    $result = $db->query($query);
    //check it
    if($result->num_rows >= 1){
     ?>
    <ul>
      <?php
      //loop it
      while( $row = $result->fetch_assoc() ){ ?>
    <li><a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['title']; ?></a></li>
    <?php } //end while
    //free it after a select
    $result->free(); ?>
    </ul>
    <?php } //end category
    else echo 'nope. no links' ?>
  </section>
</aside>
