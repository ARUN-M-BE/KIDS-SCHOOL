<script data-cfasync="false" type="text/javascript">
    (function() {
        function validEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }

        function validateHuman(honeypot) {
            if (honeypot) {
                console.log("Robot Detected!");
                return true;
            } else {
                console.log("Welcome Human!");
            }
        }

        function getFormData(form) {
            var elements = form.elements;

            var fields = Object.keys(elements).filter(function(k) {
                return (elements[k].name !== "honeypot");
            }).map(function(k) {
                if (elements[k].name !== undefined) {
                    return elements[k].name;
                } else if (elements[k].length > 0) {
                    return elements[k].item(0).name;
                }
            }).filter(function(item, pos, self) {
                return self.indexOf(item) == pos && item;
            });

            var formData = {};
            fields.forEach(function(name) {
                var element = elements[name];
                formData[name] = element.value;
                if (element.length) {
                    var data = [];
                    for (var i = 0; i < element.length; i++) {
                        var item = element.item(i);
                        if (item.checked || item.selected) {
                            data.push(item.value);
                        }
                    }
                    formData[name] = data.join(', ');
                }
            });

            // add form-specific values into the data
            formData.formDataNameOrder = JSON.stringify(fields);
            formData.formGoogleSheetName = form.dataset.sheet || "sheet"; // default sheet name
            formData.formGoogleSendEmail = form.dataset.email || ""; // no email by default

            console.log(formData);
            return formData;
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            var form = event.target;
            var data = getFormData(form);
            if (data.email && !validEmail(data.email)) {
                var invalidEmail = form.querySelector(".email-invalid");
                if (invalidEmail) {
                    invalidEmail.style.display = "block";
                    return false;
                }
            } else {
                disableAllButtons(form);
                var url = form.action;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', url);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    console.log(xhr.status, xhr.statusText);
                    console.log(xhr.responseText);
                    var formElements = form.querySelector(".form-elements")
                    if (formElements) {
                        formElements.style.display = "none"; // hide form
                        //document.location.reload(true);
                    }
                    var thankYouMessage = form.querySelector(".thankyou_message");
                    if (thankYouMessage) {
                        thankYouMessage.style.display = "block";
                    }
                    return;
                };
                var encoded = Object.keys(data).map(function(k) {
                    return encodeURIComponent(k) + "=" + encodeURIComponent(data[k]);
                }).join('&');
                xhr.send(encoded);
            }
        }

        function loaded() {
            //event.preventDefault(); 
            console.log("Contact form submission handler loaded successfully.");
            var forms = document.querySelectorAll("form.gform");
            for (var i = 0; i < forms.length; i++) {
                forms[i].addEventListener("submit", handleFormSubmit, false);
            }
        };
        document.addEventListener("DOMContentLoaded", loaded, false);

        function disableAllButtons(form) {
            var buttons = form.querySelectorAll("button");
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = true;
            }
        }
    })();
</script>
</script>


<form method="POST" action="https://script.google.com/macros/s/AKfycbxACWX2mnAwy6DgshIDnz6qJqL4ThUKV7PvBRweTT_QbHZOaRhgdap5r5PPPcC-5KU/exec" name=".thankyou_message" id="contactForm" class="form">
    <div class="row">
        <!-- Name Field Starts -->
        <div class="col-md-6">
            <label for="FormControlName" class="form-label">Name <span class="required">*</span></label>
            <input type="text" class="form-control" id="FormControlName" placeholder="Name" name="user" >
            <!-- <span name="error" style="display:hide;" ><?php echo "Invalid name" ?></span>/ -->
        </div>
        <div class="col-md-6">
            <label for="FormControlEmail" class="form-label"> Email address <span class="required">*</span></label>
            <input type="email" class="form-control" id="FormControlEmail" placeholder="name@example.com" name="email" >
            <!-- <?php echo "Invalid email" ?> -->
        </div>
        <div class="col-md-6">
            <label for="FormControlphone" class="form-label">Phone <span class="required">*</span></label>
            <input type="tel" class="form-control" id="FormControlphone" placeholder="Phone" name="tele" >
        </div>
        <div class="col-md-6">
            <label for="FormControlSub" class="form-label">Subject <span class="required">*</span></label>
            <input type="text" class="form-control" id="FormControlSub" placeholder="Subject" name="sub" >
        </div>
        <div class="mb-3">
            <label for="FormControlTextarea" class="form-label">Message</label>
            <textarea class="form-control" id="FormControlTextarea" rows="3" name="message" ></textarea>
        </div>
        <!-- Message Field Ends -->
        <div class="col-sm-12">
            <button type="submit" name="new_patient" value="submit" class="btn btn-black">Submit</button>
        </div>
        <div class="thankyou_message" style="display: none; background: none; text-align: center; color: #26ac8b85; padding-bottom: 61px">
            <br><br>
            <p>Thanks for contacting us!</p>
            <h4>**Raglobalcity**</h4>
        </div>
    </div>
</form>

<style>
        /* Add your custom CSS styles here */
        .form-label {
            font-weight: bold;
        }

        .required {
            color: red;
        }

        .form-control {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        /* Add more custom styles as needed */
</style>



