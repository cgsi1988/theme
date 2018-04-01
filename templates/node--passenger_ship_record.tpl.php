<?php
/**
 * @file node-church_record.tpl.php
 *
 * Theme implementation to display nodes of the church_record type.
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
 * - $arrival_port: The arrival port taxonomy term for this record.
 * - $view_others_link_path: URI for the Passenger_Ship_Records_All view with
 *   arguments appropriate for this record. Suitable for use with l().
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see cgsi_preprocess_node_passenger_ship_record()
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

  <?php if ($submitted or $terms): ?>
    <div class="meta">
      <?php if ($submitted): ?>
        <div class="submitted">
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>
  <?php endif; ?>

  <div class="content">
				<?php 
				// Store referrer in session for 'Back to search results' link.
				$_SESSION['psr_search_results'] = $_SERVER['HTTP_REFERER'];
				?>
    
    <p><a href="<?php print url('members/passenger-ship-records/search/popup');?>" onclick="history.go(-1); return false">Back to search results</a></p>
     <p>
      <?php print t("<strong>Surname:</strong> @value - from Leo Baca's Czech immigration passenger lists<br/>", array('@value' => $node->title)); ?>
      <?php print t("<strong>First Name:</strong> @value<br/>", array('@value' => $field_psr_first_name[0]['value'])); ?>
      <?php print t("<strong>Other Family Members:</strong> @value<br/>", array('@value' => $field_psr_other_family_members[0]['value'])); ?>
      <?php print t("<strong>Age:</strong> @value<br/>", array('@value' => $field_psr_age[0]['value'])); ?>
      <?php print t("<strong>Departure City:</strong> @value<br/>", array('@value' => $field_psr_departure_city[0]['value'])); ?>
      <?php print t("<strong>Departure Country:</strong> @value<br/>", array('@value' => $field_psr_departure_country[0]['value'])); ?>
      <?php print t("<strong>Ship:</strong> @value<br/>", array('@value' => $field_psr_ship[0]['value'])); ?>
	  <?php print l('View ALL Czech passengers that arrived on this specific ship', 
    	'members/passenger-ship-records/by_ship' 
    		 . '/' . $field_psr_ship[0]['value']
    		 . '/' . $field_psr_arrival_city[0]['value'] 
    		 . '/' . $field_psr_arrival_date[0]['value'] 
    		); ?>
    		<br/>
	    <?php print t("<strong>Arrival Date:</strong> @value<br/>", array('@value' => $field_psr_arrival_date[0]['value'])); ?>
	    <?php print t("<strong>Arrival Port:</strong> @value<br/>", array('@value' => $field_psr_arrival_city[0]['value'])); ?>
	    <?php print t("<strong>Volume:</strong> @value<br/>", array('@value' => $field_psr_book_num[0]['value'])); ?>        
    </p>
  </div>

  <?php print $links; ?>

</div></div> <!-- /node-inner, /node -->
