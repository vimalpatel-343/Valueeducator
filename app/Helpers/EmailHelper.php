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
            $mail->Password = 'Value@100kk';
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
                            background-color: #ffffff;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                        }
                        .logo {
                            max-width: 200px;
                        }
                        ul {
                            padding-left: 20px;
                        }
                        ul li {
                            margin-bottom: 8px;
                        }
                        .footer {
                            text-align: center;
                            font-size: 12px;
                            color: #777;
                            margin-top: 30px;
                        }
                    </style>
                </head>
                <body>

                    <div class="content">
                        <p>Dear <strong>' . htmlspecialchars($userName) . '</strong>,</p>

                        <p>
                            We’re writing to inform you that your <strong>KYC verification has been successfully completed</strong>.
                        </p>

                        <p>
                            With this step completed, your access to the <strong>Value Educator</strong> platform is now fully enabled,
                            and you can start using the features included in your subscription.
                        </p>

                        <p><strong>You can now:</strong></p>
                        <ul>
                            <li>Access detailed premium research reports in the <strong>Portfolio</strong> section</li>
                            <li>Watch detailed interactions with managements in the <strong>Knowledge Centre</strong></li>
                            <li>Read <strong>Scuttlebutt notes</strong> and qualitative insights</li>
                            <li>Stay updated with stock-wise developments within the portfolio</li>
                        </ul>

                        <p>
                            To get started, simply log in to your account and explore the research at your own pace.
                        </p>

                        <p>
                            If you have any questions or need assistance while navigating the platform,
                            feel free to reach out to us at
                            <a href="mailto:value.educator@gmail.com">value.educator@gmail.com</a>.
                            Our team will be happy to help.
                        </p>

                        <p>
                            Thank you for completing the process. We look forward to supporting your investment journey
                            with disciplined, research-driven insights.
                        </p>

                        <p>
                            <strong>Warm regards,</strong><br>
                            Team Value Educator
                        </p>
                    </div>

                    <div class="footer">
                        <p>This email was sent to ' . htmlspecialchars($email) . '</p>
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

    /**
     * Send subscription confirmation email to user with PDF attachment
     *
     * @param string $email User's email address
     * @param string $userName User's full name
     * @param string $productName Name of the subscribed product
     * @param string $pdfPath Path to the PDF file to attach
     * @return bool True if email sent successfully, false otherwise
     */
    public static function sendSubscriptionConfirmationEmail($email, $userName, $productName, $pdfPath = null)
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
            $mail->Password = 'Value@100kk';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            
            // Recipients
            $mail->setFrom('noreply@valueeducator.com', 'Value Educator');
            $mail->addAddress($email);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to ' . htmlspecialchars($productName) . ' - Value Educator';
            
            // HTML email template
            $message = '
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Subscription Confirmation</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            background-color: #ffffff;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                        }
                        .logo {
                            max-width: 200px;
                        }
                        ul {
                            padding-left: 20px;
                        }
                        ul li {
                            margin-bottom: 8px;
                        }
                        .footer {
                            text-align: center;
                            font-size: 12px;
                            color: #777;
                            margin-top: 30px;
                        }
                        .important-notes {
                            background-color: #f8f9fa;
                            border-left: 4px solid #9155F1;
                            padding: 15px;
                            margin: 20px 0;
                        }
                        .disclaimer {
                            background-color: #f8f9fa;
                            border-left: 4px solid #dc3545;
                            padding: 15px;
                            margin: 20px 0;
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Welcome to ' . htmlspecialchars($productName) . '</h1>
                    </div>

                    <div class="content">
                        <p>Dear <strong>' . htmlspecialchars($userName) . '</strong>,</p>

                        <p>
                            Greetings for the day!<br>
                            Welcome to ' . htmlspecialchars($productName) . ',
                        </p>

                        <p>
                            SNM Value Educator Research Services LLP is a SEBI (Securities and Exchange Boards of India) registered Research Analyst having registration number: INH000019789 offering research services.
                        </p>

                        <p>
                            You are receiving this mail as you have subscribed to our research services.
                        </p>

                        <p>
                            We request you to kindly go through this welcome email and visit our website (valueeducator.com) and if you have any query feel free to reach out to us at 8779064899.
                        </p>

                        <div class="important-notes">
                            <h3>Important Notes</h3>
                            <ol>
                                <li>You need to do the KYC before Proceeding ahead with the service 
                                    <a href="https://onboarding.dashboardfinreport.com/SNM/Login3.aspx?a=dB3PRvGG3NSoxvlY1C3epQ6ET+IyHkpmdlpHz7jmk54=&p=" target="_blank">Click here for KYC</a>
                                </li>
                                <li>We do not provide profit guaranteed or committed returns. In case any person is trying to sell you such services do inform us at 8779064899. Also, we do not sell any profit sharing services.</li>
                                <li>We are not engaged in Managing funds, Portfolio Management or investment advisory services.</li>
                                <li>We are not liable for any trade/investment losses incurred based on the research provided, and clients have no right to claim compensation for any losses under any circumstances.</li>
                                <li>Please pay our service charges only in the bank account mentioned on our website. If anyone ask for payment in the personal bank account, kindly inform us at 8779064899.</li>
                            </ol>
                        </div>

                        <div class="disclaimer">
                            <h3>Disclaimer</h3>
                            <ol>
                                <li>Investments in the securities market are subject to market risks. Read all the related documents carefully before investing.</li>
                                <li>Registration granted by SEBI, Enlistment as RA with Exchange and certification from NISM in no way guarantee performance of the intermediary or provide any assurance of returns to investors.</li>
                                <li>We do not recommend any stock broker to the clients.</li>
                                <li>We do not operate any trading or Demat account of any client.</li>
                                <li>We do not offer any distribution or execution services.</li>
                                <li>We do not share any information of our client with any third-party vendors and companies nor do we store details of customer debit and credit cards in our database.</li>
                                <li>All the research recommendations are based on proper technical and fundamental analysis.</li>
                            </ol>
                        </div>

                        <p>
                            <strong>Our scope of work is restricted to offering the research recommendations.</strong>
                        </p>

                        <p>
                            Investment in securities is subject to market risk, though sufficient research has been done but there is no surety of return or accuracy of any kind of guaranteed returns. Clients are recommended to consider all the research recommendations as just an opinion and make investment decisions on their own. In case of any query feel free to contact us at value.educator@gmail.com.
                        </p>

                        <p>
                            <strong>Regards,</strong><br>
                            SNM Value Educator Research Services LLP<br>
                            SEBI Registration Research Analyst<br>
                            Reg No - INH000019789
                        </p>
                    </div>

                    <div class="footer">
                        <p>This email was sent to ' . htmlspecialchars($email) . '</p>
                        <p>&copy; ' . date('Y') . ' Value Educator. All rights reserved.</p>
                    </div>
                </body>
                </html>
            ';
            
            $mail->Body = $message;
            $mail->AltBody = "Dear $userName,\n\n"
                . "Greetings for the day!\n"
                . "Welcome to $productName,\n\n"
                . "SNM Value Educator Research Services LLP is a SEBI registered Research Analyst with registration number INH000019789 offering research services.\n\n"
                . "You are receiving this mail as you have subscribed to our research services.\n\n"
                . "Important Notes:\n"
                . "1. You need to do the KYC before proceeding with the service: https://onboarding.dashboardfinreport.com/SNM/Login3.aspx?a=dB3PRvGG3NSoxvlY1C3epQ6ET+IyHkpmdlpHz7jmk54=&p=\n"
                . "2. We do not provide profit guaranteed or committed returns.\n"
                . "3. We are not engaged in Managing funds, Portfolio Management or investment advisory services.\n"
                . "4. We are not liable for any trade/investment losses.\n"
                . "5. Please pay our service charges only in the bank account mentioned on our website.\n\n"
                . "Disclaimer:\n"
                . "1. Investments in securities market are subject to market risks.\n"
                . "2. Registration does not guarantee performance.\n"
                . "3. We do not recommend any stock broker.\n"
                . "4. We do not operate trading or Demat accounts.\n"
                . "5. We do not offer distribution services.\n"
                . "6. We do not share client information.\n"
                . "7. Research recommendations are based on technical and fundamental analysis.\n\n"
                . "Our scope is restricted to offering research recommendations.\n\n"
                . "Regards,\n"
                . "SNM Value Educator Research Services LLP\n"
                . "SEBI Registration Research Analyst\n"
                . "Reg No - INH000019789";
            
            // Attach PDF if provided
            if ($pdfPath && file_exists($pdfPath)) {
                $mail->addAttachment($pdfPath, 'Subscription_Details.pdf');
            }
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'PHPMailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}