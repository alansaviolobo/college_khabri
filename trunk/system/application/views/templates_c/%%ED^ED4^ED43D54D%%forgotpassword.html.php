<?php /* Smarty version 2.6.22, created on 2009-04-03 12:17:48
         compiled from forgotpassword.html */ ?>
<?php echo $this->_tpl_vars['resetPwdForm']['formOpen']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['formErrors']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['usernameLabel']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['usernameBox']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['dobLabel']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['dobDate']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['dobMonth']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['dobYear']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['submit']; ?>

<?php echo $this->_tpl_vars['resetPwdForm']['formClose']; ?>

<?php 
  echo anchor('welcome/login', 'Login');
  echo anchor('welcome/register', 'New user? Register');
 ?>