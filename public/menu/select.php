<?php $parent_id = \ishop\App::$app->getProperty('parent_id') ?>




<option class="<?=$id ?> <?=$parent_id ?>" value="<?=$id ?>" <?php if ($id == $parent_id)  echo 'selected';?> <?php if (isset($_GET['id']) && $id == $_GET['id']) echo 'disabled'?> >
    <?= $tab . $category['title'] ?>
</option>

<?php if (isset($category['childs'])): ?>
    <?= $this->getMenuHtml($category['childs'], '&nbsp;' . $tab. '-') ?>
<?php endif; ?>
