<?php
/**
 * @file node-query.tpl.php
 *
 * Theme implementation to display a node of the type query.
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
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner">

  <?php if ($picture <> 0) print $picture; ?>

  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>" title="<?php print $title ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <?php if (isset($submitted) or isset($terms)): ?>
    <div class="meta">
      <?php if (isset($submitted)): ?>
        <div class="submitted">
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($terms)): ?>
        <div class="terms terms-inline"><?php print t(' in ') . $terms; ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="content">
    <?php print $node->body['und'][0]['value']; ?>


			<p>
				<strong>Contact:</strong>
				<?php if (isset($node->field_query_email['und'][0]['value'])): ?>
				<a
					href="mailto:<?php print $node->field_query_email['und'][0]['safe_value']; ?>"><?php print $node->field_query_name['und'][0]['safe_value']; ?>
				</a>
				<?php else: ?>
				<?php if (isset($node->field_query_name['und'][0]['safe_value'])) 
                                  print $node->field_query_name['und'][0]['safe_value']; ?>
				<?php endif; ?>
				<?php if (isset($node->field_query_address['und'][0]['safe_value']))
                                        print $node->field_query_address['und'][0]['safe_value']; ?>
			,
				<?php if (isset($node->field_query_city['und'][0]['safe_value']))
                                        print $node->field_query_city['und'][0]['safe_value']; ?>
			,
				<?php if (isset($node->field_query_state['und'][0]['safe_value']))
                                        print $node->field_query_state['und'][0]['safe_value']; ?>
				<?php if (isset($node->field_query_zip['und'][0]['safe_value']))
                                        print $node->field_query_zip['und'][0]['safe_value']; ?>
			
			<div class="field-item">
				<?php print t("<strong>Posted:</strong> @value<br/>", array('@value' => format_date($created, 'custom', 'm/d/Y'))); ?>
			</div>


		</div>

  <?php if (isset($links)) print $links; ?>

</div></div> <!-- /node-inner, /node -->
