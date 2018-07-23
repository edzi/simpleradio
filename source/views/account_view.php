<div>
    <label><?php if (!empty(\radio\classes\Error::getErrorText())) echo \radio\classes\Error::getErrorText();?></label>
    <p>Личный кабинет обычного пользователя</p>
    <p>Имя:<label><?= $name; ?></label></p>
    <p>Фамилия:<label><?= $lastname; ?></label></p>
</div>
<button>Открыть окно</button>

<div class="modal-shadow"></div>
<form action="/account/rename" method="post">
    <label>Задайте имя</label>
    <input name="new_name"><br/>
    <label>Задайте Фамилию</label>
    <input name="new_lastname"><br/>
    <select name="service" id="service">
        <option value="" selected disabled>Выберите подразделение</option>
        <?php foreach ($services as $service) {?>
        <option value="<?=$service['id']?>"><?=$service['name']?></option>
        <?php }?>
    </select><br/>
    <select name="function" id="function">
        <option value="" selected disabled>Выберите должность</option>
        <?php foreach ($functions as $function) {?>
            <option value="<?=$function['id']?>"><?=$function['name']?></option>
        <?php }?>
    </select><br/>
    <input type="submit" name="submit_change_name" value="Задать">
</form>