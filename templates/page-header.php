<?php use Roots\Sage\Titles; ?>

<?php if (get_post_type() != 'post'): ?>
<div class="page-header">
  <h2 class="text-primary p-2 border-bottom"><?= Titles\title(); ?></h2>
</div>
<?php endif ?>
