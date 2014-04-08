<p>This is a quick overview of some features.</p>
<br>
<li>A user can edit documents</li>
<br>
<li>Users can see what documents have been approved</li>
<br>
<li>Users with admin privileges can approve documents in the app. </li>
<br>
<li>Security for the app is provided by MD5() hashing</li>
<br>
<li>User can see the list of docs with paging and sorting functionality</li>
<br>
<li>Admins can approve docs under Document Panel on left.</li>
<br>
<li>Enjoy!</li>

<?php
preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

if (count($matches)>1){
	// using IE
	$version = $matches[1];
	if($version < 10){
		?>
		    <ul class="states">
		      <li class="warning">Detected IE <?php echo $version; ?>.  Please upgrade to at least IE 10 to use this demo, or use Chrome, Safari or FireFox instead.</li>
		    </ul>
		<?php
	}
}
?>