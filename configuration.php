<?php
include("header.php");

if(isset($_POST)) {

    if (count($_POST) > 1) {
        if (!check_allow()) {
            ?>
            <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#sa-title').trigger('click');
                });
            </script>
        <?php
        } else {
            // Content that will be written to the config file
            $content = "<?php\n";
            $content .= "\$config['db']['host'] = '" . addslashes($config['db']['host']) . "';\n";
            $content .= "\$config['db']['name'] = '" . addslashes($config['db']['name']) . "';\n";
            $content .= "\$config['db']['user'] = '" . addslashes($config['db']['user']) . "';\n";
            $content .= "\$config['db']['pass'] = '" . addslashes($config['db']['pass']) . "';\n";
            $content .= "\$config['db']['pre'] = '" . addslashes($config['db']['pre']) . "';\n";
            $content .= "\n";
            $content .= "\$config['site_title'] = '" . addslashes($_POST['site_title']) . "';\n";
            $content .= "\$config['site_url'] = '" . addslashes($_POST['site_url']) . "';\n";
            $content.= "\$config['admin_email'] = '".addslashes($_POST['admin_email'])."';\n";
            $content .= "\n";
            $content .= "\$config['tpl_name'] = '" . addslashes(stripslashes($_POST['tpl_name'])) . "';\n";
            $content .= "\$config['tpl_color'] = '" . addslashes(stripslashes($_POST['tpl_color'])) . "';\n";
            $content .= "\n";
            $content .= "\$config['lang'] = '" . addslashes($_POST['lang']) . "';\n";
            $content .= "\$config['userlangsel'] = '" . addslashes($_POST['userlangsel']) . "';\n";
            $content .= "\n";
            $content .= "\$config['fbappid'] = '" . addslashes($_POST['fbappid']) . "';\n";
            $content .= "\$config['fbappsecret'] = '" . addslashes($_POST['fbappsecret']) . "';\n";
            $content .= "\n";
            $content .= "\$config['transfer_filter'] = '" . $_POST['transfer_filter'] . "';\n";
            $content.= "\$config['purchase_key'] = '".$config['purchase_key']."';\n";
            $content .= "\$config['version'] = '" . $config['version'] . "';\n";
            $content .= "\$config['installed'] = '1';\n";
            $content .= "?>";

            // Open the config.php for writting
            $handle = fopen('../config.php', 'w');
            // Write the config file
            fwrite($handle, $content);
            // Close the file
            fclose($handle);

            transfer($config, 'configuration.php', 'Configuration Saved');
            exit;
        }
    }
}

