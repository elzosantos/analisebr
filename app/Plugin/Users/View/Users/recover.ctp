
<form>
    <input type="hidden" value="<?php echo!empty($error) ? $error : ''; ?>" id="error">
</form>
<form class="form-signin" action="/recover" method="post" accept-charset="utf-8">
    <table>
        <tbody>
            <tr>
                <td>
                    <label for="email">Informe o Usuário </label><br>
                    <input type="text" style="width: 200px;"  maxlength="50" name="data[User][usuario]" id="email" value="" tabindex="1">
                    &nbsp;<strong>OU</strong><br><br>
                    <label for="email">Informe o E-mail cadastrado </label><br>
                    <input type="text" style="width: 300px;" maxlength="50" name="data[User][email]" id="email" value="" tabindex="1">

                    <br><br><br>
                    <input value="Enviar" tabindex="4" type="submit" >
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">
    $(document).ready(function() {


        if ($('#error').val()) {
            bootbox.dialog({
                message: $('#error').val(),
                title: "Atenção!",
                buttons: {
                    success: {
                        label: "OK",
                        className: "btn-info"
                    }

                }
            });
        }
    });


</script>