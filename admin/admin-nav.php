<nav role='navigation'>
  <ul class="main">
    <li class="dashboard"><a href="#">Dashboard</a></li>
    <li class="write"><a href="#">Write Post</a></li>
    <li class="edit"><a href="#">Edit Posts</a></li>
		<?php if(IS_ADMIN){ ?>
    <li class="comments"><a href="#">Comments</a></li>
    <li class="users"><a href="#">Manage Users</a></li>
		<?php } ?>
  </ul>
</nav>
