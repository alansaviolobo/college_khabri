<?php /* Smarty version 2.6.22, created on 2009-03-30 04:14:56
         compiled from template.html */ ?>
<html>
<head>
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>
<body>

<img src="<?php  echo base_url() . 'images/logo.jpg'; ?>">
<?php 
  echo form_open('welcome/search');
  echo form_dropdown('priority', array('high' => 'high', 'medium' => 'medium', 'low' => 'low' ), 'medium');
  echo form_close();
 ?>
<hr>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<hr>
&copy; Copyright <?php  echo date('Y');  ?> College Khabri<br>
<?php  echo anchor('welcome/terms-of-use','terms of use'); ?> |
<?php  echo anchor('welcome/privacy-policy','privacy policy'); ?> |
<?php  echo anchor('welcome/contact-us','contact us'); ?>
</body>
</html>
