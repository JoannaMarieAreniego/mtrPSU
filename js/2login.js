var userErrorCount = 0;
var errorProd = 0;
var checkingUser = false;

function validateLoginForm() {
    var studID = $('#studID').val();
    var password = $('#password').val();

    checkingUser = true;
    userErrorCount = 0;
	$('#studID_error, #password_error').html('');
	$('#studID, #password').css("border", "1px solid black"); 
    
    if (studID == ""){
		$('#lstudID_error').html('Student ID is required');
		$('#studID').css("border", "1px solid red");
		userErrorCount++;
	}
	   
	if (password  == ""){
		$('#lpassword_error').html('Password is required');
		$('#password').css("border", "1px solid red");
		userErrorCount++;
	}
    return true;
}

function loginUser() {
    if (!validateLoginForm()) {
        return false;
    }

    $.ajax({
        type: "POST",
        url: "2logprocess.php",
        data: $("#loginForm").serialize(),
        success: function (response) {
            response = JSON.parse(response);
            if (response.status === "success") {
                window.location.href = "3newsfeed.php";
            } else {
                alert("Login failed. Please check your credentials.");
            }
        },
        error: function () {
            console.error("Something went wrong with the AJAX request.");
            alert("Something went wrong with the AJAX request.");
        }
    });
    return false;
}
