<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование пользователя <?= $user->name ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=ADMIN;?>/user"><i class="fa fa-dashboard"></i> Список пользователей</a></li>
        <li class="active">Редактирование пользователя <?= $user->name ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=ADMIN;?>/user/edit" method="POST" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="login">Логин</label>
                            <input type="text" class="form-control" name="login" id="login" value="<?=hchrs($user->login)?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Ведите пароль, если хотите его изменить">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?=hchrs($user->name)?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?=hchrs($user->email)?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="address">Адрес</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?=hchrs($user->address)?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="role">Роль</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user" <?php if ($user->role == 'user') echo 'selected'?>>Пользователь</option>
                                <option value="admin" <?php if ($user->role == 'admin') echo 'selected'?>>Администратор</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?= $user->id ?>">
                        <button type="submit" class="btn btn-primary">Созранить</button>
                    </div>
                </form>
            </div>

            <h3>Заказы пользователя</h3>
        </div>
    </div>

</section>
<!-- /.content -->