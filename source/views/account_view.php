<div>
    <p>Личный кабинет обычного пользователя</p>
    <p>Имя:<label><?= $name; ?></label></p>
    <p>Фамилия:<label><?= $lastname; ?></label></p>
</div>
<form action="/account/rename" method="post">
    <label>Задайте имя</label>
    <input name="new_name"><br/>
    <label>Задайте Фамилию</label>
    <input name="new_lastname"><br/>
    <select name="service" id="service">
        <option selected disabled>Выберите службу</option>
        <option>Радио</option>
        <option>Вести 24</option>
    </select><br/>
    <select name="function" id="function">
        <option selected disabled>Выберите должность</option>
        <option>Звукорежиссер</option>
        <option>Журналист</option>
    </select><br/>
    <input type="submit" name=submit_change_name" value="Задать">
</form>