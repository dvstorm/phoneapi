$(document).ready(function(){
  initShowCardButtons();
  initDbCard();
  initAddCard();
  initSearchCard();
});

function initSearchCard(){
  const searchForm = $("#search-form");
  const table = $("#search-phone-card table");

  searchForm.submit( function(e){
    e.preventDefault();
    const loadingSpinner = $(".loading");

    let data = new FormData(e.target);
    let phone = data.get("phone");

    loadingSpinner.css("display", "flex");
    $.ajax('contacts', {
      method: "GET",
      data:  {"phone": phone},
    })
      .then(
        function success(data) {
          loadingSpinner.css("display", "none");
          data = JSON.parse(data);
          appendTable(data);
          table.css("display", "table")
        },
        function fail(data, status) {
          loadingSpinner.css("display", "none");
        }
      );
  });
}

function appendTable(data){
  const rowDummy = $("<tr><td></td><td></td><td></td><td></td></tr>");
  const table = $("#search-phone-card table tbody");
  let rows = $("#search-phone-card table tbody tr");

  rows.each(function(i, item){
    item.remove();
  })

  data.forEach(function(item){
    let newItem = rowDummy.clone();
    newItem.find("td").eq(0).text(item.source_id);
    newItem.find("td").eq(1).text(item.name);
    newItem.find("td").eq(2).text(item.email);
    newItem.find("td").eq(3).text(item.phone);
    newItem.appendTo(table);
  });
}

function initAddCard(){
  const moreRecords = $("#add-phone-card .add-icon");
  const inputsDummy = $("#add-phone-card .inputs_group .input")
  const inputs = $("#add-phone-card .inputs_group")
  const removeIcons = $(".remove-icon");
  const addForm = $("#add-form")

  moreRecords.click(function(){
    let newInput = inputsDummy.clone().appendTo(inputs);
    newInput.find("input").val("");
    newInput.find(".remove-icon").click(function(e){
      e.target.closest(".input").remove();
    });
  });

  removeIcons.click(function(e){
    e.target.closest(".input").remove();
  });

  addForm.submit( function(e){
    e.preventDefault();
    const messageArea = $("#add-phone-card .message");
    const loadingSpinner = $(".loading");

    let data = new FormData(e.target);

    let postData = {};
    postData.source_id = data.get("source_id");

    postData.items = [];

    let names = data.getAll("name");
    let phones = data.getAll("phone");
    let emails = data.getAll("email");

    names.forEach(function(name, i){
      let item = {
        "name": names[i],
        "phone": phones[i],
        "email": emails[i],
      };
      postData.items.push(item);
    })

    loadingSpinner.css("display", "flex");
    $.ajax('contacts', {
      method: "POST",
      data:  JSON.stringify(postData),
    })
      .then(
        function success(data) {
          loadingSpinner.css("display", "none");
          data = JSON.parse(data);
          messageArea.text ("Records created: " + data);
          messageArea.show();
        },
        function fail(data, status) {
          loadingSpinner.css("display", "none");
          messageArea.text ("Error");
          messageArea.show();
        }
      );
  });
}

function initDbCard(){

  const initForm = $("#init-form");
  const messageArea = $("#init-db-card .message");
  const loadingSpinner = $(".loading");

  $("a.form-submit").click(function(e){
    $(e.target).closest("form").submit();
  });

  initForm.submit( function(e){
    e.preventDefault();
    var records = new FormData(e.target).get("records");
    loadingSpinner.css("display", "flex");
    $.ajax('initdb', {
      data: {
        records: records
      }
    })
      .then(
        function success(data) {
          loadingSpinner.css("display", "none");
          data = JSON.parse(data);
          messageArea.text (data.records_created + " records created");
          messageArea.show();
        },
        function fail(data, status) {
          loadingSpinner.css("display", "none");
          messageArea.text ("Error");
        }
      );
  });
};

function initShowCardButtons(){
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

}
