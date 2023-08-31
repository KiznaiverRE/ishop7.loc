<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование категории "<?= $category->title ?>"
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?= ADMIN ?>/category">Список категорий</a></li>
        <li class="active">Редактирование категории "<?= $category->title ?>"</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <form action="<?= ADMIN ?>/category/edit" method="POST" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование категории</label>
                            <input type="text" value="<?= hchrs($category->title) ?>" name="title" class="form-control" id="title" placeholder="Наименование категории" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Родительская категория</label>
                            <?php new \app\widgets\menu\Menu([
                                'tpl' => WWW . '/menu/select.php',
                                'container' => 'select',
                                'cache' => 0,
                                'cacheKey' => 'admin_select',
                                'class' => 'form-control',
                                'attrs' => [
                                    'name' => 'parent_id',
                                    'id' => 'parent_id'
                                ],
                                'prepend' => '<option value="0">Самостоятельная категория</option>'
                            ])?>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" value="<?= hchrs($category->keywords) ?>" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" value="<?= hchrs($category->description) ?>" name="description" class="form-control" id="description" placeholder="Ключевые слова">
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?= $category->id ?>">
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