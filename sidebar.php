<aside id="sidebar">
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
		$query = "SELECT posts.title, COUNT(*) AS total, posts.post_id
					FROM posts, comments
					WHERE posts.post_id = comments.post_id
					AND posts.is_published = 1
					GROUP BY comments.post_id
					ORDER BY posts.date DESC
					LIMIT 5";
		//run it
		$result = $db->query($query);
		//check it
		if( $result->num_rows >= 1 ){
		?>
		<ul>
			<?php 
			//loop it
			while( $row = $result->fetch_assoc() ){ ?>
			<li><a href="single.php?post_id=<?php echo $row['post_id'] ?>">
				<?php echo $row['title']; ?>
				</a> 
				- <?php echo $row['total'] ?> comments
			</li>
			<?php } //end while ?>
		</ul>
		<?php 
		} //end if there are posts
		else{
			echo 'No posts to show.';
		} 
		?>
	</section>

	<section>
		<h2>Categories</h2>
		<?php //get all category names in alphabetical order 
		$query = "SELECT cats.name, COUNT(*) AS total
					FROM categories AS cats, posts
					WHERE cats.category_id = posts.category_id
					GROUP BY posts.category_id
					ORDER BY cats.name ASC
					LIMIT 5";
		$result = $db->query($query);
		if($result->num_rows >= 1){
		?>
		<ul>
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<li><?php echo $row['name']; ?> (<?php echo $row['total']; ?>)</li>
			<?php } //end while
			//free it after a select
			$result->free();
			?>
		</ul>
		<?php } ?>
	</section>

	<section>
		<h2>Links</h2>
		<?php //get all links alphabetical by title 
		$query = "SELECT title, url 
					FROM links
					ORDER BY title ASC";
		$result = $db->query($query);
		if( $result->num_rows >= 1 ){
		?>
		<ul>
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<li>
				<a href="<?php echo $row['url'] ?>" target="_blank">
					<?php echo $row['title'] ?>
				</a>
			</li>
			<?php }
			//free it after a select
			$result->free();
			?>		
		</ul>
		<?php }
		else{
			echo 'No links to show';
		} ?>
	</section>
</aside>