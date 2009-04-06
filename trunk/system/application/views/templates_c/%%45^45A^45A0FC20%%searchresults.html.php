<?php /* Smarty version 2.6.22, created on 2009-04-02 17:29:27
         compiled from searchresults.html */ ?>
<table>
    <tr>
        <td>search criteria here...</td>
        <td>
            <table>
                <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['institute']):
?>
                    <tr><td>
                    <?php echo $this->_tpl_vars['institute']->name(); ?>

                    </td></tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>

        </td>
    </tr>
</table>