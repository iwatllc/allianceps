<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="viewport" content="width=device-width" /><!-- IMPORTANT -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Order Confirmation</title>

<!-- <link rel="stylesheet" type="text/css" href="stylesheets/email.css" /> -->
<style>
	/* -------------------------------------
			GLOBAL
	------------------------------------- */
	* {
		margin:0;
		padding:0;
	}
	* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

	img {
		max-width: 100%;
	}
	.collapse {
		margin:0;
		padding:0;
	}
	body {
		-webkit-font-smoothing:antialiased;
		-webkit-text-size-adjust:none;
		width: 100%!important;
		height: 100%;
	}


	/* -------------------------------------
			ELEMENTS
	------------------------------------- */
	a { color: #2BA6CB;}

	.btn {
		text-decoration:none;
		color:#FFF;
		background-color:#666;
		width:80%;
		padding:15px 10%;
		font-weight:bold;
		text-align:center;
		cursor:pointer;
		display:inline-block;
	}

	p.callout {
		padding:15px;
		text-align:center;
		background-color:#ECF8FF;
		margin-bottom: 15px;
	}
	.callout a {
		font-weight:bold;
		color: #2BA6CB;
	}

	.column table { width:100%;}
	.column {
		width: 300px;
		float:left;
	}
	.column tr td { padding: 15px; }
	.column-wrap {
		padding:0!important;
		margin:0 auto;
		max-width:600px!important;
	}
	.columns .column {
		width: 280px;
		min-width: 279px;
		float:left;
	}
	table.columns, table.column, .columns .column tr, .columns .column td {
		padding:0;
		margin:0;
		border:0;
		border-collapse:collapse;
	}

	/* -------------------------------------
			HEADER
	------------------------------------- */
	table.head-wrap { width: 100%;}

	.header.container table td.logo { padding: 15px; }
	.header.container table td.label { padding: 15px; padding-left:0px;}


	/* -------------------------------------
			BODY
	------------------------------------- */
	table.body-wrap { width: 100%;}


	/* -------------------------------------
			FOOTER
	------------------------------------- */
	table.footer-wrap { width: 100%;	clear:both!important;
	}
	.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
	.footer-wrap .container td.content p {
		font-size:10px;
		font-weight: bold;

	}


	/* -------------------------------------
			TYPOGRAPHY
	------------------------------------- */
	h1,h2,h3,h4,h5,h6 {
	font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
	}
	h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

	h1 { font-weight:200; font-size: 44px;}
	h2 { font-weight:200; font-size: 37px;}
	h3 { font-weight:500; font-size: 27px;}
	h4 { font-weight:500; font-size: 23px;}
	h5 { font-weight:900; font-size: 17px;}
	h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

	.collapse { margin:0!important;}

	p, ul {
		margin-bottom: 10px;
		font-weight: normal;
		font-size:14px;
		line-height:1.6;
	}
	p.lead { font-size:17px; }
	p.last { margin-bottom:0px;}

	ul li {
		margin-left:5px;
		list-style-position: inside;
	}

	hr {
	    border: 0;
	    height: 0;
	    border-top: 1px dotted rgba(0, 0, 0, 0.1);
	    border-bottom: 1px dotted rgba(255, 255, 255, 0.3);
	}


	/* -------------------------------------
			Shopify
	------------------------------------- */

	.products {
		width:100%;
		height:40px;
		margin:10px 0 10px 0;
	}
	.products img {
		float:left;
		height:40px;
		width:auto;
		margin-right:20px;
	}
	.products span {
		font-size:17px;
	}


	/* ---------------------------------------------------
			RESPONSIVENESS
			Nuke it from orbit. It's the only way to be sure.
	------------------------------------------------------ */

	/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
	.container {
		display:block!important;
		max-width:600px!important;
		margin:0 auto!important; /* makes it centered */
		clear:both!important;
	}

	/* This should also be a block element, so that it will fill 100% of the .container */
	.content {
		padding:15px;
		max-width:600px;
		margin:0 auto;
		display:block;
	}

	/* Let's make sure tables in the content area are 100% wide */
	.content table { width: 100%; }

	/* Be sure to place a .clear element after each set of columns, just to be safe */
	.clear { display: block; clear: both; }


	/* -------------------------------------------
			PHONE
			For clients that support media queries.
			Nothing fancy.
	-------------------------------------------- */
	@media only screen and (max-width: 600px) {

		a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

		div[class="column"] { width: auto!important; float:none!important;}

		table.social div[class="column"] {
			width:auto!important;
		}

	}
</style>

</head>

<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#d3d3d3">
	<tr>
		<td></td>
		<td class="header container">

				<div class="content">
					<table bgcolor="#d3d3d3">
						<tr>
							<td>
                              <a href="<?php echo base_url('paymentform/'.$slugname); ?>" title="<?php echo $customerName; ?>" alt="<?php echo $customerName; ?>" />
                                <?php
                                  if ($showlogo == '1')
                                  {
                                    if (isset($logofile))
                                    {
                                      ?><img src = "<?php echo base_url('client/uploads/'.$logofile); ?>" alt = "" style="width:70px;height:auto;" ><?php
                                    }
                                  } else
                                  {
                                    ?><h6 class="collapse"><?php echo $customerName; ?></h6><?php
                                  }
                                ?>
                              </a>
							</td>
							<td align="right">
								<h6 class="collapse">Order Confirmation</h6>
							</td>
						</tr>
					</table>
				</div>

		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->

<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table>
				<tr>
					<td>
						<br/>
						<h3><?php echo $name; ?>,</h3>

						<br/>

						<h4>Your order has been submitted.</h4>
						<p>Thank you for placing your order with <strong><?php echo $customerName; ?></strong>.
							This email is to confirm your order has been placed successfully.</p>

						<br/>

						<h4 style="background-color:#d3d3d3;">Order Information</h4>
						<p><strong>Order Number:</strong> <?php echo $order_number; ?></p>
						<p><strong>Date of Order:</strong> <?php echo date("m/d/y g:i A"); ?></p>

						<br/>

						<h4 style="background-color:#d3d3d3;">Customer Information</h4>
						<p><?php echo $name; ?></p>
						<p><?php echo $customerEmail; ?></p>
						<p><?php echo $address . ' ' . $address2; ?></p>
						<p><?php echo $city . ', ' . $state . ' ' . $zip ?></p>

						<br/>

						<h4 style="background-color:#d3d3d3;">Payment Information</h4>
						<p><strong>Name:</strong> <?php echo $name; ?></p>
						<?php if ($paymenttype == 'cc') { ?>
							<p><strong>Card Type:</strong><?php echo $cardName; ?></p>
							<p><strong>Credit Card Number:</strong> **** **** **** <?php echo $cardNum; ?></p>
							<p><strong>Expiration Date:</strong> <?php echo $expDate; ?></p>
						<?php } else { ?>
							<p><strong>Account Number:</strong> **<? echo $obfDdaNum; ?></p>
						<?php } ?>

						<br/>

						<h4 style="background-color:#d3d3d3;">Your Order</h4>
						<p><strong>Payment Method:</strong> <?php echo $paymentMethod; ?></p>
						<p><strong>Subtotal:</strong> <?php echo $subtotal; ?></p>
						<p><strong>Convenience Fee:</strong> <?php echo $cfAmount . ' ' . $cfPercentage; ?></p>
						<h5><strong>Total:</strong> $<?php echo $total; ?></h5>
						
						<br/>
						<br/>

					</td>
				</tr>
			</table>
			</div>

		</td>
		<td></td>
	</tr>
</table>
<!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap" bgcolor="#d3d3d3">
	<tr>
		<td></td>
		<td class="container">

				<!-- content -->
				<div class="content">
				<table>
				<tr>
					<td align="center">
						<p>Thank you for doing business with <a href="<?php echo $customerName; ?>" style="color:#111111;"><?php echo $customerName; ?></a>!</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->

		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>