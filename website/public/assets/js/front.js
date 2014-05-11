$(function() {
   // Token ajax request
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if ($('#anibis_last').length) {
    $.getJSON("http://www.anibis.ch/fr/webmasters/searchresults.aspx?cid=15&numberOfResults=20&jsoncallback=?",   function(data) { 
       $.each(data.links, function(i, item) { 
          $("#anibis_last").append('<li><a href="' + item.Url + '">' + item.Title + '</li>');  
         });
      })
  }



});

