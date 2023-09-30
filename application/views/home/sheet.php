
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
            .register .nav-tabs .nav-link:hover{
                border: none;
            }
            .btnSubmit
            {
                width: auto;
                border-radius: 1rem;
                padding: 1.5%;
                color: #fff;
                background-color: #03612e;
                border: none;
                cursor: pointer;
                color: rgb(246, 246, 252);
                margin-top: 4%;
            }
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
    </style>


    <form method="post" autocomplete="off" name="google-sheet">
    <div class="row register-form">
        <div class="form-group col-md-6">
            <label for="FormControlName" class="form-label">Name <span class="required">*</span></label>
            <input type="text" name="Name" class="form-control" placeholder="Your Name *" value="" >
        </div>
        <div class="form-group col-md-6">
            <label for="FormControlEmail" class="form-label"> Email address <span class="required">*</span></label>
            <input type="text" name="Email" class="form-control" placeholder="Your Email *" value="" >
        </div>
        <div class="form-group col-md-6">
            <label for="FormControlphone" class="form-label">Phone <span class="required">*</span></label>
            <input type="tele" name="Phone" class="form-control" placeholder="Your Contact Number *" value="" >
        </div>
        <div class="form-group col-md-6">
            <label for="FormControlSub" class="form-label">Subject <span class="required">*</span></label>
            <input type="text" name="subject" class="form-control" placeholder="subject *" value="" >
        </div>
        <div class="form-group mb-3">
            <label for="FormControlTextarea" class="form-label">Message</label>
            <textarea class="form-control" id="FormControlTextarea" rows="3" name="message" placeholder="Message " value=""></textarea>
        </div>
        <div class="form-group col-sm-6">
            <input type="submit" name="submit" class="btnSubmit btn-block" value="submit" />
        </div>
    </div>
    </form>

      
      <script>
        const scriptURL = 'https://script.google.com/macros/s/AKfycbwS5wbIdOaqJb67m2qL55yMvxfVVBsSmxK1FXQauejQI0DYltHl3yh8MtizIzkpFsk/exec'
            const form = document.forms['google-sheet']
          
            form.addEventListener('submit', e => {
              e.preventDefault()
                fetch(scriptURL, { method: 'POST', body: new FormData(form) })
                .then(response => {
                alert("Thanks for Contacting us..! We Will Contact You Soon...");
            // Reload the page after showing the alert
                window.location.reload();
                })
                .catch(error => {
                console.error('Error:', error);
            // Handle any errors here
                });
            })

          </script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
