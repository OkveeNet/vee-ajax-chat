<?php
/*
* หน้าแรก หน้าที่ให้กรอกชื่อก่อนเข้าห้องแชท
*/
?>
<div class="page-index">
	<?php if (isset($statusmsg)) {echo $statusmsg;}?>
    <form method="post" action="?act=submit">
    <table>
    	<tbody>
        	<tr>
            	<td>Your name: </td><td><input type="text" name="name" value="<?php if (isset($name)) {echo $name;}?>" /></td>
			</tr>
			<tr>
                <td></td><td><button type="submit" name="btnact" value="submit_name">Submit</button></td>
            </tr>
        </tbody>
    </table>
    </form>
    <span class="txt_error"><noscript>Please enable javascript and reload this page again.</noscript></span>
</div>