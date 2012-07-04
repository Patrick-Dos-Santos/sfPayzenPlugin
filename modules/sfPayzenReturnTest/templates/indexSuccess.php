<?php use_helper('I18N') ?>
<form method="POST" action="<?php echo url_for('@test-return')?>">
    <table>
        <tbody>
            <?php echo $form ?>
        </tbody>
        <tfoot>
            <tr><td><input type="submit" value="<?php echo __('Send', null, 'payzen') ?>"/></td></tr>
        </tfoot>
    </table>
</form>