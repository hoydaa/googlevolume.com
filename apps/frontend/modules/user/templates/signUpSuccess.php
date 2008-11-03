<h1>Sign Up</h1>

<form action="<?php echo url_for('user/signUp') ?>" method="post">
    <table>
        <?php echo $form ?>
        <tr>
            <td colspan="2">
                <input type="submit" />
            </td>
        </tr>
    </table>
</form>