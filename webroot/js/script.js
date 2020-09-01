$(document).ready(function(){
  const showCardButtons = $(".show-card-buttons");

  const searchCard = $("#search-phone-card");
  const addCard = $("#add-phone-card");
  const initCard = $("#init-db-card");

  showCardButtons.click(function(e){
    searchCard.hide();
    initCard.hide();
    addCard.hide();
    $("#" + e.target.dataset.show).show();
  });

});
