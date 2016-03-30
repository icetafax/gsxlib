<?php 

	/**
	 * This example mimics the serial number lookup for WarrantyStatus in GSX.
	 * Updated to send shipTo as required by the May 2016 release of GSX.
	 */

	require 'gsxlib/gsxlib.php';

	$sold_to = '';
	$ship_to = '';
	$username = '';
	$serialnumber = '';

		$_ENV['GSX_CERT'] = '/path/to/certificate';
        $_ENV['GSX_KEYPASS'] = '';

        try {
        $gsx = GsxLib::getInstance($sold_to, $username);
        $info = $gsx->warrantyStatus($serialnumber, $ship_to);
        } catch (SoapFault $e) {
            var_dump($e->faultstring);
            die;
        }

 ?>

 <table>
 	<tr>
 		<td><strong>Serial Number:</strong> <?= $info->serialNumber ?></td>
 	</tr>
 	<tr>
 		<td><strong>Warranty Status:</strong> <?= $info->warrantyStatus ?></td>
 	</tr>
 	<tr>
 		<td><strong>Days remaining:</strong> <?= $info->daysRemaining ?></td>
 	</tr>
 	<tr>
 		<td><strong>Estimated Purchase Date:</strong> <?= $info->estimatedPurchaseDate ?></td>
 	</tr>
 	<tr>
 		<td><strong>Purchase Country:</strong> <?= $info->purchaseCountry ?></td>
 	</tr>
 	<tr>
 		<td><strong>Product Description:</strong> <?= $info->productDescription ?></td>
 	</tr>
 	<tr>
 		<td><strong>Config Description:</strong> <?= $info->configDescription ?></td>
 	</tr>
 	<tr>
 		<td><strong>Activation Lock Status:</strong> <?= $info->activationLockStatus ?></td>
 	</tr>
 	
 </table>
