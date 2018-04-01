<?php
// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
*/
?>
<div class="<?php print $classes; ?>">
	<?php if ($admin_links): ?>
	<div class="views-admin-links views-hide">
		<?php print $admin_links; ?>
	</div>
	<?php endif; ?>
	<?php if ($header): ?>
	<div class="view-header">
		<?php print $header; ?>
	</div>
	<?php endif; ?>

	<?php if ($exposed): ?>
	<div class="view-filters">
		<?php print $exposed; ?>
	</div>
	<?php endif; ?>

	<?php if ($attachment_before): ?>
	<div class="attachment attachment-before">
		<?php print $attachment_before; ?>
	</div>
	<?php endif; ?>

	<?php if ($pager): ?>
	<?php print $pager; ?>
	<?php endif; ?>

	<?php if ($view->total_rows > 200): ?>

	<div class="error">
		<p>
			<strong>Over 200 results were found, please try narrowing your search	parameters.</strong>
		</p>
	</div>

	<?php else: ?>
	<?php if ($rows): ?>
	<div class="view-content">
		<?php 
		print $rows;
		?>

		<?php if ($pager): ?>
		<?php print $pager; ?>
		<?php endif; ?>
		<div id="Maps">
			<h2>Surname Locations</h2>
			<h3>Hover over markers to see surname. Click on marker for more info.</h3>
			<div id="destinations"></div>
			<div id="origins"></div>
			<h3>Labels: D(estination) O(rigin City/Village)</h3>
<!-- 			<table id="geocodeResults"> -->
<!-- 			<thead> -->
<!-- 			<tr> -->
<!-- 			<th>Status</th> -->
<!-- 			<th>nid</th> -->
<!-- 			<th>Surname</th> -->
<!-- 			<th>OriginCity</th> -->
<!-- 			<th>OriginCountry</th> -->
<!-- 			<th>Destination</th> -->
<!-- 			<th>LastModified</th> -->
<!-- 			</tr> -->
<!-- 			</thead> -->
<!-- 			<tbody></tbody> -->
<!-- 			</table> -->
		</div>

		<script>    
		var surnameCounter = 0;
    var surnameLocations = <?php echo json_encode($view->result, JSON_NUMERIC_CHECK); ?>;
        
		// This function runs as soon as Google maps loads.
		function GoogleMapsLoaded() { 
			MapSurnamesByNode();
		}
		
		function MapSurnamesByNode() {
			var lv_nodeIDs = '';
			for ( var i = 0; i < surnameLocations.length; i++) {
				lv_nodeIDs += surnameLocations[i].nid + ',';
			}				
			lv_nodeIDs = lv_nodeIDs.substring(0, lv_nodeIDs.length - 1);
			MapSurnameNodes(lv_nodeIDs, 'origins', 'destinations');
		}
		
		function GeocodeSurnames() {
			lv_address = locationAddress(
					surnameLocations[surnameCounter].field_field_surname_european_city[0],
					surnameLocations[surnameCounter].field_field_surname_european_country[0])
					;

		var geocoder = new google.maps.Geocoder();
		if (geocoder) {
			geocoder.geocode({
				'address' : lv_address, region:'cz'
			}, function(results, status) {
				geocodeCallback(results, status);
			});
		}
		//alert('GoogleMapsLoaded');
	}

		function locationAddress(p_city, p_country){
			var lv_address = '';
			if (p_city) lv_address += p_city.raw.value;
			return lv_address;
		}

		// The google.maps.Geocoder.geocode function call this when done.
		function geocodeCallback(results, status) {
			surnameLocations[surnameCounter].geocodeResults = results;
			surnameLocations[surnameCounter].status = status;
			surnameCounter++;

			if (surnameCounter >= surnameLocations.length) {
				drawMap();
			} else {
				GoogleMapsLoaded();
			}
		}

		function drawMap() {
			var mapLatLngBounds = new google.maps.LatLngBounds(); // Map boundaries
			var toCenter = new google.maps.LatLng(45, -90);
			var fromCenter = new google.maps.LatLng(50, 15);
			var mapCenter = fromCenter;

			var lv_map = new google.maps.Map(document
					.getElementById('origins'), {
				center : mapCenter,
				zoom : 6
			});

			for ( var i = 0; i < surnameLocations.length; i++) {
				var lv_surname = surnameLocations[i];
				var lv_results = lv_surname.geocodeResults;
				if (lv_results && lv_results.length > 0) {
						var marker = new google.maps.Marker(
								{
									map : lv_map,
									position : lv_results[0].geometry.location
								});
				}
			}
		}


  </script>
		<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAseQhq3Mv-EsfsoOAiwwdznN8CcS8abws&callback=GoogleMapsLoaded">    
  </script>
	</div>
	<?php elseif ($empty): ?>
	<div class="view-empty">
		<?php print $empty; ?>
	</div>
	<?php endif; ?>

	<?php if ($attachment_after): ?>
	<div class="attachment attachment-after">
		<?php print $attachment_after; ?>
	</div>
	<?php endif; ?>

	<?php if ($more): ?>
	<?php print $more; ?>
	<?php endif; ?>

	<?php endif; ?>

	<?php if ($footer): ?>
	<div class="view-footer">
		<?php print $footer; ?>
	</div>
	<?php endif; ?>

	<?php if ($feed_icon): ?>
	<div class="feed-icon">
		<?php print $feed_icon; ?>
	</div>
	<?php endif; ?>

</div>
<?php /* class view */ ?>
