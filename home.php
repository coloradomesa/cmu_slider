<?php
session_start();
include("db/connect.php"); // this connects to the cmu_slider db so we can query it

$pageTitle = "create slide";
include("header.php");

if($_SESSION['permissions'] === "admin" || $_SESSION['permissions'] === "superuser"){
?>

<!-- Main Content Begin -->
<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
<!--<script src="js/home.js"></script> included since page title is no longer 'home', so home.js isn't included in footer -->

<div class="container">

	<div id="slide_options">
		<div class="row">
			<div class="four columns">
				<input type="button" class="button" id="simple" value="Text Slide"/>
			</div>
			<div class="four columns">
				<input type="button" class="button" id="simple" value="Picture Slide"/>
			</div>
			<div class="four columns">
				<input type="button" class="button" id="simple" value="Web Slide"/>
			</div>
		</div>
	</div>

	<form id="slide_form" enctype="multipart/form-data">
		
		<div class="row optional url">
			<div class="twelve columns">
				<label for="slide_url">Website URL</label>
				<input type="text" name="slide_url" id="slide_url" class="u-full-width"/>
			</div>
		</div>

		<div class="row">
			<div class="twelve columns">
				<label for="slide_title">Title</label>
				<input type="text" name="slide_title" id="slide_title" class="u-full-width"/>
			</div>
		</div>

		<div class="row">
			<div class="twelve columns">
				<label for="slide_content">Content</label>
				<textarea name="slide_content" id="slide_content"></textarea>	
			</div>
		</div>

		<div class="row optional picture">
			<div class="twelve columns">
				<label for="slide_picture">Upload Picture</label>
				<input type="file" name="slide_picture" id="slide_picture" class="u-full-width" onchange="readURL(this);" />
			</div>
		</div>

		<div class="row">
			<div class="six columns">
				<label for="startDate">Start Date</label>
				<input type="date" class="date" id="startDate" name="startDate"/>
			</div>

			<div class="six columns">
				<label for="endDate">End Date</label>
				<input type="date" class="date" id="endDate" name="endDate"/>
			</div>
		</div>

		<div class="row">
			<div class="six columns">
				<input type="button" value="Preview" class="button" id="preview_button"/>
			</div>

			<div class="six columns">
				<input type="submit" value="Submit" class="button-primary" id="submit_slide_button" style="float: right;"/>
			</div>
		</div>
	
	</form>

</div>

<div class="row slide_preview" id="slide_preview">
</div>

<!-- Main Content End -->

<?php
include("footer.php");

} // endif

else {
	$loginURL = "login_page.php";
	echo "Please <a href='$loginURL'>login</a> to continue";
}

?>
