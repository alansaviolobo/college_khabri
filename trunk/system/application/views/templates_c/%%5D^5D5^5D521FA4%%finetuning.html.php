<?php /* Smarty version 2.6.22, created on 2009-04-02 06:19:35
         compiled from finetuning.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'finetuning.html', 16, false),)), $this); ?>
<?php echo '
<style type="text/css"><!--
body { background-image: url(images/back-main-college-khabri.jpg); }
.style1 { color: #b63148; font-weight: bold; }
.style3 { font-size: small; color: #666666; }
.style5 { color: #999999; font-style: italic; }
--></style>
'; ?>

<div style="width:717px; height:auto;margin:auto;border: 1px solid #c7c7c7;font-family:Arial, Helvetica, sans-serif;padding:5px;">
    <p style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:24pt;letter-spacing:-1px;">Search Colleges</p>
    <form method="post" action="welcome/search_results">
        <span align="left" class="style1">University</span><br>
        <span align="left">
            <select name="university">
                <option value="" selected="selected">Select One</option>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['universities']), $this);?>

            </select>
            <br><br>
        </span>
        <span class="style1">District</span>
        <div>
            <span id="districts_div">
                <select name="districts[]">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['districts']), $this);?>

                </select>
            </span>
            <div align="left"><a onClick="addOption('districts_div')">[+] Add another district</a></div><br>
        <span class="style5">Click here to include another district like 'Thane' in the search</span></div>
        <br>
        <div id="coursegroup_selection_div" style="display:none">
            <span class="style1">Course Group:</span>
            <div>
                <span id="coursegroup_div">
                    <select name="coursegroup[]">
                        <option value="" selected="selected">Select One</option>
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['coursegroups']), $this);?>

                    </select>
                </span>
            </div>
            <a onClick="addOption('coursegroup_div')">[+] Add Course Group</a>
            <br><br>
            <a onClick="this.parentNode.style.display='none';getElementById('course_selection_div').style.display='block'">Search by specific course?</a>
        </div>
        <div id="course_selection_div">
        <span class="style1">Course</span>
        <div>
            <span id="course_div">
                <select name="course[]">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['courses']), $this);?>

                </select>
            </span>
        </div>
            <div><a onClick="addOption('course_div')">[+] Add another course</a> <br>
                <span class="style3">Click here to combine two or more course groups<br>
                    Eg. (1) Electronics + Instrumentation & Control + Electrical<br/>
                Eg. (2) Bio-technology +  Pharmacy</span>
            </div>
            <br><br>
            <a onClick="this.parentNode.style.display='none';getElementById('coursegroup_selection_div').style.display='block'">Search by a course group?</a>
            <br>
            <span class="style3">If you want to search all colleges under one group, Eg. Mechanical or Electrical</span>
        </div>
        <input type="submit" name="submit" value="Submit">
            <hr>
                <select name="aid_status">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aid_status']), $this);?>

                </select>

                <select name="minority">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['minority']), $this);?>

                </select>

                <select name="autonomy">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['autonomy']), $this);?>

                </select>
    </form>
</div>
<?php echo '
<script language="javascript">
    function addOption(div)
    {
        var masterdiv = document.getElementById(div);
        masterdiv.parentNode.innerHTML += \'<span><br>\'
            + masterdiv.innerHTML
            + \'<a href=# onClick="this.parentNode.innerHTML=\\\'\\\'">[-]</a>\'
            + \'</span>\';
    }
</script>
'; ?>