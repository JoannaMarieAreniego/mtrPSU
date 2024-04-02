// 1register.js
var userErrorCount = 0;
var errorProd = 0;
var checkingUser = false;

function validateUserForm(){
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var studID = $('#studID').val();
    var username  = $('#username').val();
    var password = $('#password').val();
    var confirmpass = $('#confirmpass').val();
    
    checkingUser = true;
    userErrorCount = 0;
    $('#firstname_error, #lastname_error, #studID_error, #username_error, #password_error, #confirmpass_error').html('');
    $('#firstname, #lastname, #studID, #username, #password, #confirmpass').css("border", "1px solid black"); 

    if (firstname == ""){
        $('#firstname_error').html('First Name is required');
        $('#firstname').css("border", "1px solid red");
        userErrorCount++;
    }

    if (lastname == ""){
        $('#lastname_error').html('Last Name is required');
        $('#lastname').css("border", "1px solid red");
        userErrorCount++;
    }

	if (studID == ""){
		$('#studID_error').html('Student ID is required');
		$('#studID').css("border", "1px solid red");
		userErrorCount++;
	}
	   
	if (username  == ""){
		$('#username_error').html('Username is required');
		$('#username').css("border", "1px solid red");
		userErrorCount++;
	}

	if (password == ""){
		$('#password_error').html('Password is required');
		$('#password').css("border", "1px solid red"); 
		userErrorCount++;
	}

	if (confirmpass == ""){
		$('#confirmpass_error').html('Please confirm your password');
		$('#confirmpass').css("border", "1px solid red");
		userErrorCount++;
	} else if(password != confirmpass){
		$('#confirmpass_error').html('Passwords do not match');
		$('#confirmpass').css("border", "1px solid red");
		userErrorCount++;
	}
	return userErrorCount === 0;
}


function addUser() {
    validateUserForm();

    if (userErrorCount !== 0) {
        alert("Please fill all fields in the User Form");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "1regprocess.php",
        data: $("#registrationForm").serialize(),
        success: function (response) {
            response = JSON.parse(response);
            
            if (response.status === "success") {
                console.log("User added successfully!");
                $('#studID, #username, #password, #confirmpass').val('');
                alert("User added successfully!");
                window.location.href = "logintry.php";

            } else {
                console.error("Error adding user:", response.message);
                alert(response.message);
            }
        },
        error: function () {
            console.error("Something went wrong with the AJAX request.");
            alert("Something went wrong with the AJAX request.");
        }
    });
    return false;
}
