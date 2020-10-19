<?php
$postData = $statusMsg = '';
$status = 'error';

// hCAPTCHA API key configuration
$siteKey 	= 'Insert_hCaptcha_Site_Key';
$secretKey 	= 'Insert_hCaptcha_Secret_Key';

// If the form is submitted
if(isset($_POST['submit'])){
	$postData = $_POST;
	
	// Validate form fields
	if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])){
		
		// Validate hCAPTCHA checkbox
		if(!empty($_POST['h-captcha-response'])){
			// Verify API URL
			$verifyURL = 'https://hcaptcha.com/siteverify';
			
			// Retrieve token from post data with key 'h-captcha-response'
			$token = $_POST['h-captcha-response'];
			
			// Build payload with secret key and token
			$data = array(
				'secret' => $secretKey,
				'response' => $token,
				'remoteip' => $_SERVER['REMOTE_ADDR']
			);
			
			// Initialize cURL request
			// Make POST request with data payload to hCaptcha API endpoint
			$curlConfig = array(
				CURLOPT_URL => $verifyURL,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => $data
			);
			$ch = curl_init();
			curl_setopt_array($ch, $curlConfig);
			$response = curl_exec($ch);
			curl_close($ch);
			
			// Parse JSON from response. Check for success or error codes
			$responseData = json_decode($response);
			
			// If reCAPTCHA response is valid
			if($responseData->success){
				// Posted form data
				$name = !empty($_POST['name'])?$_POST['name']:'';
				$email = !empty($_POST['email'])?$_POST['email']:'';
				$message = !empty($_POST['message'])?$_POST['message']:'';
				
				// Send email notification to the site admin
				$to = 'admin@codexworld.com';
				$subject = 'New contact form have been submitted';
				$htmlContent = "
					<h1>Contact request details</h1>
					<p><b>Name: </b>".$name."</p>
					<p><b>Email: </b>".$email."</p>
					<p><b>Message: </b>".$message."</p>
				";
				
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$headers .= 'From:'.$name.' <'.$email.'>' . "\r\n";
				
				// Send email
				@mail($to,$subject,$htmlContent,$headers);
				
				$status = 'success';
				$statusMsg = 'Your contact request has submitted successfully.';
				$postData = '';
			}else{
				$statusMsg = 'Robot verification failed, please try again.';
			}
		}else{
			$statusMsg = 'Please check on the CAPTCHA box.';
		}
	}else{
		$statusMsg = 'Please fill all the mandatory fields.';
	}
}
?>