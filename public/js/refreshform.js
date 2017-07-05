$(document).ready(function() {
$("#submit").click(function() {
$.post("insertemp.php", {
fname: firstname,
lname: lastname,
username: username,
password: password,
}, function(data) {
alert(data);
$('#employee')[0].reset();
 // To reset form fields
});
});
});