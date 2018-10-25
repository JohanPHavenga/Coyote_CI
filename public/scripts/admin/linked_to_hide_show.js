/* Select options change */
$('.linked_to select').on('change', function () {
     var $this = $(this),
     	value = $this.val();

     	if (value == 'edition') {
     		$('.hidden-input-edition').fadeIn(350);
     	} else {
     		$('.hidden-input-edition').fadeOut(250);
     	}
        
        if (value == 'race') {
     		$('.hidden-input-race').fadeIn(350);
     	} else {
     		$('.hidden-input-race').fadeOut(250);
     	}
 });