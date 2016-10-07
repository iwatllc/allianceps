<?php
/**
 * Created by PhpStorm.
 * User: aaronfrazer
 * Date: 10/6/16
 * Time: 11:24 AM
 */
?>

<!DOCTYPE html>
<html>
<body>

<h1>Payment Transaction Page</h1>

<p><?php echo $test; ?></p>

<table style="width:100%" border="1px solid black;border-collapse: collapse;">
    <tr>
        <th>Variable Name</th>
        <th>Value</th>
        <th>Optional</th>
    </tr>
    <tr>
        <td>jp_return_hash</td>
        <td><?php echo $jp_return_hash; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>cid</td>
        <td><?php echo $cid; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>cardNum</td>
        <td><?php echo $cardNum; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>card</td>
        <td><?php echo $card; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>chargeTotal</td>
        <td><?php echo $chargeTotal; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>responseText</td>
        <td><?php echo $responseText; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>transId</td>
        <td><?php echo $transId; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>actCode</td>
        <td><?php echo $actCode; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>apprCode</td>
        <td><?php echo $apprCode; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>cvvMatch</td>
        <td><?php echo $cvvMatch; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>addressMatch</td>
        <td><?php echo $addressMatch; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>zipMatch</td>
        <td><?php echo $zipMatch; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>avsMatch</td>
        <td><?php echo $avsMatch; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>ccToken</td>
        <td><?php echo $ccToken; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>name</td>
        <td><?php echo $name; ?></td>
        <td>N</td>
    </tr>
    <tr>
        <td>merOrderNumber</td>
        <td><?php echo $merOrderNumber; ?></td>
        <td>Y</td>
    </tr>
    <tr>
        <td>merUd1</td>
        <td><?php echo $merUd1; ?></td>
        <td>Y</td>
    </tr>
    <tr>
        <td>merUd2</td>
        <td><?php echo $merUd2; ?></td>
        <td>Y</td>
    </tr>
    <tr>
        <td>merUd3</td>
        <td><?php echo $merUd3; ?></td>
        <td>Y</td>
    </tr>
</table>

</body>
</html>

