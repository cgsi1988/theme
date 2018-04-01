<?php

/**
 * @file search-block-form.tpl.php
 * Default theme implementation for displaying a search form within a block region.
 *
 * Available variables:
 * - $search_form: The complete search form ready for print.
 * - $search: Array of keyed search elements. Can be used to print each form
 *   element separately.
 *
 * Default keys within $search:
 * - $search['search_block_form']: Text input area wrapped in a div.
 * - $search['submit']: Form submit button.
 * - $search['hidden']: Hidden form elements. Used to validate forms when submitted.
 *
 * Since $search is keyed, a direct print of the form element is possible.
 * Modules can add to the search form so it is recommended to check for their
 * existance before printing. The default keys will always exist.
 *
 *   <?php if (isset($search['extra_field'])): ?>
 *     <div class="extra-field">
 *       <?php print $search['extra_field']; ?>
 *     </div>
 *   <?php endif; ?>
 *
 * To check for all available data within $search, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($search, 1)) .'</pre>'; ?>
 *
 * @see template_preprocess_search_block_form()
 */
?>
<div id="search" class="container-inline<?php print (user_access('use advanced search') ? ' advanced-search' : ''); ?>">
  <?php if (empty($variables['form']['#block']->subject)): ?>
    <h2 class="element-invisible"><?php print t('Search form'); ?></h2>
  <?php endif; ?>

  <div class="fields">
    <?php print $search['search_block_form']; ?>
    <input type="image" class="search-submit" src="<?php print url(path_to_theme() .'/images/go.gif'); ?>" height="20" width="38" alt="Go"/>
    <?php print $search['hidden']; ?>
  </div>

  <?php if (user_access('use advanced search')): ?>
    <div class="advanced"><?php print l(t('advanced search'), 'search/node', array('query' => array('advanced' => 'expanded'))); ?></div>
  <?php endif; ?>
</div>
