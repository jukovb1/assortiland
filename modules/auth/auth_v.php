<?php
/**
 * auth_v.php (front)
 *
 * Представление авторизации пользователей для фронта
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}
// todo ash-0 в языковой файл ->

?>

<div id="auth-block">
	<h1>Авторизация</h1>
	<fieldset>
		<label for="auth-pass">Логин</label>
		<input class="linesauth" type="text" value="Введите логин" onkeyup="search(this.value)" onfocus="if(this.value=='Введите логин')this.value='';" onblur="if(this.value=='')this.value='Введите логин';" class="  ">
		<label for="auth-pass">Пароль</label>
		<input class="linesauth" type="password" value="Введите e-mail" onkeyup="search(this.value)" onfocus="if(this.value=='Введите e-mail')this.value='';" onblur="if(this.value=='')this.value='Введите e-mail';" class="  ">
		<button class="mid-button enter-but">Войти</button>
	</fieldset>
</div>