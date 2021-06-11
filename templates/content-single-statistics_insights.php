<?php
$fields = get_fields();
?>
<div class="col-sm-12 pt-1 pb-4 ">
  <p class="pt-2 text-uppercase">
    <?php echo strip_tags($fields['pubdate']) ?>
  </p>
  <div class="pb-2">
    <?php echo $fields['highlight'] ?>
  </div>
<ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="insights-tab" data-toggle="tab" href="#insights" role="tab" aria-controls="insights" aria-selected="true"><?php pll_e('Insights'); ?> </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="explainer-tab" data-toggle="tab" href="#explainer" role="tab" aria-controls="explainer" aria-selected="false"><?php pll_e('Explainer'); ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="references-tab" data-toggle="tab" href="#references" role="tab" aria-controls="references" aria-selected="false"><?php pll_e('References'); ?></a>
  </li>
</ul>

  <div class="tab-content">
    <div class="tab-pane active" id="insights" role="tabpanel" aria-labelledby="insights-tab">
      <div class="pt-4">

        <?php if (!empty($fields['graphic']) && $fields['graphic_position'] === "top") { ?>
          <?php $image = get_field('graphic'); ?>
          <img class="img-fluid" src="<?php echo $image[0]['url']; ?>" alt="<?php echo $image[0]['name']; ?>" />
        <?php } ?>

        <?= $fields['description'] ?>

        <?php if (!empty($fields['graphic']) && $fields['graphic_position'] === "bottom") { ?>
          <?php $image = get_field('graphic'); ?>
          <img class="img-fluid" src="<?php echo $image[0]['url']; ?>" alt="<?php echo $image[0]['name']; ?>" />
        <?php } ?>

      </div>
       <?php $csv = get_field('csv'); ?>
      <div class="pt-4">
        <a class="btn btn-sm btn-secondary" href="<?php echo $csv['url']; ?>" download="<?php echo $csv['filename']; ?>"><?php pll_e('Download'); ?></a>
      </div>
    </div>
    <div class="tab-pane" id="explainer" role="tabpanel" aria-labelledby="explainer-tab">
      <div class="pt-4">
        <?= $fields['explanation'] ?>
      </div>
    </div>
    <div class="tab-pane" id="references" role="tabpanel" aria-labelledby="references-tab">
      <div class="pt-4">
         <?= $fields['references'] ?>
      </div>
    </div>
  </div>
</div>
