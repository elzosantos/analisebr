<form  action="/login" method="post" accept-charset="utf-8">
    <table cellspacing="2">
        <tbody>
            <tr>
                <td>
                    <label for="email">Usuário</label>
                </td>
                <td>
                    &nbsp;&nbsp;<label for="pass">Senha</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" class="inputtext" name="data[User][username]" id="email" value="" tabindex="1">
                </td>
                <td>
                    &nbsp;&nbsp;<input type="password" class="inputtext" name="data[User][password]" id="pass" tabindex="2">
                </td>
                <td>
                    &nbsp;&nbsp;<input value="Entrar"  type="submit" >
                </td>
                
            </tr>
            <tr>
                            <td><a href="/recover">Recuperar Senha</a></td>
                        </tr>
         
        </tbody>
    </table>
</form>