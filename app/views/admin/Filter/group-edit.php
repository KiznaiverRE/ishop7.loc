<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование группы фильтров <?= hchrs($group->title) ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?= ADMIN ?>/filter/attribute-group">Группы фильтров</a></li>
        <li class="active">Редактирование группы фильтров</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <form action="<?= ADMIN ?>/filter/group-edit" method="POST" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование группы</label>
                            <input type="text" name="title" value="<?= hchrs($group->title) ?>" class="form-control" id="title" placeholder="Наименование группы" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?=$group->id ?>">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
                <!--                    --><?php //new \app\widgets\menu\Menu([
                //                        'tpl' => WWW . '/menu/category_admin.php',
                //                        'container' => 'div',
                //                        'cache' => 0,
                //                        'cacheKey' => 'admin_cat',
                //                        'class' => 'list-group list-group-root well'
                //                    ])?>

            </div>
        </div>
    </div>

</section>
<!-- /.content -->