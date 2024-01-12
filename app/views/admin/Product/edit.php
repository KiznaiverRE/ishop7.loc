<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование товара <?= $product->title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?= ADMIN ?>/product">Список товаров</a></li>
        <li class="active">Редактирование</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <form action="<?= ADMIN ?>/product/edit" method="POST" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование товара</label>
                            <input
                                type="text"
                                name="title"
                                value="<?= hchrs($product->title) ?>"
                                class="form-control" id="title" placeholder="Наименование товара"
                            >
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
                                    'name' => 'category_id',
                                    'id' => 'category_id'
                                ],
                            ])?>
                        </div>

                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input
                                type="text"
                                name="keywords"
                                value="<?= hchrs($product->keywords)?>"
                                class="form-control" id="keywords" placeholder="Ключевые слова"
                            >
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input
                                type="text"
                                name="description"
                                value="<?= hchrs($product->description) ?>"
                                class="form-control" id="description" placeholder="Описание"
                            >
                        </div>

                        <div class="form-group">
                            <label for="price">Цена</label>
                            <input
                                type="text" name="price"
                                data-error="Допускаются цифры и десятичная точка" pattern="^[0-9.]{1,}$" required
                                value="<?= $product->price ?>"
                                class="form-control" id="price" placeholder="Цена"
                            >
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label for="old_price">Старая цена</label>
                            <input
                                type="text" name="old_price"
                                data-error="Допускаются цифры и десятичная точка" pattern="^[0-9.]{1,}$"
                                value="<?= $product->old_price ?>"
                                class="form-control" id="old_price" placeholder="Цена"
                            >
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label for="content">Контент</label>
                            <textarea name="content" id="editor1" cols="80" rows="10"><?= $product->content ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="status" <?= $product->status !== 'draft' ?  'checked' : null?> > Статус
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="hit" <?= $product->hit ?  'checked' : null?> > Хит
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="related">Связанные товары</label>
                            <select name="related[]" class="form-control select2" id="related" multiple>
                                <?php if (!empty($related_product)): ?>
                                    <?php foreach ($related_product as $item): ?>
                                        <option value="<?= $item['related_id'] ?>" selected><?= $item['title'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <?php new \app\widgets\filter\Filter($filter, WWW . '/filter/admin_filter_tpl.php')?>

                        <div class="form-group">
                            <div class="col-md-4">
                                <div class="box box-danger box-solid file-upload">
                                    <div class="box-header">
                                        <h3 class="box-title">Базовое изображение</h3>
                                    </div>
                                    <div class="box-body">
                                        <div id="single" class="btn btn-success" data-url="/product/add-image" data-name="single">Выбрать файл</div>
                                        <p><small>Рекомендуемые размеры: 125х200</small></p>
                                        <div class="single">
                                            <img style="max-height: 150px;" src="/images/<?= $product->img ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="box box-primary box-solid file-upload">
                                    <div class="box-header">
                                        <h3 class="box-title">Картинки галереи</h3>
                                    </div>
                                    <div class="box-body">
                                        <div id="multi" class="btn btn-success" data-url="/product/add-image" data-name="multi">Выбрать файл</div>
                                        <p><small>Рекомендуемые размеры: 700х1000</small></p>
                                        <div class="multi">
                                            <?php if (!empty($gallery)): ?>
                                                <?php foreach($gallery as $item): ?>
                                                    <img style="max-height: 150px; cursor: pointer;" src="/images/<?= $item ?>" data-id="<?= $product->id ?>" data-src="<?= $item ?>" class="del-item" alt="">
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?= $product->id ?>">
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