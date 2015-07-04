/* 

Pico UI v1.1
-------------
[pico-toggle-class] Naam van class die toegevoegd, verwijderd wordt aan de target
[pico-target-id] Naam van de target, die de class krijgt. Moet in hetzelfde element als pico-toggle-class staan.
[pico-id] Definieer een target. Mag elk willekeurig html element zijn.
[pico-container] Definieer een target zonder naam. Te gebruiken in combinatie met pico-target-container.
[pico-target-container] Naamloos target, gebruik de container waar de pico-toggle-class in staat als target.
[pico-reset-class-container] Zorgt ervoor dat elementen binnen de container eerst hun class uitgeschakeld krijgen.

*/

$(document).ready(function() {

  // pico-toggle-class
  
  $('[pico-toggle-class]').on('click', function(e)  {

    var className = $(this).attr('pico-toggle-class');
    var targetName = $(this).attr('pico-target-id');
    var uniqueContainer = $(this).closest('[pico-reset-class-container]');

    if ($(this).attr('pico-toggle-class') === '') {
      className = 'active';
    }

    if (targetName !== undefined) {
      target = $('[pico-id=' + targetName + ']');
    } else if ( $(this).attr('pico-target-container') !== undefined ) {
      target = $(this).closest('[pico-container]');
    } else if ( $(this).attr('href') !== undefined && 
                $(this).attr('href').length > 1 && 
                $(this).attr('href').indexOf('#') == 0) {
      target = $('[pico-id=' + $(this).attr('href').slice(1) + ']');
    } else {
      target = $(this);
    }

    $(uniqueContainer).find('.' + className).removeClass(className);
    $(target).toggleClass(className);

    if ($(this).attr('href') === '#') {
      e.preventDefault();
    }

  });

});