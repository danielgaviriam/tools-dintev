// init Isotope
var $grid = $('.grid').isotope({
  itemSelector: '.element-item'
});

// store filter for each group
var filters = {};

//Ocultar la paginacion cuando se seleccione una categoria especifica
var flag_all_categories=true;

$('.filters').on( 'click', '.bottons_isotope', function() {

  var $this = $(this);


  // get group key
  var $buttonGroup = $this.parents('.button-group');

  var filterGroup = $buttonGroup.attr('data-filter-group');


  
  // set filter for group
  filters[ filterGroup ] = $this.attr('data-filter');
  // combine filters
  var type = $buttonGroup.attr('data-filter-group');


  var filterValue = concatValues( filters );

  //Buscando para cambiar el is-checked

  if(type == 'categories'){
    var last = $('.categories-isotope').find('.is-checked');

    last.removeClass('is-checked');

    $this.addClass('is-checked');  
  }

  if(type == 'pages'){
    var last = $('.pages-isotope').find('.is-checked');

    last.removeClass('is-checked');

    $this.addClass('is-checked');  
  }
  
  if(flag_all_categories){
    $('.pages_isotopes').css('display','block');
  }
  else{
    $('.pages_isotopes').css('display','none'); 
  }
  
  // set filter for Isotope
  $grid.isotope({ filter: filterValue });
});

  
// flatten object by concatting values
function concatValues( obj ) {

  //Validaciones realizadas para paginar unicamente cuando se seleccione la categoria Todas (*)
  var flag=false;
  var value = '';
  var i = 0;
  for ( var prop in obj ) {

    if(prop == 'pages' && i == 0){
      value='*'+obj['pages'];
    }
    else if(prop == 'categories'){
      if(obj[ prop ]=='*'){
        flag_all_categories=true
        flag=true;  
      }
      else{
        flag_all_categories=false
      }
      value += obj[ prop ];
    }

    if(prop == 'pages' && flag){
      value += obj[ prop ];  
    }

    i++;
  }

  if(value=='*'){
    value='*.1';
  }

  if(value==''){
  	value='*'+obj['pages'];
  	
  }
  return value;
}
