<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $email_subject; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<body style="background: #f8f9fa; color: #4e566d; font-size: 14px; font-family: sans-serif, Tahoma; margin: 0; padding: 20px; line-height: 1.3;">
    <table bgcolor="#fff" border="0" align="center" cellpadding="0" cellspacing="0" width="650" style="border: 1px solid #eee; border-radius: 4px;">
        <tr valign="middle">
            <td style="border-bottom: 5px solid #293940;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="25%" style="padding: 20px 15px" align="left">
                            <a href="<?php echo base_url(); ?>" style="display: inline-block;">
                                <img src="<?= !empty($site_settings->site_logo) ? get_site_image_src('images', $site_settings->site_logo . '?v-' . $site_settings->site_version) : 'http://placehold.it/700x620' ?>" alt="<?= $site_settings->site_name ?> Logo" style="height: 50px" align="left">
                            </a>
                        </td>
                        <td style="font-size: 12px; font-weight: bold; padding: 20px 15px; line-height: 1.5; text-align: right;">
                            <?php echo date("d M, Y"); ?><br>
                            <?php echo date("h:i A"); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td valign="top" bgcolor="#fafafa" style="padding: 50px 15px;">
                            <?php echo $email_body; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#293940" class="footer" style="color:#fff; font-size: 12px; padding: 15px; text-align: center; border-radius: 0 0 4px  4px;">
                Copyright © <?= date("Y") ?> <a href="<?= site_url() ?>" style="color: #2cb1ff; text-decoration: none;"> <?= $site_settings->site_name ?></a>.
            </td>
        </tr>
    </table>
</body>

</html>