?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Configuration</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li class="active">Configuration</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- /row -->
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-info">
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">


                            <div class="col-md-12">
                                <div class="white-box">
                                    <!--<h3 class="box-title m-b-0">Configuration</h3>-->
                                    <!--<p class="text-muted m-b-30 font-13"></p>-->
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label"><span class="mytooltip tooltip-effect-1"><span class="tooltip-item2">Site Title (?)</span><span class="tooltip-content4 clearfix"><span class="tooltip-text2"><strong>Site title</strong> is what you would like your website to be known as, this will be used in emails and in the title of your webpages.</span></span></span></label>
                                            <div class="col-sm-9">
                                                <input name="site_title" class="form-control" type="Text" id="site_title" value="<?php echo stripslashes($config['site_title']);?>"  style="width:60%;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label"><span class="mytooltip tooltip-effect-1"><span class="tooltip-item2">Chat Url (?)</span><span class="tooltip-content4 clearfix"><span class="tooltip-text2"><strong>Chat Url</strong> is the url where you installed Chat. The exact path of Chat on your domain. It's Must to add / at the end of url</span></span></span></label>
                                            <div class="col-sm-9">
                                                <input name="site_url" type="Text" class="form-control" id="site_url" value="<?php echo stripslashes($config['site_url']);?>"  style="width:60%;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label"><span class="mytooltip tooltip-effect-1"><span class="tooltip-item2">Admin Email (?)</span><span class="tooltip-content4 clearfix"><span class="tooltip-text2">This is the email address that the contact and report emails will be sent to, aswell as being the from address in mail this chat emails.</span></span></span></label>
                                            <div class="col-sm-9">
                                                <input name="admin_email" type="Text" class="form-control" id="admin_email" value="<?php echo stripslashes($config['admin_email']);?>"  style="width:60%;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label"><span class="mytooltip tooltip-effect-1"><span class="tooltip-item2">Chat Language (?)</span><span class="tooltip-content4 clearfix"><span class="tooltip-text2"><strong>Chat Language</strong>  field allows you to change which language the script will use.</span></span></span></label>
                                            <div class="col-sm-9">
                                                <select name="lang" id="lang" class="form-control" style="width:60%">
                                                    <?php
                                                    $langs = array();

                                                    if ($handle = opendir('../includes/lang/'))
                                                    {
                                                        while (false !== ($file = readdir($handle)))
                                                        {
                                                            if ($file != "." && $file != "..")
                                                            {
                                                                $lang2 = str_replace('.php','',$file);
                                                                $lang2 = str_replace('lang_','',$lang2);

                                                                $langs[] = $lang2;
                                                            }
                                                        }
                                                        closedir($handle);
                                                    }

                                                    sort($langs);

                                                    foreach ($langs as $key => $lang2)
                                                    {
                                                        if($config['lang'] == $lang2)
                                                        {
                                                            echo '<option value="'.$lang2.'" selected>'.ucwords($lang2).'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value="'.$lang2.'">'.ucwords($lang2).'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword4" class="col-sm-3 control-label">Allow User Language Selection</label>
                                            <div class="col-sm-9">
                                                <select name="userlangsel" class="form-control" id="userlangsel" style="width:60%;">
                                                    <option value="1" <?php if($config['userlangsel'] == 1){ echo "selected"; } ?>>Yes</option>
                                                    <option value="0" <?php if($config['userlangsel'] == 0){ echo "selected"; } ?>>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword4" class="col-sm-3 control-label">Theme Version</label>
                                            <div class="col-sm-9">
                                                <select name="tpl_name" class="form-control" id="tpl_name" style="width:60%;">
                                                    <option value="style-light" <?php if($config['tpl_name'] == "style-light"){ echo "selected"; } ?>>Light Theme</option>
                                                    <option value="style-dark" <?php if($config['tpl_name'] == "style-dark"){ echo "selected"; } ?>>Dark Theme</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword4" class="col-sm-3 control-label">Theme Color</label>
                                            <div class="col-sm-9">
                                                <select name="tpl_color" id="tpl_color" class="form-control" style="width:60%">
                                                    <?php
                                                    $langs = array();

                                                    if ($handle = opendir('assets/css/colors/'))
                                                    {
                                                        while (false !== ($file = readdir($handle)))
                                                        {
                                                            if ($file != "." && $file != "..")
                                                            {
                                                                $lang2 = str_replace('.css','',$file);
                                                                //$lang2 = str_replace('lang_','',$lang2);

                                                                $langs[] = $lang2;
                                                            }
                                                        }
                                                        closedir($handle);
                                                    }

                                                    sort($langs);

                                                    foreach ($langs as $key => $lang2)
                                                    {
                                                        if($config['tpl_color'] == $lang2)
                                                        {
                                                            echo '<option value="'.$lang2.'" selected>'.ucwords($lang2).'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value="'.$lang2.'">'.ucwords($lang2).'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Transfer Filter  (<a class="mytooltip" href="javascript:void(0)">?<span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">Whether you should be shown a transfer screen between saving admin pages or not</span></span></span></a>)</label>
                                            <div class="col-sm-9">
                                                <select name="transfer_filter" class="form-control" id="transfer_filter" style="width:60%;">
                                                    <option value="1" <?php if($config['transfer_filter'] == 1){ echo "selected"; } ?>>Yes</option>
                                                    <option value="0" <?php if($config['transfer_filter'] == 0){ echo "selected"; } ?>>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Facebook App ID (<a class="mytooltip" href="javascript:void(0)">?<span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">Facebook app id using for facebook login api: Insert your facebook app id</span></span></span></a>)</label>
                                            <div class="col-sm-9">
                                                <input name="fbappid" class="form-control" type="password" id="fbappid" value="<?php echo stripslashes($config['fbappid']);?>"  style="width:60%;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Facebook App Secret (<a class="mytooltip" href="javascript:void(0)">?<span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">Facebook app secret using for facebook login api: Insert your facebook app secret</span></span></span></a>)</label>
                                            <div class="col-sm-9">
                                                <input name="fbappsecret" class="form-control" type="password" id="fbappsecret" value="<?php echo stripslashes($config['fbappsecret']);?>"  style="width:60%;">
                                            </div>
                                        </div>
                                        <div class="form-group m-b-0">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button name="Submit" type="submit" class="btn btn-info waves-effect waves-light m-t-10">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php include("footer.php"); ?>
