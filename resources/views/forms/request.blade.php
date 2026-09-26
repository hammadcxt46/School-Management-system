<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form samples</title>
        <link
            rel="shortcut icon"
            href="{{ asset('images/logo.png') }}"
            type="image/x-icon"
        />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- W3 Css -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style type="text/css">
        body {
                font-family: 'Lato', sans-serif;
            }

            h1 {
                margin-bottom: 40px;
            }

            label {
                color: #333;
            }

            .btn-send {
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                width: 80%;
                margin-left: 3px;
                }
            .help-block.with-errors {
                color: #ff5050;
                margin-top: 5px;

            }

            .card{
                margin-left: 10px;
                margin-right: 10px;
            }

            input[type='text'],input[type='number'],input[type='password'],input[type='email'],textarea,select{
              background-color: #f2f2f2 !important;
              text-align:left;
              font-weight: 600;
              font-family: 'hervatica', cursive;
              font-size: 1.2em;
            }

            input[type='text'],input[type='number'],input[type='password'],input[type='email'], textarea{
            border-top:none;
            border-right:none;
            border-left: none;
            border-bottom: 2px dotted black;
            outline:none;
            font-size: 1.2em;
            }

            textarea:focus, input[type='text']:focus,input[type='number']:focus,input[type='password']:focus,input[type='email']:focus{
                  border-top:2px dotted #eee;
                  border-right:2px dotted #eee;
                  border-left:2px dotted #eee;
                  background:white !important;
                  outline: none;
                }

                .form-group >label{
                    font-weight: 600;
                }
            body{
                background: url({{ public_path('images/pattern.png') }}), #fffffff !important;
            }

            

    </style>
</head>
<body>

    <div class="container">
        <div class=" text-center mt-5 ">

            <h3>Let's help you draft your request...</h3>
                
            
        </div>

    
    <div class="row ">
      <div class="col-lg-7 mx-auto">
        <div class="card mt-2 mx-auto p-4 bg-light">
            <div class="card-body bg-light">
       
            <div class = "container">
            
            <form id="contact-form" method="post" action="{{ route('request.store') }}" role="form">
                @csrf
                @method('post')
            <div class="controls">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_name">My Name is:</label>
                            <input id="form_name" type="text" 
                            name="name" class="form-control" autofocus 
                            placeholder="e.g. Amina Kisura" required="required" data-error="Your Name is required.">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">My Phone Number is: </label>
                            <input id="phone" type="text"
                            onkeyup="stripnum('phone',10)" 
                             name="phone" class="form-control" placeholder="e.g. 0701222333 " required="required" data-error="Phone Number is required.">
                                                            </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_email">And my email is:</label>
                            <input id="form_email" type="email" 
                            name="email" class="form-control" 
                            placeholder="e.g. amaina@example.com " required="required" data-error="Your Email is required.">
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_need">I am looking for *</label>
                            <select id="form_need" name="purpose" class="form-control" required="required" data-error="Please specify your need.">
                                <option value="" selected disabled>--Select an option--</option>
                                <option value="Student placement">A student placement</option>
                                <option value="A Suggestion">A suggestion</option>
                                <option value="A Complaint">An urgent complaint</option>
                                <option value="Other">Something else...</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_message">Description *</label>
                            <textarea id="form_message" name="description" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, desribe your request."></textarea
                                >
                            </div>

                        </div>


                    <div class="col-md-12">
                        
                        <input type="submit" class="btn btn-success btn-send  pt-2 btn-block
                            w3-green w3-hover-orange w3-round-xxlarge" value="Submit" >
                    
                </div>
          
                </div>


        </div>
         </form>
        </div>
            </div>


    </div>
        <!-- /.8 -->

    </div>
    <!-- /.row-->

</div>
</div>

<footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
    /* Custom JS Scripts*/

    function stripnum(e,len)
    {
      //checks the length of the input
      var text0=document.getElementById(e).value;
      var text1=document.getElementById(e);
      if (text0.length<len+1) 
      {
        var Textf=document.getElementById(e);
        var repl= /[^0-9]/gi;
        Textf.value=Textf.value.replace(repl,"");

        /*if (!(/^\d+$/.test(Textf.value))) 
        {
          alert("Please enter numeric values only.");
        }*/
      }
      else
      {
        text1.value = text0.substr(0,len);
        alert("Oops! Your input is too long. Please check it again.");
        //slice();
      }
    };
  </script>
</footer>
</body>
</html>