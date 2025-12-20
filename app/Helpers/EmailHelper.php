<?php

namespace App\Helpers;

class EmailHelper
{
    /**
     * Send KYC completion email to user
     *
     * @param string $email User's email address
     * @param string $userName User's full name
     * @return bool True if email sent successfully, false otherwise
     */
    public static function sendKycCompletionEmail($email, $userName)
    {
        // Load PHPMailer
        require_once ROOTPATH . 'vendor/autoload.php';
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@valueeducator.com';
            $mail->Password = 'Mailpass@0987';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            
            // Recipients
            $mail->setFrom('noreply@valueeducator.com', 'Value Educator');
            $mail->addAddress($email);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'KYC Verification Completed - Value Educator';
            
            // HTML email template
            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>KYC Verification Completed</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                    }
                    .logo {
                        max-width: 200px;
                    }
                    .content {
                        background-color: #f9f9f9;
                        padding: 30px;
                        border-radius: 10px;
                        margin-bottom: 30px;
                    }
                    .button {
                        display: inline-block;
                        background-color: #6c5ce7;
                        color: #FFFFFF;
                        padding: 12px 24px;
                        text-decoration: none;
                        border-radius: 5px;
                        font-weight: bold;
                    }
                    .footer {
                        text-align: center;
                        font-size: 12px;
                        color: #888;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <img src="https://valueeducator.com/images/logo.svg" alt="Value Educator" class="logo">
                </div>
                
                <div class="content">
                    <h2>KYC Verification Completed</h2>
                    <p>Dear ' . $userName . ',</p>
                    <p>We are pleased to inform you that your KYC verification has been successfully completed. You can now access all the features of your Value Educator account.</p>
                    
                    <h3>What You Can Do Now:</h3>
                    <ul>
                        <li>Purchase subscription plans</li>
                        <li>Access to premium research reports</li>
                        <li>View your portfolio dashboard</li>
                        <li>Get personalized investment recommendations</li>
                    </ul>
                    
                    <p>To purchase a subscription plan, click the button below:</p>
                    <p><a href="https://valueeducator.com/products" class="button">Browse Subscription Plans</a></p>
                    
                    <p>If you have any questions or need assistance, please don\'t hesitate to contact our support team at <a href="mailto:value.educator@gmail.com">value.educator@gmail.com</a>.</p>
                    
                    <p>Thank you for choosing Value Educator!</p>
                </div>
                
                <div class="footer">
                    <p>This email was sent to ' . $email . '. If you believe this was sent in error, please contact us immediately.</p>
                    <p>&copy; ' . date('Y') . ' Value Educator. All rights reserved.</p>
                </div>
            </body>
            </html>
            ';
            
            $mail->Body = $message;
            $mail->AltBody = "Dear $userName,\n\n"
                . "We are pleased to inform you that your KYC verification has been successfully completed. You can now access all the features of your Value Educator account.\n\n"
                . "To purchase a subscription plan, please visit our website and select the plan that best suits your investment needs.\n\n"
                . "If you have any questions or need assistance, please don't hesitate to contact our support team at value.educator@gmail.com.\n\n"
                . "Thank you for choosing Value Educator!\n\n"
                . "Best regards,\n"
                . "Admin Team at Value Educator";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'PHPMailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}