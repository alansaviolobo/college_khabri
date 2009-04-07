<?php /* Smarty version 2.6.22, created on 2009-04-06 17:58:13
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'index.html', 10, false),)), $this); ?>

<div style="width:717px; height:auto;margin:auto;border: 1px solid #c7c7c7;font-family:Arial, Helvetica, sans-serif;padding:5px;">
    <p style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:24pt;letter-spacing:-1px;margin-top:0;">Search Colleges</p>
    <form method="post" action="welcome/search_results">

        <span align="left" id="cut-off">University</span><br>
        <span align="left">
            <select name="university">
                <option value="" selected="selected">Select One</option>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['universities']), $this);?>

            </select>
            <br><br>
        </span>

        <span id="cut-off">District</span>
        <div>
            <span id="districts_div">
                <select name="districts[]">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['districts']), $this);?>

                </select>
            </span>&nbsp;&nbsp;&nbsp;<a onClick="addOption('districts_div')">[+] Add another district</a><br>
        <span class="style5" style="padding-left:161px"><em>Click here to include another district like 'Thane' in the search</em></span>
        </div>
        <div></div>
  <br>

        <div id="coursegroup_selection_div" style="display:none">
            <span id="cut-off">Course Group:</span>
            <div>
                <span id="coursegroup_div">
                    <select name="coursegroup[]">
                        <option value="" selected="selected">Select One</option>
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['coursegroups']), $this);?>

                    </select>
                </span><a onClick="addOption('coursegroup_div')">[+] Add Course Group</a><br>
            
            <span class="style5" style="padding-left:145px"><em>Click here to combine two or more course groups</em><br></span>
            <span class="style5" style="padding-left:145px"> Eg. (1) Electronics + Instrumentation & Control + Electrical<br/></span>
            <span class="style5" style="padding-left:145px">Eg. (2) Bio-technology +  Pharmacy</span>
            </div>
            <div> 
            
            </div>
            <br><br>
            <a onClick="this.parentNode.style.display='none';getElementById('course_selection_div').style.display='block'">Search by specific course?</a>
        </div>
        <div id="course_selection_div">
        <span id="cut-off">Course</span>
        <div>
            <span id="course_div">
                <select name="course[]">
                    <option value="" selected="selected">Select One</option>
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['courses']), $this);?>

                </select>
            </span>&nbsp;&nbsp;&nbsp;<a onClick="addOption('course_div')">[+] Add another course</a> <br>
            
            <span class="style5" style="padding-left:290px"><em>Click here to combine two or more courses</em><br></span>
            <span class="style5" style="padding-left:290px">Eg.  B. Tech Electronics Engineering + B.E Electronics &amp; Tele-comm.<br/></span>
            
        </div>
         
            <br>
            <a onClick="this.parentNode.style.display='none';getElementById('coursegroup_selection_div').style.display='block'">Search by a course group?</a>
            <br>
            <span class="style5">If you want to search all colleges under one group, Eg. Mechanical or Electrical</span>
        </div>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>