<script>
function timer(stamp)
                {
                    var temp=stamp;
                    temp=temp-1;
                    document.getElementById('mylbl').innerHTML = temp;
                   
                    setTimeout("timer("+temp+")",1000); 
                }



    </script>

</head>

<body bgcolor="black" text="white" onload="timer(3+1)" >

    

<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */
/*$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];*/
// an email address that will be in the From field of the email.
$from = 'info@adandland.com';

// an email address that will receive the email with the output of the form
$sendTo = 'info@adandland.com';

// subject of the email
$subject = 'New message from contact form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Customer Name', 'email' => 'Email', 'message' => 'Message'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(0);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "You have a new message from your contact form\n=============================\n";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
    echo "<label id=mylbl></label>" ;
        echo " Seconds";        
    $redicet = $_SERVER['HTTP_REFERER'];
    header("Refresh: 3; url=".$redicet);
}
// else just display the message
else {
    echo $responseArray['message'];
    echo "<label id=mylbl></label>" ;
        echo " Seconds";        
    $redicet = $_SERVER['HTTP_REFERER'];
    header("Refresh: 3; url=".$redicet);
}

?>