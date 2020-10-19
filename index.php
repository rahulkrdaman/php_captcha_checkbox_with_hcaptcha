<?php
// Include form submission script
include 'submit.php';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Integrate CAPTCHA with hCaptcha using PHP by CodexWorld</title>
<meta charset="utf-8">

<!-- Stylesheet file -->
<link rel="stylesheet" href="css/style.css" />

<!-- Include hCaptcha API library -->
<script src="https://hcaptcha.com/1/api.js" async defer></script>
</head>
<body>
<div class="container">
	<h1>Contact Form with CAPTCHA</h1>
	<div class="cw-frm">
		<form action="" method="post">
			<h3>Contact Form</h3>
	   
			<!-- Status message -->
			<?php if(!empty($statusMsg)){ ?>
				<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
			<?php } ?>
	  
			<!-- Form fields -->
			<div class="input-group">
				<input type="text" name="name" value="<?php echo !empty($postData['name'])?$postData['name']:''; ?>" placeholder="Your name" required="" />
			</div>
			<div class="input-group">	
				<input type="email" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" placeholder="Your email" required="" />
			</div>
			<div class="input-group">
				<textarea name="message" placeholder="Type message..." required="" ><?php echo !empty($postData['message'])?$postData['message']:''; ?></textarea>
			</div>
				
			<!-- Add hCaptcha CAPTCHA box -->
			<div class="h-captcha" data-sitekey="<?php echo $siteKey; ?>"></div>
			
			<!-- Submit button -->
			<input type="submit" name="submit" value="SUBMIT">
		</form>
	</div>

	<div class="footer">
		<p>
			&copy; 2019 CodexWorld.com . All Rights Reserved | Design by
			<a href="https://www.codexworld.com/" target="_blank">CodexWorld</a>
		</p>
	</div>
</div>
</body>
</html>