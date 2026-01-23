var Webflow = Webflow || [];
Webflow.push(function() {
  $('.product-options-tab').on('tap', function() {
    let needClose = $(this).hasClass("active");

    const $wrap = $(this).closest('.product-body');
    $wrap.find('.product-options-tab, .product-options-tab-content').removeClass('active');
    
    if(needClose) return;

    const $tabs = $wrap.find('.product-options-tab');
    const $tabsContent = $wrap.find('.product-options-tab-content');
    const index = $tabs.index($(this));
    $(this).addClass('active');
    $tabsContent.eq(index).addClass('active');

    if($(window).width() < 768) {
      const rem = parseFloat($('body').css('font-size'));
      $([document.documentElement, document.body]).animate({
        scrollTop: $(this).offset().top - $('.navbar').height() - rem / 2
      }, 200);
    }
  });

  $('.product-table-button').on('tap', function() {
    const $table = $(this).closest('.product-table');
    const $buttons = $table.find('.product-table-button');
    const index = $buttons.index($(this)) + 1;

    $table.find('.product-table-button.active').removeClass('active');
    $(this).addClass('active');

    $table.find('.product-table-row').each(function() {
      $(this).find('.product-table-cell').each(function(i, cell) {
        if(i > 0 && i === index) {
          $(cell).addClass('active');
        } else {
          $(cell).removeClass('active');
        }
      })
    });
  });

  $('.product-table-row').each(function() {
    $(this).find('.product-table-cell').each(function(i, cell) {
      if(i === 1) $(cell).addClass('active');
    });
  });

});
