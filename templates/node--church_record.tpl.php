<?php
/**
 * @file node-church_record.tpl.php
 *
 * Theme implementation to display a nodes of the church_record type.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Custom variables:
 * - $record_type: Church record type, from taxonomy term.
 * - $church_name: Church name, from taxonomy term.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see cgsi_preprocess_node_church_record()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner">
  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <?php if ($submitted or $terms): ?>
    <div class="meta">
      <?php if ($submitted): ?>
        <div class="submitted">
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="content">

    <p><a href="<?php print url('members/church-records/search/popup'); ?>" onclick="history.go(-1); return  false">Back to search results</a></p>
    <?php function cgsi_render_field($label, $field){
    	$valueString = "";
    	$value = $field['und'][0]['value'];
      	if (isset($value)) {
      		$valueString = "<strong>{$label}:</strong> {$value}<br/>";
      	} 
      	return t($valueString);  
    }
    ?>
    <?php print t("<strong>Surname:</strong> @value - from Archdiocese of St Paul MN Church Records<br/>", array('@value' => $node->title)); ?>
    <?php print cgsi_render_field("Surname",$node->field_cr_given_name); ?>
    <?php print cgsi_render_field("Record Type",$node->field_cr_record_type); ?>
    <?php print cgsi_render_field("Record Day",$node->field_cr_record_day); ?>
    <?php print cgsi_render_field("Record Month",$node->field_cr_record_month); ?>
    <?php print cgsi_render_field("Record Year",$node->field_cr_record_year); ?>  
    <?php print cgsi_render_field("Birth Day",$node->field_cr_birth_day); ?>
    <?php print cgsi_render_field("Birth Month",$node->field_cr_birth_month); ?>
    <?php print cgsi_render_field("Birth Year",$node->field_cr_birth_year); ?>
    <?php print cgsi_render_field("Church Name",$node->field_cr_church_name); ?>
    <?php print cgsi_render_field("Church Town/City",$node->field_cr_city); ?>  
    <?php print cgsi_render_field("Roll Volume/Page",$node->field_cr_vol); ?>
    <?php print cgsi_render_field("Spouse Surname",$node->field_cr_spouse_surname); ?>
    <?php print cgsi_render_field("Spouse Given Name",$node->field_cr_spouse_given_name); ?>
    <?php print cgsi_render_field("Notes",$node->field_cr_notes); ?>
  </div>

  <?php print $links; ?>

</div></div> <!-- /node-inner, /node -->
