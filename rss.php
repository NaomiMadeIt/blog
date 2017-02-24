<?php
//connect to db
require('db-config.php');
include_once('functions.php');
//echo out the XML declaration since the <? characters confuse the PHP parser
echo '<?xml version="1.0" encoding="UTF-8"?>';

//get up to 10 published posts
$query = "SELECT posts.title, posts.post_id, posts.date, users.email,       users.username, posts.body
          FROM posts, users
          WHERE users.user_id = posts.user_id
          AND posts.is_published = 1
          ORDER BY posts.date DESC
          LIMIT 10";
//run it
$result = $db->query($query);
//check it
if(!$result){
  die($db->error);
}
?>
<rss version = "2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>My Awesome Blog</title>
    <link>http://localhost/edna_php/blog/</link>
    <description>A practice blog about nothing</description>
    <atom:link href="http://localhost/edna_php/blog/" rel="self" type="application/rss+xml" />
    <?php while( $row = $result->fetch_assoc() ){ ?>
    <item>
      <title><?php echo $row['title']; ?></title>
      <link>http://localhost/edna_php/blog/single.php?post_id=<?php echo $row['post_id']; ?></link>
      <guid>http://localhost/edna_php/blog/single.php?post_id=<?php echo $row['post_id']; ?></guid>
      <pubDate><?php echo convertTimeRSS($row['date']); ?></pubDate>
      <author><?php echo $row['email']; ?> (<?php echo $row['username']; ?>)</author>
      <description> <![CDATA[ <?php echo $row['body']; ?> ]]></description>
    </item>
    <?php } //end while loop ?>
  </channel>
</rss>
