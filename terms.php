<?php 
	include('admin/mysql/connect.php');
	include('admin/mysql/deck.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	$deckData = new deck();
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com | A scrolls fan site</title>
	<meta name="description" content="A scrolls fan site. Browse over 500 user created decks. View All in-game scrolls. Create your own scroll. " />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
	<?php include("inc_/ad/main.php"); ?>
</head>
<body>

	<?php include('inc_/menu.php') ?>
	
	
	<div class="body" id="blog">
		<div class="container">
			<div class="news">
			<h1>Terms & Conditions</h1>
			
			<br />
			<h2>Introduction</h2>
			
			<p>These terms and conditions govern your use of this website; by using this website, you accept these terms and conditions in full. If you disagree with these terms and conditions or any part of these terms and conditions, you must not use this website.</p>
			
			<p>This website uses cookies. By using this website and agreeing to these terms and conditions, you consent to Scrolldier's use of cookies in accordance with the terms of Scrolldier’s cookies policy.</p>
			
			<br />
			<h2>License to use website</h2>
			
			
			<p>Scrolldier does not own the intellectual property rights for the Scrolls brand, or deriviates, used in the website and material on the website. You may freely distribute content created on Scrolldier (decks, fan-made Scrolls), but must adhere to Mojang’s brand and IP guidelines for Scrolls (<a href="https://scrolls.com/brand" >https://scrolls.com/brand</a>). Under Norwegian law ( § 12), you are allowed to make use of the code used in Scrolldier.com for personal use, but you are not allowed to publish it without the explicit permission of Scrolldier. </p>
			<br />
			
			<h2>Acceptable use</h2>
			
			<p>You must not use this website in any way that causes, or may cause, damage to the website or impairment of the availability or accessibility of the website; or in any way which is unlawful, illegal, fraudulent or harmful, or in connection with any unlawful, illegal, fraudulent or harmful purpose or activity.</p>
			<br />
			<p>You must not use this website to copy, store, host, transmit, send, use, publish or distribute any material which consists of (or is linked to) any spyware, computer virus, Trojan horse, worm, keystroke logger, rootkit or other malicious computer software.</p>
			<br />
			<p>You must not conduct any systematic or automated data collection activities (including without limitation scraping, data mining, data extraction and data harvesting) on or in relation to this website without the explicit permission of Scrolldier. </p>
			<br />
			<p>You must not use this website to transmit or send unsolicited commercial communications without the explicit permission of Scrolldier. </p>
			<br />
			<p>You must not use this website for any purposes related to marketing without the explicit permission of Scrolldier. </p>
			<br />
			<p>You must not use this website to harm or harass other people, whether these people have accounts with Scrolldier or not. </p>
			
			<br />
			<h2>Restricted access</h2>
			<br />
			<p>Scrolldier reserves the right to restrict access to admin areas of this website, or indeed this entire website, at Scrolldier’s discretion.</p>
			<br />
			<p>If Scrolldier provides you with a user ID and password to enable you to access restricted areas of this website or other content or services, you must ensure that the user ID and password are kept confidential. </p>
			<br />
			<p>Scrolldier may revoke access given to restricted areas of the site without notice or explanation. </p>
			<br />
			<h2>User content</h2>
			<br />
			<p>In these terms and conditions, “your user content” means material (including without limitation text, images, audio material, video material and audio-visual material) that you submit to this website, for whatever purpose.</p>
			<br />
			<p>You grant to Scrolldier a worldwide, irrevocable, non-exclusive, royalty-free license to use, reproduce, adapt, publish, translate and distribute your user content in any existing or future media. </p>
			<br />
			<p>Your user content must not be illegal or unlawful, must not infringe any third party's legal rights, and must not be capable of giving rise to legal action whether against you or Scrolldier or a third party (in each case under any applicable law). </p>
			<br />
			<p>You must not submit any user content to the website that is or has ever been the subject of any threatened or actual legal proceedings or other similar complaint.</p>
			<br />
			<p>Scrolldier reserves the right to edit or remove any material submitted to this website, or stored on Scrolldier’s servers, or hosted or published upon this website.</p>
			<br />
			<p>Notwithstanding Scrolldier’s rights under these terms and conditions in relation to user content, Scrolldier does not undertake to monitor the submission of such content to, or the publication of such content on, this website.</p>
			
			<br />
			<h2>Cookies policy</h2>
			
			<br />
			<p>Scrolldier will use cookies to enhance the user experience of <a href="http://www.scrolldier.com" >www.scrolldier.com</a>. Scrolldier’s use of cookies will be treated as any other identifying information users voluntarily give to Scrolldier. </p>
			<br />
			<h2>No warranties</h2>
			<br />
			<p>This website is provided “as is” without any representations or warranties, express or implied. Scrolldier makes no representations or warranties in relation to this website or the information and materials provided on this website. </p>
			<br />
			<p>Without prejudice to the generality of the foregoing paragraph, Scrolldier does not warrant that:</p>
			<ul>
				<li>this website will be constantly available, or available at all; or</li>
				<li>the information on this website is complete, true, accurate or non-misleading.</li>
			</ul>
			
			<p>Nothing on this website constitutes, or is meant to constitute, advice of any kind. </p>
			
			<br />
			<h2>Limitations of liability</h2>
			<br />
			<p>Scrolldier will not be liable to you (whether under the law of contact, the law of torts or otherwise) in relation to the contents of, or use of, or otherwise in connection with, this website:</p>
			<br />
			<ul>
				<li>to the extent that the website is provided free-of-charge, for any direct loss;</li>
				<li>for any indirect, special or consequential loss; or</li>
				<li>for any business losses, loss of revenue, income, profits or anticipated savings, loss of contracts or business relationships, loss of reputation or goodwill, or loss or corruption of information or data.</li>
			</ul>
			<br />
			<p>These limitations of liability apply even if Scrolldier has been expressly advised of the potential loss.</p>
			<br />
			<h2>Exceptions</h2>
			<br />
			<p>Nothing in this website disclaimer will exclude or limit any warranty implied by law that it would be unlawful to exclude or limit; and nothing in this website disclaimer will exclude or limit Scrolldier’s liability in respect of any:</p>
			<br />
			<ul>
				<li>fraud or fraudulent misrepresentation on the part of Scrolldier; or</li>
				<li>matter which it would be illegal or unlawful for Scrolldier to exclude or limit, or to attempt or purport to exclude or limit, its liability.</li>
			</ul>
			<br />
			<h2>Reasonableness</h2>
			<br />
			<p>By using this website, you agree that the exclusions and limitations of liability set out in this website disclaimer are reasonable. </p>
			<br />
			<p>If you do not think they are reasonable, you must not use this website.</p>
			<br />
			<h2>Other parties</h2>
			<br />
			<p>You accept that, as a limited liability entity, Scrolldier has an interest in limiting the personal liability of its officers and employees. You agree that you will not bring any claim personally against Scrolldier’s officers or employees in respect of any losses you suffer in connection with the website.</p>
			<br />
			<p>You agree that the limitations of warranties and liability set out in this website disclaimer will protect Scrolldier’s officers, employees, agents, subsidiaries, successors, assigns and sub-contractors as well as Scrolldier.</p>
			<br />
			<p>Unenforceable provisions</p>
			<br />
			<p>If any provision of this website disclaimer is, or is found to be, unenforceable under applicable law, that will not affect the enforceability of the other provisions of this website disclaimer.</p>
			<br />
			<h2>Indemnity</h2>
			<br />
			<p>You hereby indemnify Scrolldier and undertake to keep Scrolldier indemnified against any losses, damages, costs, liabilities and expenses (including without limitation legal expenses and any amounts paid by Scrolldier to a third party in settlement of a claim or dispute on the advice of Scrolldier’s legal advisers) incurred or suffered by Scrolldier arising out of any breach by you of any provision of these terms and conditions, or arising out of any claim that you have breached any provision of these terms and conditions.</p>
			<br />
			<h2>Breaches of these terms and conditions</h2>
			<br />
			<p>Without prejudice to Scrolldier’s other rights under these terms and conditions, if you breach these terms and conditions in any way, Scrolldier may take such action as Scrolldier deems appropriate to deal with the breach, including suspending your access to the website, prohibiting you from accessing the website, blocking computers using your IP address from accessing the website, contacting your internet service provider to request that they block your access to the website and/or bringing court proceedings against you.</p>
			<br />
			<h2>Variation</h2>
			<br />
			<p>Scrolldier may revise these terms and conditions from time-to-time. Revised terms and conditions will apply to the use of this website from the date of the publication of the revised terms and conditions on this website. Please check this page regularly to ensure you are familiar with the current version.</p>
			<br />
			<h2>Assignment</h2>
			<br />
			<p>Scrolldier may transfer, sub-contract or otherwise deal with Scrolldier’s rights and/or obligations under these terms and conditions without notifying you or obtaining your consent.</p>
			<br />
			<p>You may not transfer, sub-contract or otherwise deal with your rights and/or obligations under these terms and conditions. </p>
			<br />
			<h2>Severability</h2>
			<br />
			<p>If a provision of these terms and conditions is determined by any court or other competent authority to be unlawful and/or unenforceable, the other provisions will continue in effect. If any unlawful and/or unenforceable provision would be lawful or enforceable if part of it were deleted, that part will be deemed to be deleted, and the rest of the provision will continue in effect.</p>
			<br />
			<h2>Entire agreement</h2>
			<br />
			<p>These terms and conditions, constitute the entire agreement between you and Scrolldier in relation to your use of this website, and supersede all previous agreements in respect of your use of this website.</p>
			<br />
			<h2>Law and jurisdiction</h2>
			<br />
			<p>These terms and conditions will be governed by and construed in accordance with Norwegian law, and any disputes relating to these terms and conditions will be subject to the exclusive jurisdiction of the Norwegian or EU courts.</p>
			<br />
			<h2>Registrations and authorisations</h2>
			
			<br />
			<p>Scrolldier was created by Agne Ødegaard also knows as Orangee</p>
			<br />
			<p>You can contact Scrolldier by email to <a href="mailto:support@scrolldier.com">support@scrolldier.com</a>.</p>
			
			<br />
				</div>
		</div>
	</div>
	<?php include("inc_/footer.php"); ?>
</body>
</html>