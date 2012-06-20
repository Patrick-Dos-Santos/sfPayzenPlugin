<?php use_helper('I18N') ?>
<form method="POST" action="https://secure.payzen.eu/vads-payment/">
    <table>
        <tbody>
            <?php echo $form ?>
        </tbody>
        <tfoot>
            <tr><td><input type="submit" value="<?php echo __('Pay', null, 'payzen') ?>"/></td></tr>
        </tfoot>
    </table>
</form>