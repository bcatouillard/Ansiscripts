$('#open_script').click(function() {

 $.ajax({
  type: "POST",
  url: "/cli/connect_db.php",
}).done(function( msg ) {
  alert("Script exécuté");
})    

})
