<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	global $wpdb;

?>
<div class="wrap">
	<h2>Random Quotes</h2>

	<h3>Display Quotations</h3>
	<p style="width: 500px;">Displaying quotations is easy. You can insert the template tag below anywhere into your theme, and it will pull a random quotation from the list below.</p>
	<textarea rows="1" cols="58" readonly>&lt;?php display_rq(); ?&gt; // Will display a random quotation</textarea><br /><br />

	<p style="width: 500px;">If you want to display a certain quotation every single time, there is a solution for this as well. All you have to do is put the ID of the quotation(found to the right of the quotation on the table below) in the parenthasis of the function, like so:</p>
	<textarea rows="2" cols="58" readonly>&lt;?php display_rq(1); ?&gt; // Will display quotation with an ID of 1
&lt;?php display_rq(2); ?&gt; //Will display quotation with an ID of 2 </textarea><br /><br />

	<h3>Your Quotations</h3>

	<?php
		if(isset($_POST['quoteText'])) {
			$quotation = sanitize_text_field($_POST['quoteText']);
			if($wpdb->query("INSERT INTO " . $wpdb->prefix . "rq (quotation) VALUES ('$quotation')")) {
				echo "<div class=\"updated fade\" id=\"message\"><p><strong>Quotation added.</strong></p></div>";
			} else {
				echo "<div class=\"updated fade\" id=\"message\"><p><strong>There was an error, and the quotation could not be added.</strong></p></div>";
			}
		} elseif(isset($_GET['mode']) && $_GET['mode'] == "delete" && isset($_GET['id'])) {
			$quoteId = sanitize_text_field($_GET['id']);
			if($wpdb->query("DELETE FROM " . $wpdb->prefix . "rq WHERE id = $quoteId")) {
				echo "<div class=\"updated fade\" id=\"message\"><p><strong>Quotation deleted.</strong></p></div>";
			} else {
				echo "<div class=\"updated fade\" id=\"message\"><p><strong>There was an error, and the quotation could not be deleted.</strong></p></div>";
			}
		} elseif(isset($_GET['mode']) && $_GET['mode'] == "uninstall") {
			$wpdb->query("DROP TABLE " . $wpdb->prefix . "rq");
			delete_option("rq_db_version");
			if($wpdb->query("SELECT * FROM " . $wpdb->prefix . "rq") == 0 || false) {
				echo "<div class=\"updated fade\" id=\"message\"><p><strong>Random Quotes has been uninstalled.</strong></p></div>";
			} else {
				echo "<div class=\"updated fade\" id=\"message\"><p><strong>There was an error, and Random Quotes could not be uninstalled.</strong></p></div>";
			}
		}
	?>

	<?php

		$debug = false;

		if($debug) {
			echo "<pre>";
			print_r($results);
			echo "</pre>";
		}

	?>

		<table cellspacing="0" class="widefat fixed" style="width: 500px;">
			<thead>
				<tr>
					<th style="" class="manage-column column-title" id="quotation" scope="col">Quotation</th>
					<th style="width: 100px;text-align: right;" class="manage-column column-author" id="id" scope="col">ID</th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<th style="" class="manage-column column-title" id="quotation" scope="col">Quotation</th>
					<th style="text-align: right;" class="manage-column column-author" id="id" scope="col">ID</th>
				</tr>
			</tfoot>

			<tbody>
				<?php
					$results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix ."rq");
					echo "<ul>";
					$i = 0;
					if(count($results) > 0) :
						foreach($results as $result) :
							if($i%2) {
								$alt = "alternate";
							} else {
								$alt = "";
							} ?>
							<tr valign="top" class="<?php echo $alt; ?> author-self status-publish iedit" style="border-bottom: 2px dashed">
								<td class="post-title column-title ">
									<strong><?php echo stripslashes($result->quotation); ?></strong>
									<div class="row-actions">
										<!-- WILL BE USED IN NEXT RELEASE -->
										<!--<span class="edit">
											<a href="<?php echo "update-" . $result->id; ?>" title="Edit this quotation">Edit</a> |
										</span>-->
										<span class="trash">
											<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&mode=delete&id=<?php echo $result->id; ?>" title="Delete this quotation">Delete</a>
										</span>
									</div>
								</td>
								<td style="text-align: right;" class="author column-author">
									<a href=""><?php echo $result->id; ?></a>
								</td>
							</tr>
						<?php endforeach;
					else : ?>
						<tr valign="top" class="<?php echo $alt; ?> author-self status-publish iedit" id="post-63">
							<td class="post-title column-title ">
								There are no quotes to display. You can add one below!
							</td>
							<td style="text-align: right;" class="author column-author"></td>
						</tr>
					<?php endif; ?>
			</tbody>
		</table>

		<h3>Add A Quotation</h3>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<textarea id="quoteText" name="quoteText" rows="2" cols="58"></textarea><br />
			<!--<small>(Note: Don't add the quotation marks, we'll add those for you!)</small><br />--><br />
			<input type="submit" id="submit" value="Add Quotation" />
		</form>

		<h3>Settings</h3>
		<p style="width: 500px;">If you want to completely uninstall Random Quotes, this button will delete all the information relevent to this plugin. If you ever want to reinstall this Random Quotes, it's just as easy as reactivating the plugin.</p>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&mode=uninstall" method="post">
			<input type="submit" class="uninstall" value="Uninstall Random Quotes" />
		</form>

		<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){

				/* WILL BE USED IN NEXT RELEASE */
				/*$(".edit a, .trash a").click(function(){
					var href = $(this).attr("href");
					var hrefArr = href.split("-");
					$.ajax({
						url: '<?php bloginfo('url'); ?>/wp-content/plugins/random-quotes/ajax.php?mode=' + hrefArr[0] + '&id=' + hrefArr[1],
						success: function(data) {
							alert(data);
						}
					});
					return false;
				});*/

				$(".uninstall").click(function(){
					$(this).parent().append('<input type="submit" value="Yes, I want to uninstall Random Quotes." />');
					$(this).remove();
					return false;
				});
			});
		</script>

</div>
