<?php
if ( isset($_POST['send_mail']) )
{
	// If one of the required fields is empty, display this message
	if ( empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message']) )
	{
		alert('warning', 'Ikke alle påkrævede felter er udfyldt!');
	}
	else
	{
		if ( send_mail($settings->setting_email, $_POST['subject'], $_POST['message'], $_POST['email'], $_POST['name']) )
		{
			alert('success', '<strong>Tak for din besked!</strong> Vi vil svare dig indenfor 24 timer');
		}
		else
		{
			alert('danger', '<strong>Fejl!</strong>. Der skete en fejl og din besked kunne ikke sendes til os. Prøv igen, eller kontakt os på anden vis.');
		}
	}

}

?>

<form method="post">
	<div class="form-group">
		<label for="name">Fulde navn</label>
		<input type="text" class="form-control" name="name" id="name" required value="<?php if ( isset($_POST['name']) ) { echo $_POST['name']; } ?>">
	</div>

	<div class="row">

		<div class="col-sm-6">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" class="form-control" name="email" id="email" value="<?php if ( isset($_POST['email']) ) echo $_POST['email'] ?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="subject">Emne</label>
				<input type="text" class="form-control" name="subject" id="subject" required value="<?php if ( isset($_POST['subject']) ) echo $_POST['subject'] ?>">
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label for="message">Besked</label>
				<textarea name="message" id="message" class="form-control" required minlength="3"><?php if ( isset($_POST['message']) ) { echo $_POST['message']; } ?></textarea>
				<!-- CKEditor -->
				<script src="assets/ckeditor-4.5.1/ckeditor.js"></script>
				<script>
					CKEDITOR.config.filebrowserBrowseUrl		= 'assets/kcfinder-3.12/browse.php?opener=ckeditor&type=files';
					CKEDITOR.config.filebrowserUploadUrl		= 'assets/kcfinder-3.12/upload.php?opener=ckeditor&type=files';
					CKEDITOR.config.filebrowserImageBrowseUrl	= 'assets/kcfinder-3.12/browse.php?opener=ckeditor&type=images';
					CKEDITOR.config.filebrowserImageUploadUrl	= 'assets/kcfinder-3.12/upload.php?opener=ckeditor&type=images';
					CKEDITOR.config.contentsCss					= ['assets/bootstrap-3.3.7/css/bootstrap.min.css', 'css/ckeditor.css', 'assets/font-awesome-4.6.3/css/font-awesome.min.css'];

					CKEDITOR.replace('message', {
						height: 75,
						toolbar: 'Basic'
					})
				</script>
			</div>
		</div>

		<div class="col-sm-12 form-group">
			<button type="submit" name="send_mail" class="btn btn-primary"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send besked</button>
		</div>
	</div>
	<!-- /.row -->
</form>