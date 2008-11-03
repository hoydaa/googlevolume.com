<h1>Change Email Address</h1>

<form action="<?php echo url_for('user/changeEmail') ?>" method="post">
    <table>
        <?php echo $form ?>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit" />
            </td>
        </tr>
    </table>
</form>