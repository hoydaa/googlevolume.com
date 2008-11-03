<h1>Account Settings</h1>

<form action="<?php echo url_for('user/updateAccountSettings') ?>" method="post">
    <table>
        <?php echo $form ?>
        <tr>
            <td colspan="2">
                <input type="submit" value="Update" />
            </td>
        </tr>
    </table>
</form>