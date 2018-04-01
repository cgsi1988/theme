<?php
/**
 * @file views-view-table--Lending-Library.tpl.php
 *
 * Overrides default views table display, specific to the Lending Library.
 *
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */

// Remove the description field from the list of headers
unset($header['body']);

// Remove the 'body' field from each row, and store it for later.
$row_descriptions = array();
foreach ($rows as $row_id => $row) {
  $row_descriptions[$row_id] = $row['body'];
  unset($rows[$row_id]['body']);
}

 
?>
<table class="<?php print $class; ?> lending-library-table">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <?php foreach ($header as $field => $label): ?>
        <th class="views-field views-field-<?php print $fields[$field]; ?>">
          <?php print $label; ?>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <?php foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $content; ?>
          </td>
        <?php endforeach; ?>
      </tr>
      <tr class="item-description">
        <td colspan="6">
          <div class="toggle"><a href="#toggle-description-<?php print $count; ?>">Description</a></div>
          <div class="description" id="description-<?php print $count; ?>">
            <?php print $row_descriptions[$count]; ?>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<a href="#expand" id="expand-all">Expand all descriptions</a>
