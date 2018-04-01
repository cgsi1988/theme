<?php
/**
 * @file views-view-table--Message-Board.tpl.php
 * Template to display a view as a table.
 *
 * Override for the Message Board main page.
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
      <th class="views-field"><?php print $header['field_msg_bd_post_author']; ?></th>
        <td><?php print $row['field_msg_bd_post_author']; ?></td>
 */
?>
<table>
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <th class="views-field"><?php print $header['title']; ?></th>
      <th class="views-field"><?php print $header['created']; ?></th>
      <th class="views-field"><?php print $header['name']; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <?php // If this row contains the same node as the last row we only care about the attached comment
        if (!isset($previous_row_nid) || $row['nid'] != $previous_row_nid): ?>
        <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <td><?php print $row['title']; ?></td>
        <td><?php print $row['created']; ?></td>
        <td><?php print $row['name']; ?></td>
      </tr>
      <?php endif; ?>

      <?php if ($row['subject'] != '' && $row['timestamp'] != ''): ?>
        <tr class="reply">
          <td class="first"><?php print $row['subject']; ?></td>
          <td><?php print $row['timestamp']; ?></td>
          <td><?php print $row['name']; ?></td>
        </tr>
        <?php $previous_row_nid = $row['nid']; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>
