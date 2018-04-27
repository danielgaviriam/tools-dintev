<?php
/**
 * Template Name: Isotopes
 *
 */
require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/tools-dintev/includes/lib.php");

//Incluyendo el estilo del isotopes filter
wp_enqueue_style( 'style',get_template_directory_uri().'/css/style.css',false,'1.1','all');
$categories=td_get_categories_for_isotopes();
$tools=td_get_all_tools();
td_get_categories_for_isotopes();
get_header(); 
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="<?php echo get_template_directory_uri().'/js/jquery.min.js' ?>"></script>
<script src="<?php echo get_template_directory_uri().'/js/isotope-docs.min.js' ?>"></script>


<!--<p><input type="text" class="quicksearch" placeholder="Search" /></p>-->

<div id="filters" class="button-group">  
  <button class="button is-checked" data-filter="*">show all</button>
  <?php 
  foreach( $categories as $key => $row) {?>
  <button class="button" data-filter=".<?php echo $row->Name?>"><?php echo $row->Name?></button>
  <?php
  }
  ?>     
  
</div>
<div class="grid">
  <?php
  foreach( $tools as $key => $row) {?>

  <div class="element-item <?php    
      foreach ($row['categories'] as $key) {
            echo $key->Name." ";
          }?> " data-category="transition">
    <img src="<?php echo $row['info_tool']->path_image?>" style="width: 100%;height: 100%;" />
    <h3 hidden class="name"><?php echo $row['info_tool']->Name?></h3>
    
  </div>
  <?php
  }
  ?>
</div>



<script>

// quick search regex
var qsRegex;

var $grid = $('.grid').isotope({
  itemSelector: '.element-item',
  layoutMode: 'fitRows',
  filter: function() {
    return qsRegex ? $(this).text().match( qsRegex ) : true;
  },
  getSortData: {
    name: '.name',
    symbol: '.symbol',
    number: '.number parseInt',
    category: '[data-category]',
    weight: function( itemElem ) {
      var weight = $( itemElem ).find('.weight').text();
      return parseFloat( weight.replace( /[\(\)]/g, '') );
    }
  }
});

// use value of search field to filter
var $quicksearch = $('.quicksearch').keyup( debounce( function() {
  qsRegex = new RegExp( $quicksearch.val(), 'gi' );
    ;
}, 200 ) );

// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  threshold = threshold || 100;
  return function debounced() {
    clearTimeout( timeout );
    var args = arguments;
    var _this = this;
    function delayed() {
      fn.apply( _this, args );
    }
    timeout = setTimeout( delayed, threshold );
  };
}

// filter functions
var filterFns = {
  // show if number is greater than 50
  numberGreaterThan50: function() {
    var number = $(this).find('.number').text();
    return parseInt( number, 10 ) > 50;
  },
  // show if name ends with -ium
  ium: function() {
    var name = $(this).find('.name').text();
    return name.match( /ium$/ );
  }
};

// bind filter button click
$('#filters').on( 'click', 'button', function() {
  var filterValue = $( this ).attr('data-filter');
  // use filterFn if matches value
  filterValue = filterFns[ filterValue ] || filterValue;
  $grid.isotope({ filter: filterValue });
});
/*
// bind sort button click
$('#sorts').on( 'click', 'button', function() {
  var sortByValue = $(this).attr('data-sort-by');
  $grid.isotope({ sortBy: sortByValue });
});*/

// change is-checked class on buttons
$('.button-group').each( function( i, buttonGroup ) {
  var $buttonGroup = $( buttonGroup );
  $buttonGroup.on( 'click', 'button', function() {
    $buttonGroup.find('.is-checked').removeClass('is-checked');
    $( this ).addClass('is-checked');
  });
});
</script>

<?php
get_footer();