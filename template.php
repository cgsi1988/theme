<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

/**
 * Process variables for search-result.tpl.php.
 *
 * The $variables array contains the following arguments:
 * - $result
 * - $type
 *
 * @see search-result.tpl.php
 */
function cgsi_preprocess_search_result(&$variables) {
	$type = $variables['type'];
	$result = $variables['result'];
	$related_node = $result['related_node'];
	$node_type = $related_node->type;
	if ($type == 'search_by_page' && $node_type == 'nase_rodina'){
		$user = $variables['user'];
		if (isset($user)){
			foreach($user->roles as $role){
				if ($role == 'paid member'
						|| $role == 'admin'
						|| $role == 'membership'
						|| $role == 'store manager'
						|| $role == 'church record'
						|| $role == 'editor'
						|| $role == 'library'
						) {
					$showLink = true;
				}
			}
		}

		if ($showLink === true) {
// 			$variables['url'] = check_url('/' . $related_node->path);
// 			$variables['title'] = check_plain($related_node->title);
		} else {
			$variables['url'] = check_url('/membership');
			$variables['title'] = check_plain('Nase rodina search results are available to paid members only. Follow this link to join.');
		}
	}
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function cgsi_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  cgsi_preprocess_html($variables, $hook);
  cgsi_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function cgsi_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function cgsi_preprocess_page(&$variables, $hook) {		
	if (isset($variables['node'])) {
		$nodeType = $variables['node']->type;
		$suggestion = 'page__' . $nodeType;
		$variables['theme_hook_suggestions'][] =  $suggestion;
	}
	
	if (!isset($variables['body_classes'])) $variables['body_classes'] = "";
	if (!isset($variables['body_classes_array'])) $variables['body_classes_array'] = "";
	//if (!isset($variables['breadcrumb'])) $variables['breadcrumb'] = "";
	if (!isset($variables['title_content'])) $variables['title_content'] = "";
	if (!isset($variables['footer'])) $variables['footer'] = "";
	
	global $user;
	
	// The surnames search view should use the popup page style.
	/**
	 * @todo
	 * The church records browser, and passanger ship records list should be
	 * converted to use this method of displaying pop-ups rather than the current
	 * method of embeding the view into a node of type 'popup'.
	 */
	if (arg(0) == 'members'){
		if ((arg(1) == 'surnames'               && arg(2) == 'search')
		|| ( arg(1) == 'passenger-ship-records' && arg(2) == 'by_ship')) {
		$variables['theme_hook_suggestions'][] =  'page__popup_page';
		}
	}
	
	// Popup back link.
	// There is code in script.js to turn this into a close link if the window is a popup.
	$variables['popup_close'] = l(t('Back to My Surnames'), 'user/' . $user->uid . '/surnames', array('attributes' => array('class' => array ('' => 'popup-close'))));
	
	// If there is content in the title_content region add a body class.
	if (isset($variables['breadcrumb']) || isset($variables['title_content'])) {
		$variables['body_classes'] .= ' with-title-content';
		$variables['body_classes_array'][] = 'with-title-content';
	}
	
	// Tabs?
	if ($variables['tabs']) {
		$variables['body_classes'] .= ' has-tabs';
		$variables['body_classes_array'][] = 'has-tabs';
	}
	
	$arg0 = arg(0);
	$arg1 = arg(1);
	$arg2 = arg(2);
	$arg3 = arg(3);
	$arg4 = arg(4);
	$arg5 = arg(5);
	
	// Prefix username on profile
	if ($arg0 == 'user' && is_numeric($arg1)) {
		$account = user_load($arg1);
		$variables['title'] = t('My Profile: %name', array('%name' => $account->name));
	}
	
	$allShipRecords = ($arg2 == 'by_ship');
	
	// Need to change title here, after view executes
	if ($allShipRecords) {
		$pageTitle = "Ship: " . $arg3 . " - Port: " . $arg4 . " - Arrival: " . $arg5;
		drupal_set_title($pageTitle);
	}
	
	// Change the title of the user/1/orders page.
	// @see uc_order.admin.inc uc_order_history().
	// Necessary because the page doesn't have real themable output.
	if (arg(0) == 'user' && is_numeric(arg(1)) && arg(2) == 'orders') {
		$account = user_load(arg(1));
		$variables['title'] = t('My order history: %name', array('%name' => $account->name));
	}
	
	// Add GA tracking code.
	$variables['footer'] .= <<<JS
  <!-- Google Analytics --><script type="text/javascript">
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
  try {
  var pageTracker = _gat._getTracker("UA-3526364-46");
  pageTracker._trackPageview();
  } catch(err) {}</script>
	
JS;
	
	$variables['delayInterval'] = theme_get_setting('cgsi_banner_delay_interval');
	$variables['BannerImages'] =  explode(PHP_EOL , theme_get_setting('cgsi_banner_image_urls'));
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function cgsi_preprocess_node(&$variables, $hook) {	
	$nodeType = $variables['node']->type;
	$suggestion = 'node__' . $nodeType;
	$variables['theme_hook_suggestions'][] =  $suggestion;
	
	if ($nodeType == "surname") cgsi_preprocess_node_surname($variables);
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function cgsi_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function cgsi_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function cgsi_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}
// */

// Preprocess function for view.
function cgsi_preprocess_views_view(&$vars) {
	if ($vars['view']->name == 'Surnames'){
		if ($vars['view']->current_display == 'page_3') cgsi_preprocess_views_view__Surnames__page_3($vars);
		else if ($vars['view']->current_display == 'page_2') cgsi_preprocess_views_view__Surnames__page_2($vars);
	}
}

/**
 * Override or insert variables into the passenger_ship_record node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cgsi_preprocess_node_passenger_ship_record(&$vars) {
	/* TODO: Remove
	 // Figure out what our arrival port is.
	$term = taxonomy_node_get_terms_by_vocabulary($vars['node'], 8);
	$term = array_shift($term);
	$vars['arrival_port'] = $term->name;
	*/

	// Construct a link to the Passenger_Ship_Records_All view which allows the user
	// to view all other passengers from the same ship/port/date as this user.
}

function cgsi_preprocess_node_surname(&$vars) {
	// Get the current user.
	global $user;

	// The next few lines of logic deal with when to include a back to search
	// results link, vs a "my surnames" link, and also where each of those should
	// point.
	if ($_GET['ref'] != 'mysurnames') {
		$ref = $_SERVER['HTTP_REFERER'];

		// Do not display the back to search results link if it is pointing back to
		// the node/add form.
		$ref = (stristr($ref, 'node/add/surname')) ? FALSE : $ref;

		if ($ref !== FALSE) {
			$vars['referer_link'] = l(t('Back to search results'), 'members/surnames/search');
		}
	}

	// We need more information about the node author when theming surnames.
	$vars['author'] = user_load($vars['node']->uid);

	// If the author has an @cgsi.invalid e-mail address remove it. These addresses
	// were used when importing members with no e-mail address.
	if (stristr($vars['author']->mail, '@cgsi.invalid')) {
		unset($vars['author']->mail);
	}

	// If the user is viewing a surname that belongs to them we also add a link
	// for them to get back to their own surnames.
	if ($vars['author']->uid == $user->uid) {
		$vars['referer_link'] = l(t('Back to my surnames'), 'user/' . $vars['author']->uid . '/surnames') . '<br/>' . $vars['referer_link'];
	}

	// Do we show the user's full mailing address?
	if ($vars['author']->profile_display_address == 1) {
		$vars['author_mailing_address'] =  !empty($vars['author']->profile_address_1) ? check_plain($vars['author']->profile_address_1) . '<br/>' : '';
		$vars['author_mailing_address'] .=  !empty($vars['author']->profile_address_2) ? check_plain($vars['author']->profile_address_2) . '<br/>' : '';
		$vars['author_mailing_address'] .=  !empty($vars['author']->profile_city) ? check_plain($vars['author']->profile_city) . ', ' : '';
		$vars['author_mailing_address'] .=  !empty($vars['author']->profile_state) ? check_plain($vars['author']->profile_state) . ', ' : '';
		$vars['author_mailing_address'] .=  !empty($vars['author']->profile_zipcode) ? check_plain($vars['author']->profile_zipcode) . ' ': '';
		$vars['author_mailing_address'] .=  !empty($vars['author']->profile_country) ? check_plain($vars['author']->profile_country) : '';
	}

	// Determine node author's status.
	switch ($vars['author']->cgsi_status) {
		case 'active':
			$vars['author_status'] = t('This information is from an active CGSI Member.');
			break;
		default:
			$vars['author_status'] = t('This information is from an inactive CGSI Member and may not be current.');
			break;
	}

	// run text transformations on Immigration Area field and Village Origin field.
	$vars['field_surname_european_city'][0]['value'] = cgsi_transform_title_case($vars['field_surname_european_city'][0]['value']);
	$vars['field_surname_immigration_area'][0]['value'] = cgsi_transform_title_case($vars['field_surname_immigration_area'][0]['value'], array());
	$vars['field_surname_immigration_area'][0]['value'] = cgsi_transform_state_abbrs($vars['field_surname_immigration_area'][0]['value']);
}

// Uppercase wrong-cased state/province abbreviations.
function cgsi_transform_state_abbrs($output) {
	$codes = array(
			'AK','AL','AR','AS','AZ','CA','CO','CT','DC','DE','FL','FM','GA','GU','HI','IA','ID','IL','IN','KS','KY','LA','MA','MD','ME','MH','MI','MN','MO','MP','MS','MT','NC','ND','NE','NH','NJ','NM','NV','NY','OH','OK','OR','PA','PR','RI','SC','SD','TN','TX','UT','VA','VI','VT','WA','WI','WV','WY','AB','BC','MB','NB','NL','NS','NT','NU','ON','PE','QC','SK','YT','US',
	);

	$marks = array(",", "'", "\"", "/", "\\", "-", " ", ".", ";", ":", "&", "*", "+", "(", ")", "|");
	$len = strlen($output);

	// go through each character of the output string.
	// we're checking the character before for a word boundary indication,
	// so start looking at position 1.
	// TODO: someday, when I care enough, re-do with with regex
	for ($pos = 0; $pos < $len - 1; $pos++) {
		// check for beginning of string or follows word boundary indication
		if ($pos == 0 || in_array($output[$pos - 1], $marks)) {
			// check for end of string or precedes word boundary indication
			if ($pos == $len - 2 || in_array($output[$pos + 2], $marks)) {
				// don't change "Co." to Colorado
				if (substr($output, $pos, 3) == "Co.") {
					continue;
				}
				$abbr = drupal_strtoupper(substr($output, $pos, 2));
				if (in_array($abbr, $codes)) {
					$output = substr_replace($output, $abbr, $pos, 2);
				}
			}
		}
	}

	// replace "Usa" with "USA"
	if ($pos = strpos($output, 'Usa')) {
		$output = substr_replace($output, 'USA', $pos, 3);
	}

	if (substr($output, 0, 3) == "N/a") {
		$output = "N/A";
	}
	return $output;
}

// Text transformation filter to title case
function cgsi_transform_title_case($output, $except = array('amp', 'nad', 'u', 'an der', 'pri', 'now', 'formerly', 'area', 'and', 'or', 'near', 'pod')) {
	$marks = array(",", "'", "\"", "/", "\\", "-", " ", ".", ";", ":", "&", "*", "+", "(", ")", "|");
	$len = strlen($output);
	for ($pos = 0; $pos < $len; $pos++) {
		// check if $pos is at the beginning of a new word
		if (($pos == 0 || in_array($output[$pos - 1], $marks)) && !in_array($output[$pos], $marks)) {
			// find the end of the word
			for ($pos_end = $pos + 1; $pos_end < $len; $pos_end++) {
				if (in_array($output[$pos_end], $marks)) {
					break;
				}
			}
			$word_len = $pos_end - $pos;
			$word = drupal_strtolower(substr($output, $pos, $word_len));
			if (!in_array($word, $except)) {
				// not an exception word, title case it
				$word = ucwords($word);
			}
			$output = substr_replace($output, $word, $pos, $word_len);

			// skip to the end of the last word found
			$pos = $pos_end - 1;
		}
	}
	return ucfirst($output);
}

/**
 * Preprocess function for views-view-table.tpl.php.
 */
function cgsi_preprocess_views_view_table(&$vars) {
  // Force the "S" column on the public library table to sort in desc order by default.
  if (isset($vars['header']['field_public_lib_searchable']) && !isset($_GET['sort'])) {
    $vars['header']['field_public_lib_searchable'] = str_replace('sort=asc', 'sort=desc', $vars['header']['field_public_lib_searchable']);
  }
}

/**
 * Override the expiration date field in mailing label CVS exports.
 *
 * Subtract 10 days from the supplied expiration date since the extra 10 days
 * are really a grace period.
 */
function cgsi_preprocess_views_view_field__User_Management__feed_2__expiration(&$vars) {
	$vars['output'] = date('m/d/Y', ($vars['row']->uc_roles_expirations_expiration - (60 * 60 * 24 * 10)));
}

function cgsi_preprocess_views_view__Surnames__page_2(&$vars) {
	drupal_add_js(drupal_get_path('theme', 'cgsi') . '/js/DownloadURL.js', array('group' => JS_THEME));
	drupal_add_js(drupal_get_path('theme', 'cgsi') . '/js/MapUserSurnames.js', array('group' => JS_THEME));
}

// Preprocess function for Surnames member search view.
function cgsi_preprocess_views_view__Surnames__page_3(&$vars) {
	// Override the title to show real name instead of user name.
	$member = user_load($vars['view']->args[0]);
	drupal_set_title('Surnames for ' . $member->profile_first_name . ' ' . $member->profile_last_name);
}

/**
 * @see cgsi_extras.module cgsi_extras_user() for some variable injection.
 */
function cgsi_preprocess_user_profile(&$vars) {
	global $user;

	$edit_account_link = '';
	$add_edit_surnames_link = '';
	
	$account = $vars['elements']['#account'];
	$title = t('My Profile: @name', array('@name' => $account->name));
	//$vars['title'] = $title;
	drupal_set_title($title);

	if ($user->uid == $account->uid) {
		$edit_account_link = l(t('edit my password'), 'user/' . $user->uid . '/edit');
		$edit_account_link .= ' - ' . l(t('edit my profile'), 'user/' . $user->uid . '/edit/Member Information');
	}
	$vars['edit_account_link'] = $edit_account_link;

	if ($user->uid == $account->uid) {
		$add_edit_surnames_link = l(t('Add or edit your surnames'), 'user/' . $account->uid . '/surnames');
	}
	$vars['add_edit_surnames_link'] = $add_edit_surnames_link;
}

/**
 * Override theme_username, we wanted to remove the "(not verified)" text from comments.
 *
 * @param $object
 *   The user object to format, usually returned from user_load().
 * @return
 *   A string containing an HTML link to the user's page if the passed object
 *   suggests that this is a site user. Otherwise, only the username is returned.
 */
function cgsi_username($object) {
	if ($object['uid'] && $object['name']) {
		// Shorten the name when it is too long or it will break many tables.
		if (drupal_strlen($object['name']) > 20) {
			$name = drupal_substr($object['name'], 0, 15) .'...';
		}
		else {
			$name = $object['name'];
		}

		if (user_access('access user profiles')) {
			$output = l($name, 'user/'. $object['uid'], array('attributes' => array('title' => t('View user profile.'))));
		}
		else {
			$output = check_plain($name);
		}
	}
	else if ($object['name']) {
		// Sometimes modules display content composed by people who are
		// not registered members of the site (e.g. mailing list or news
		// aggregator modules). This clause enables modules to display
		// the true author of the content.
		if (!empty($object->homepage)) {
			$output = l($object['name'], $object['homepage'], array('attributes' => array('rel' => 'nofollow')));
		}
		else {
			$output = check_plain($object['name']);
		}

		//$output .= ' ('. t('not verified') .')';
	}
	else {
		$output = variable_get('anonymous', t('Anonymous'));
	}

	return $output;
}

/**
 * Generate the HTML output for a single menu link.
 *
 * @ingroup themeable
 */
function cgsi_menu_item_link($link) {
	if (empty($link['localized_options'])) {
		$link['localized_options'] = array();
	}

	// Special case this one menu item ...
	if ($link['title'] == 'Nase rodina Quarterly') {
		$link['localized_options']['html'] = TRUE;
		return l('<span>Nase rodina</span> Quarterly', $link['href'], $link['localized_options']);
	}

	return l($link['title'], $link['href'], $link['localized_options']);
}


/**
 * Theme the role expiration table within the roles dialog on the account edit page.
 *
 * @ingroup themeable
 */

function cgsi_uc_roles_user_expiration($variables) {
	$form = $variables['form'];
  $header = array(
    array('data' => t('Make permanent')),
    array('data' => t('Role'     )),
    array('data' => t('Expiration'  )),
    array('data' => t('Add/remove time')),
  );

  // The expiration table.
  foreach ((array)$form['table'] as $rid => $expiration) {
    // We only want numeric rid's
    if (!is_numeric($rid)) {
      continue;
    }

    // Make sure the renders actually touch the elements.
    $data = $form['table'][$rid];

    $rows[] = array(
      array('data' => drupal_render($data['remove'])),
      array('data' => $data['name']['#value']),
      array('data' => date('m/d/Y H:i', $data['expiration']['#value'])),

      // Options to adjust the expiration.
      array('data' => '<a name="role-expiration-'. $rid .'">'.
                      '<div class="expiration">'.
                        drupal_render($data['polarity']) . drupal_render($data['qty']) . drupal_render($data['granularity']) .
                      '</div>'),
    );
  }
  
  $table = array('#type' => 'table'
  		, '#theme' => 'table'
  		, '#header' => $header
  		, '#rows' => $rows,
  		//'attributes' => array('id' => 'user_expirations'),
  		'#caption' => t('Below you can add or remove time to the expiration dates of the following roles.'),
  		'#empty' => t('There are no pending expirations for this user.')
  );
  
  $output = drupal_render($table);
  
  return $output;
}
