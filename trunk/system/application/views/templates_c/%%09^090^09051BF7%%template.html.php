<?php /* Smarty version 2.6.22, created on 2009-04-07 11:53:12
         compiled from template.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'template.html', 4, false),array('modifier', 'date_format', 'template.html', 31, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Welcome to College Khabri') : smarty_modifier_default($_tmp, 'Welcome to College Khabri')); ?>
</title>
        <script type="text/javascript" src="<?php echo base_url() ?>js/default.js"></script>
        <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url() ?>css/style.css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body style="margin:0; background:#ffffff url(<?php echo base_url() ?>images/back-main-college-khabri.jpg) left top repeat-x;">
        <div align="right" class="style11" style="float:right; margin:20px 100px 0 0; font-family:Geneva, Arial, Helvetica, sans-serif">
        <?php  echo anchor('welcome/login','Login'); ?> |
        <?php  echo anchor('welcome/signup','Signup'); ?> 
        <?php 
        echo form_open('welcome/changestate');
        echo form_dropdown('State', array('mh'=>'Maharashtra'), 'mh', "onchange='this.form.submit()'");
        echo form_close();
        echo form_open('welcome/changestate');
        echo form_dropdown('Career', array('en'=>'Engineering'), 'en', "onchange='this.form.submit()'");
        echo form_close();
         ?>
      
        </div>
        <div align="center">
            <p><img src="<?php echo base_url() ?>/images/logo.jpg" style="margin:-15px auto 0 150px;float:none;"/></p>
    </div>
       
        <div id="main-container">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
      <div id="footer-wrapper">
  <div id="footer" align="center"> <hr size="1px" width="50%" noshade="noshade" /><div class="style5">&copy; Copyright <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 College Khabri<br></div>
        <span class="small-text"><?php  echo anchor('welcome/terms_of_use','terms of use'); ?> |
        <?php  echo anchor('welcome/privacy_policy','privacy policy'); ?> |
        <?php  echo anchor('welcome/contact_us','contact us'); ?></span></div>
</div>
       
    </body>
</html>
