<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>

<div id="popup-page">

  <header id="popup-page-header" role="banner">
    <?php print render($page['header']); ?>
    <?php print $popup_close; ?>
  </header>

  <div id="popup-page-main">

    <div id="popup-page-content" class="column" role="main"><div id="popup-page-content-inner">
      <a id="popup-page-main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="page__title title" id="popup-page-title"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
				<?php print $messages; ?>
				<?php if ($tabs): ?>
				<div class="tabs">
					<?php print render($tabs); ?>
				</div>
				<?php endif; ?>
				<?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div></div> <!-- /#content-inner, /#content -->

  </div>

  <?php print render($page['footer']); ?>

</div>

<?php print render($page['bottom']); ?>
