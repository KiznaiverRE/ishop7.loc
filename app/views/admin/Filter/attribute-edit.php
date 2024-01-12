<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование фильтра <?=hchrs($attr->value)?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?= ADMIN ?>/filter/attribute">Список фильтров</a></li>
        <li class="active">Редактирование фильтра</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <form action="<?= ADMIN ?>/filter/attribute-edit" method="POST" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="value">Наименование фильтра</label>
                            <input type="text" name="value" class="form-control" value="<?=hchrs($attr->value)?>" id="value" placeholder="Наименование фильтра" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Группа</label>
                            <select name="attr_group_id" id="category_id" class="form-control">
                                <?php foreach ($attr_groups as $item): ?>
                                    <option <?php if ($item->id == $attr->attr_group_id) echo 'selected'?> value="<?= $item->id ?>"><?= $item->title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?= $attr->id ?>">
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