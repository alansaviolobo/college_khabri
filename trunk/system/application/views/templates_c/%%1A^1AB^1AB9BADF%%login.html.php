<?php /* Smarty version 2.6.22, created on 2009-04-03 12:47:48
         compiled from login.html */ ?>
<?php echo $this->_tpl_vars['loginForm']['formOpen']; ?>

<?php echo $this->_tpl_vars['loginForm']['formErrors']; ?>

<?php echo $this->_tpl_vars['loginForm']['usernameLabel']; ?>

<?php echo $this->_tpl_vars['loginForm']['usernameBox']; ?>

<?php echo $this->_tpl_vars['loginForm']['passwordLabel']; ?>

<?php echo $this->_tpl_vars['loginForm']['passwordBox']; ?>

<?php echo $this->_tpl_vars['loginForm']['submit']; ?>

<?php echo $this->_tpl_vars['loginForm']['formClose']; ?>

<?php 
  echo anchor('welcome/forgot_password', 'Forgot Password?');
  echo anchor('welcome/signup', 'New user? Signup');
 ?>